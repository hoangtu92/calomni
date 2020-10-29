<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Host;
use App\Models\HostSoftware;
use App\Models\Software;
use App\Models\SoftwareTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\RegularExpression;

class SoftwareController extends Controller
{
    //
    public function list() {
        return Software::all();
    }

    public function sh_list(Request $request){

        $url = asset("/");

        $host = DB::table("host_software")
            ->join("hosts", "hosts.id", "=", "host_software.host_id")
            ->addSelect(DB::raw("(SELECT {$request->user()->id}) as user_id"))
            ->addSelect("host_software.software_id")
            ->addSelect("host_software.price")
            ->addSelect("host_software.executable")
            ->addSelect("host_software.note")
            ->where("hosts.user_id", "=", $request->user()->id);

        $software = DB::table("software")
            ->leftJoinSub($host, "host", "host.software_id", "=", "software.id")
            ->addSelect("software.id")
            ->addSelect("software.name")
            ->addSelect(DB::raw("CONCAT('{$url}', software.thumbnail) as thumbnail"))
            ->addSelect("host.user_id")
            ->addSelect("host.price")
            ->addSelect("host.executable")
            ->addSelect("host.note");

            if($request->filled("keyword")){
                $lowerKeyword = strtolower($request->keyword);
                $software->whereRaw("LEFT(software.name, 1) = '{$request->keyword}' OR LEFT(software.name, 1) = '{$lowerKeyword}'");
            }
            if($request->filled("search")){
                $software->where("software.name", "=", $request->search);
            }


        return $software->get();
    }

    public function detail ($id, Request $request) {
        return Software::find($id);
    }


    public function request_for_testing ($id, Request $request) {

        $request->validate([
            "token" => "required"
        ]);

        $software = Software::find($id);
        $host = Host::where("token", "=", $request->token)->first();

        if (!$host || !$software) {
            return null;
        }

        $hostSoftware = HostSoftware::where("software_id", $software->id)->where("host_id", $host->id)->first();

        if(!$hostSoftware){
            $hostSoftware = new HostSoftware([
                "software_id" => $software->id,
                "host_id" => $host->id
            ]);

            $hostSoftware->save();
        }

        //Send software command info to instruct host to test the software
        return $software;
    }

    public function submit_test_result ($id, Request $request){

        $request->validate([
            "token" => "required",
            "result" => "required"
        ]);

        $software = Software::find($id);
        $host = Host::where("token", "=", $request->token)->first();

        if (!$host || !$software) {
            return [
                "status" => false,
                "message" => "Host or software not exists"
            ];
        }

        //Get host-software relative entry
        $hostSoftware = HostSoftware::where("software_id", $software->id)->where("host_id", $host->id)->first();

        //Create software test for above related
        $softwareTest = new SoftwareTest([
            "host_software_id" => $hostSoftware->id,
            "result" => $request->result
        ]);

        //Check whether the test is success or not
        $expected_regex = preg_quote($software->expected, "/");
        $check = preg_match("/{$expected_regex}/", $request->result);

        if(!empty($software->not_expected)){
            $not_expected_regex = preg_quote($software->not_expected, "/");
            $check = $check && !preg_match("/{$not_expected_regex}/", $request->result);
        }

        $hostSoftware->executable = $check;
        if($check){
            $softwareTest->status = SoftwareTest::SUCCESS;
        }
        else{
            $softwareTest->status = SoftwareTest::FAILURE;
        }

        $hostSoftware->save();
        $softwareTest->save();

        return [
            "status" => $check,
            "result" => $request->result,
            "expected" => $software->expected,
            "not_expected" => $software->not_expected
        ];

    }

    public function update_price ($id, Request $request) {

        $request->validate([
            "token" => "required",
            "price" => "required"
        ]);

        $software = Software::find($id);
        $host = Host::where("token", "=", $request->token)->first();

        if (!$host || !$software) {
            return false;
        }

        $hostSoftware = HostSoftware::where("software_id", $software->id)->where("host_id", $host->id)->first();

        if ($hostSoftware) {
            $hostSoftware->price = $request->price;

            if($request->filled("note")){
                $hostSoftware->note = $request->note;
            }

            $hostSoftware->save();

            return $hostSoftware;
        }

        return false;

        //Return result
    }

    public function host_software($id){
        return DB::table("hosts")
            ->join("host_software", "hosts.id", "=", "host_software.host_id")
            ->select(DB::raw("hosts.*, price"))
            #->addSelect(DB::raw("DATE_FORMAT(TIMEDIFF(NOW(), last_active), '%H:%i:%s') as inactive_duration"))
            ->addSelect(DB::raw("IF(hosts.status = 'inactive', 'inactive', IF(DATE_FORMAT(TIMEDIFF(NOW(), last_active), '%H') >= 0 AND DATE_FORMAT(TIMEDIFF(NOW(), last_active), '%i') >= 1, 'inactive', 'active' )) as activity_status"))
            ->addSelect(DB::raw("CONCAT('[', (SELECT activity_status), '] ', hosts.os, ' | ', hosts.cpu_name, ' | Storage remains: ', ROUND(hosts.storage_free/1024/1024, 2), 'GB | RAM free: ', ROUND(hosts.mem_free/1024/1024, 2), 'GB') as host_info"))
            ->where("software_id", "=", $id)
            ->where("executable", "=", true)
            ->get()->toArray();
    }
}

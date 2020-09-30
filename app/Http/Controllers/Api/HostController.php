<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Host;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostController extends Controller
{
    public function create (Request $request) {
        $request->validate([
            'name' => "required",
            'os' => 'required',
            'cpu_name' => 'required',
            'cpu_freq' => "required",
            'cpu_cores' => "required",
            'mem_total' => "required",
            'mem_free' => "required",
            'storage_total' => "required",
            'storage_free' => "required",
            'info' => 'required',
            'mac' => 'required',
            "token" => "required"
        ]);

        $exists = Host::where("token", $request->token)->first();

        if($exists) return $exists;

        $host = new Host([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'os' => $request->os,
            'cpu_name' => $request->cpu_name,
            'cpu_freq' => $request->cpu_freq,
            'cpu_cores' => $request->cpu_cores,
            'mem_total' => $request->mem_total,
            'mem_free' => $request->mem_free,
            'storage_total' => $request->storage_total,
            'storage_free' => $request->storage_free,
            'info' => $request->info,
            'ip' => $request->getClientIp(),
            'mac' => $request->mac,
            "token" => $request->token
        ]);

        $host->save();

        return $host;

    }

    public function list (Request $request) {
        return Host::where("user_id", $request->user()->id)->get();
    }

    public function detail($token) {
        return Host::where("token", $token)->first();
    }
    public function update($token, Request $request) {

        $host = Host::where("token", $token)->first();

        if($host){
            if ($request->filled("status")) {
                $host->status = $request->status;
            }
            if ($request->filled("name")) {
                $host->name = $request->name;
            }

            if ($request->filled("status") || $request->filled("name")) {
                $host->save();
            }
        }


        return $host;
    }

    public function delete($token) {
        $host = Host::where("token", $token)->first();

        if ($host)
            $host->delete();

        return $host;
    }

    //Get all tasks assigned to current machine
    public function tasks(Request $request)
    {

        $request->validate([
            "token" => "required"
        ]);

        return DB::table("tasks")
            ->join("jobs", "jobs.id", "=", "tasks.job_id")
            ->join("hosts", "jobs.host_id", "=", "hosts.id")
            ->where("hosts.token", "=", $request->token)
            ->where("tasks.status", "=", Task::RUNNING)
            ->select(DB::raw("tasks.*, jobs.run_file"))
            ->get()->toArray();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Host;
use App\Models\Job;
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

    public function logs(Request $request){
        $tasks = DB::table("tasks")
            ->join("jobs", "jobs.id", "=", "tasks.job_id")
            ->join("hosts", "hosts.id", "=", "jobs.host_id")
            ->join("software", "software.id", "=", "jobs.software_id")
            ->addSelect("software.name as software_name")
            ->addSelect("jobs.status as status")
            ->addSelect(DB::raw("CONCAT(hosts.os, ' | ', hosts.cpu_name) as host_info"))
            ->addSelect(DB::raw("DATE_FORMAT(tasks.start, '%Y-%m-%d %H:%i:%s') as start"))
            ->addSelect(DB::raw("DATE_FORMAT(tasks.finish, '%Y-%m-%d %H:%i:%s') as finish"))
            ->addSelect(DB::raw("TIMEDIFF(tasks.finish, tasks.start) as duration"))
            ->addSelect(DB::raw("ROUND(tasks.cost, 0) as cost"))
            ->where("jobs.user_id", "=", $request->user()->id)
            ->whereNotIn("jobs.status", [Job::PENDING, Job::STOPPPED])
            ->orderBy("jobs.created_at")
            ->take(20)
            ->get()->toArray();

        return $tasks;
    }
}

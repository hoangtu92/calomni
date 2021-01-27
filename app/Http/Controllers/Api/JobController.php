<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FailedResponse;
use App\Http\Resources\SuccessResponse;
use App\Models\Host;
use App\Models\HostSoftware;
use App\Models\Job;
use App\Models\Task;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class JobController extends Controller
{
    //
    public function list(Request $request)
    {

        #$request->user()->last_active = now();
        #$request->user()->save();

        $url = url("jobs");

        $jobs = DB::table("jobs")
            ->leftJoin("tasks", "tasks.job_id", "=", "jobs.id")
            ->join("software", "software.id", "=", "jobs.software_id")
            ->join("hosts", "hosts.id", "=", "jobs.host_id")
            ->join("users", "users.id", "=", "jobs.user_id")
            ->join("host_software", "host_software.id", "=", "jobs.host_software_id")
            ->addSelect("jobs.id")
            ->addSelect("software.id as software_id")
            ->addSelect("hosts.id as host_id")
            ->addSelect(DB::raw("IF(hosts.status = 'inactive', 'inactive', IF(DATE_FORMAT(TIMEDIFF(NOW(), hosts.last_active), '%H') >= 0 AND DATE_FORMAT(TIMEDIFF(NOW(), hosts.last_active), '%i') >= 1, 'inactive', 'active' )) as host_activity_status"))
            ->addSelect("jobs.created_at")
            ->addSelect("jobs.status")
            ->addSelect("software.name as software_name")
            ->addSelect(DB::raw("CONCAT('Kernel: ', hosts.info, ' \nOS: ', hosts.os, ' \nCPU: ', hosts.cpu_name, ' \nStorage remains: ', ROUND(hosts.storage_free/1024/1024, 2), 'GB \nRAM available: ', ROUND(hosts.mem_free/1024/1024, 2), 'GB') as host_info"))
            ->addSelect(DB::raw("hosts.os as host_name"))
            ->addSelect("host_software.price as price")
            ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/', MD5(jobs.uid), '.zip') as file_url"))
            ->where("jobs.user_id", "=", $request->user()->id)
            ->where("jobs.status", "!=", Job::WAITING)
            ->distinct("jobs.id")
            ->orderByDesc("jobs.id")
            ->take(20)
            ->get();

        return new SuccessResponse($jobs);

        //return Job::where("user_id", $request->user()->id)->get();
    }

    public function detail($id, Request $request)
    {
        $url = url("jobs");

        $job = Job::leftJoin("tasks", "tasks.job_id", "=", "jobs.id")
            ->join("software", "software.id", "=", "jobs.software_id")
            ->join("hosts", "hosts.id", "=", "jobs.host_id")
            ->join("host_software", "host_software.software_id", "=", "software.id")
            ->join("users", "users.id", "=", "jobs.user_id")
            ->addSelect("jobs.created_at")
            ->addSelect("jobs.id")
            ->addSelect("jobs.status")
            ->addSelect("software.name as software_name")
            ->addSelect(DB::raw("CONCAT(hosts.os, ' | ', hosts.cpu_name) as host_info"))
            ->addSelect("host_software.price as price")
            ->addSelect(DB::raw("DATE_FORMAT(tasks.start, '%Y-%m-%d %H:%i:%s') as start"))
            ->addSelect(DB::raw("DATE_FORMAT(tasks.finish, '%Y-%m-%d %H:%i:%s') as finish"))
            ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/', MD5(jobs.uid), '.zip') as file_url"))
            ->addSelect(DB::raw("TIMEDIFF(tasks.finish, tasks.start) as duration"))
            ->where("jobs.id", "=", $id)->first();

        return new SuccessResponse($job);
    }

    public function create(Request $request)
    {

        if(!$request->filled("host_id") or !$request->filled("software_id") or !$request->filled("run_file")){
            $response = new FailedResponse([]);
            return $response->additional(["message" => "Error, missing data"]);
        }


        $hostSoftware = HostSoftware::where("host_id", $request->host_id)->where("software_id", $request->software_id)->first();

        if (!$hostSoftware || !$hostSoftware->executable) {
            $response = new FailedResponse($request);
            return $response->additional(["message" => "Host cannot run this software"])->response()->setStatusCode(400);
        }

        $uid = Str::uuid();


        $job = new Job([
            "uid" => $uid,
            "user_id" => $request->user()->id,
            "host_id" => $request->host_id,
            "software_id" => $request->software_id,
            "host_software_id" => $hostSoftware->id,
            "run_file" => $request->run_file,
            "status" => Job::WAITING
        ]);

        $job->save();

        return new SuccessResponse($job);

    }

    /**
     * @param $id
     * @param Request $request
     * @return FailedResponse|SuccessResponse|\Illuminate\Http\JsonResponse|object
     */
    public function upload_file($id, Request $request)
    {

        $job = Job::find($id);
        if ($job) {
            $user_dir = "/" . md5($job->user->uid);

            if (!Storage::exists($user_dir)) {
                Storage::makeDirectory($user_dir);
            }

            $putdata = fopen("php://input", "r");

            /* Open a file for writing */
            $fp = fopen(public_path() . "/jobs/" . $user_dir . "/" . md5($job->uid) . '.zip', "w");

            /* Read the data 1 KB at a time
               and write to the file */
            while ($data = fread($putdata, 1024))
                fwrite($fp, $data);

            /* Close the streams */
            fclose($fp);
            fclose($putdata);

            $job->status = Job::PENDING;
            $job->save();

            return new SuccessResponse($job);
        }
        return new FailedResponse($request->toArray());

    }

    public function assign_host($id, Request $request)
    {

        if(!$request->filled("host_id")){
            $response = new FailedResponse([]);
            return $response->additional(["message" => "Error, missing data"]);
        }

        $job = Job::find($id);

        if ($job) {


            $hostSoftware = HostSoftware::where("host_id", $request->host_id)->where("software_id", $job->software_id)->first();

            if (!$hostSoftware) {
                $response = new FailedResponse([]);
                return $response->additional(["message" => "Host cannot run this software\""]);
            }


            $job->host_id = $request->host_id;
            $job->host_software_id = $hostSoftware->id;
            $job->save();
        }

        return new SuccessResponse($job);
    }


    public function host_assignments(Request $request)
    {

        if(!$request->filled("token")){
            $response = new FailedResponse([]);
            return $response->additional(["message" => "Error, missing data"]);
        }

        $host = Host::where("token", "=", $request->token)->first();
        $host->last_active = now();
        $host->save();

        $request->user()->last_active = now();
        $request->user()->save();

        if ($host) {
            $url = url("jobs");
            $resource = DB::table("jobs")
                ->join("software", "software.id", "=", "jobs.software_id")
                ->join("users", "users.id", "=", "jobs.user_id")
                ->addSelect("jobs.id as job_id")
                ->addSelect("users.id as user_id")
                ->addSelect("jobs.uid as job_uid")
                ->addSelect("users.uid as users_uid")
                ->addSelect("software.id as software_id")
                ->addSelect("status")
                ->addSelect("run_file")
                ->selectRaw("IF(software.run_command IS NULL, CONCAT(' ./', jobs.run_file), CONCAT(software.run_command, ' ./', jobs.run_file) ) as command")
                ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/', MD5(jobs.uid), '.zip') as file_url"))
                ->addSelect(DB::raw("MD5(jobs.uid) as path"))
                ->where("host_id", "=", $host->id)
                ->where("jobs.status", "=", Job::PENDING)
                ->get();

            return new SuccessResponse($resource);
        }
        return new FailedResponse([]);
    }

    public function download_report($id)
    {
        $url = url("jobs");
        $job = Job::join("users", "users.id", "=", "jobs.user_id")
            ->join("hosts", "hosts.id", "=", "jobs.host_id")
            ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/reports/', MD5(CONCAT(jobs.uid, hosts.token)), '.zip') as file_url"))
            ->where("jobs.id", "=", $id)->first();

        return new SuccessResponse($job);
    }

    public function delete($id)
    {
        $job = Job::find($id);

        if ($job){
            $job->delete();
        }

        return new SuccessResponse($job);
    }

    //Get all tasks of a job
    public function tasks($id)
    {
        $job = Job::find($id);

        if ($job) {
            return new SuccessResponse($job->tasks);
        } else return new FailedResponse([]);
    }


    public function startJob($id, Request $request)
    {
        $job = Job::find($id);

        if ($job) {
            if ($job->status == Job::RUNNING) {
                $response = new FailedResponse([]);
                return $response->additional(["message" => "Job is already running"]);
            }

            $job->status = Job::PENDING;
            $job->log .= "RH started job at: " . now() . PHP_EOL;
            $job->save();
        }

        return new SuccessResponse($job);
    }

    public function stopJob($id)
    {
        $job = Job::find($id);

        if ($job) {
            $job->status = Job::STOPPPED;

            $runningTasks = Task::where('job_id', $job->id)->where('status', "=", Task::RUNNING)->orderByDesc("created_at")->first();
            if ($runningTasks) {
                $runningTasks->status = Task::STOPPED;
                $runningTasks->save();
            }

            $job->log .= "RH stopped job at: " . now() . PHP_EOL;
            $job->save();
        }
        return new SuccessResponse($job);
    }


    /**
     * @param $id
     * @param Request $request
     * @return FailedResponse|SuccessResponse
     */
    public function update_task($id, Request $request)
    {

        if(!$request->filled("status")){
            $response = new FailedResponse([]);
            return $response->additional(["message" => "Error, missing data"]);
        }

        $job = Job::find($id);

        if (!$job) {
            $response = new FailedResponse([]);
            return $response->additional(["message" => "Job is removed or not exists"]);
        }

        if(in_array($job->status, [Job::STOPPPED, Job::PENDING]) && in_array($request->status, [Job::COMPLETED, Job::FAILED])){
            $response = new FailedResponse([]);
            return $response->additional(["message" => "Job has finished"]);
        }

        $job->status = $request->status;
        $job->save();

        $task = Task::where("job_id", "=", $id)
            ->where("status", "=", Task::RUNNING)
            ->first();

        if (!$task) {
            //Todo with payment/price of task
            $task = new Task([
                "job_id" => $id,
                "cost" => $job->hostSoftware->price,
                "ip" => $request->getClientIp(),
                "status" => Task::RUNNING,
                'start' => now()
            ]);
        } else {

            $task->status = $request->status;

            if ($request->hasFile("data")) {


                $job_result_dir = "/" . md5($job->user->uid) . "/reports/";

                if (!Storage::exists($job_result_dir)) {
                    Storage::makeDirectory($job_result_dir);
                }

                $request->file("data")->storeAs($job_result_dir, md5($job->uid.$job->host->token).".zip");
                $task->finish = now();
            }
        }

        $task->save();


        return new SuccessResponse($task);


    }

}

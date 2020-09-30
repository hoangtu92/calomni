<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Host;
use App\Models\HostSoftware;
use App\Models\Job;
use App\Models\Task;
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

        $url = url("jobs");

        $jobs = DB::table("jobs")
            ->leftJoin("tasks", "tasks.job_id", "=", "jobs.id")
            ->join("software", "software.id", "=", "jobs.software_id")
            ->join("hosts", "hosts.id", "=", "jobs.host_id")
            ->join("host_software", "host_software.software_id", "=", "software.id")
            ->join("users", "users.id", "=", "jobs.user_id")
            ->addSelect("jobs.created_at")
            ->addSelect("jobs.id")
            ->addSelect("jobs.status")
            ->addSelect("software.name as software_name")
            ->addSelect("hosts.info as host_info")
            ->addSelect("host_software.price as price")
            ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/', MD5(jobs.uid), '.zip') as file_url"))
            ->where("jobs.user_id", "=", $request->user()->id)
            ->orderByDesc("tasks.created_at")
            ->get();

        return $jobs;

        //return Job::where("user_id", $request->user()->id)->get();
    }

    public function detail($id)
    {
        return Job::find($id);
    }

    public function create(Request $request)
    {

        $request->validate([
            "host_id" => "required",
            "software_id" => "required",
            "run_file" => "required"
        ]);

        $hostSoftware = HostSoftware::where("host_id", $request->host_id)->where("software_id", $request->software_id)->first();

        if (!$hostSoftware) return [
            "status" => false,
            "message" => "Host cannot run this software"
        ];

        $user_dir = "/" . md5($request->user()->uid);

        if (!Storage::exists($user_dir)) {
            Storage::makeDirectory($user_dir);
        }

        $uid = Str::uuid();


        if (!$request->file('run_file')->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }

        $zipFileName = md5($uid).'.zip';
        $zip = new ZipArchive();

        $zip->open( public_path()."/jobs/".$user_dir."/" .$zipFileName, ZipArchive::CREATE);

        $zip->addFile($request->file("run_file")->path(), $request->file('run_file')->getClientOriginalName() ); //where the file needs to be add to archive
        if ($request->hasfile('other_files')) {
            foreach ($request->file('other_files') as $other_file) {
                $zip->addFile($other_file->path(), $other_file->getClientOriginalName() );
            }
        }

        # Log::info(json_encode($zip));
        $zip->close();


        /*$job_dir = $user_dir . "/" . md5($uid) . "/";

        if (!Storage::exists($job_dir)) {
            Storage::makeDirectory($job_dir);
        }

        $request->file('run_file')->storeAs($job_dir, $request->file('run_file')->getClientOriginalName());
        if ($request->hasfile('other_files')) {
            $files = $request->file('other_files');
            foreach ($files as $other_file) {
                $other_file->storeAs($job_dir, $other_file->getClientOriginalName());
            }
        }*/

        $job = new Job([
            "uid" => $uid,
            "user_id" => $request->user()->id,
            "host_id" => $request->host_id,
            "software_id" => $request->software_id,
            "host_software_id" => $hostSoftware->id,
            "run_file" => $request->file('run_file')->getClientOriginalName(),
            "status" => Job::RUNNING
        ]);

        $job->save();

        return $job;

    }

    public function assign_host($id, Request $request)
    {

        $request->validate([
            "host_id" => "required"
        ]);

        $job = Job::find($id);

        if ($job) {


            $hostSoftware = HostSoftware::where("host_id", $request->host_id)->where("software_id", $job->software_id)->first();

            if (!$hostSoftware) return [
                "status" => false,
                "message" => "Host cannot run this software"
            ];


            $job->host_id = $request->host_id;
            $job->save();
        }

        return $job;
    }

    public function upload_file($id, Request $request)
    {

        $job = Job::find($id);

        if (!$job) return false;

        $user_dir = public_path()."/jobs/" . md5($request->user()->uid);
        $job_dir = $user_dir . "/" . md5($job->uid);

        if ($request->hasFile('run_file')) {
            $runFile = $request->file('run_file');
            if (!$runFile->isValid()) {
                return response()->json(['invalid_file_upload'], 400);
            }
            $runFile->move($job_dir, $runFile->getClientOriginalName());

            $job->run_file = $runFile->getClientOriginalName();

            $job->save();
        }

        if ($request->hasfile('other_files')) {
            foreach ($request->file('other_files') as $other_file) {
                $other_file->move($job_dir, $other_file->getClientOriginalName());
            }
        }

        return $job;

    }

    public function host_assignments(Request $request)
    {
        $request->validate([
            "token" => "required"
        ]);

        $host = Host::where("token", "=", $request->token)->first();

        if ($host) {
            $url = url("jobs");
            return DB::table("jobs")
                ->join("software", "software.id", "=", "jobs.software_id")
                ->join("users", "users.id", "=", "jobs.user_id")
                ->addSelect("jobs.id as job_id")
                ->addSelect("users.id as user_id")
                ->addSelect("jobs.uid as job_uid")
                ->addSelect("users.uid as users_uid")
                ->addSelect("software.id as software_id")
                ->addSelect("status")
                ->addSelect("run_file")
                ->selectRaw("CONCAT(software.run_command, ' ./', jobs.run_file) as command")
                ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/', MD5(jobs.uid), '.zip') as file_url"))
                ->where("host_id", "=", $host->id)->get();
        }
        return [];
    }

    public function download_report($id){
        $url = url("jobs");
        $job = Job::join("users", "users.id", "=", "jobs.user_id")
            ->addSelect(DB::raw("CONCAT('{$url}/', MD5(users.uid), '/', MD5(jobs.uid), '.zip') as file_url"))
            ->where("jobs.id", "=", $id)->first();

        return $job->toArray();
    }

    public function report($id, Request $request){
        $request->validate([
            "status" => "required"
        ]);

        $job = Job::find($id);
        if($job){
            $job->status = $request->status;
            $job->save();
        }

        $job_dir = "/" . md5($job->user->uid)."/";

        if($request->hasFile("data")){
            $request->file("data")->storeAs($job_dir, $request->file('data')->getClientOriginalName());
        }

        return $job;

    }

    public function delete($id)
    {
        $job = Job::find($id);

        if ($job)
            $job->delete();

        return $job;
    }

    //Get all tasks of a job
    public function tasks($id)
    {
        $job = Job::find($id);

        if ($job) {
            return $job->tasks;
        } else return [];
    }

    public function startJob($id, Request $request)
    {
        $job = Job::find($id);

        if ($job->status == Job::RUNNING) {
            return [
                "status" => false,
                "message" => "There is task already running"
            ];
        }

        //Todo with payment/price of task

        //Create a new task
        $task = new Task([
            "job_id" => $job->id,
            "cost" => $job->hostSoftware->price,
            "ip" => $request->getClientIp(),
            "status" => Task::RUNNING
        ]);
        $task->save();

        $job->status = Job::RUNNING;
        $job->log .= "RH started job at: " . now() . PHP_EOL;
        $job->save();

        return $job;
    }

    public function stopJob($id, Request $request)
    {
        $job = Job::find($id);

        $job->status = Job::PENDING;

        $runningTasks = Task::where('job_id', $job->id)->where('status', "=", Task::RUNNING)->orderByDesc("created_at")->first();
        $runningTasks->status = Task::STOPPED;
        $runningTasks->save();

        $job->log .= "RH stopped job at: " . now() . PHP_EOL;
        $job->save();
    }
}

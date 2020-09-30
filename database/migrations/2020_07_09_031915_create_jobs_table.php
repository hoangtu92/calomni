<?php

use App\Models\Job;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->uuid("uid")->unique();

            $table->foreignId("user_id");
            $table->foreign("user_id")->references("id")->on("users");

            $table->foreignId("host_id");
            $table->foreign("host_id")->references("id")->on("hosts");

            $table->foreignId("software_id");
            $table->foreign("software_id")->references("id")->on("software");

            $table->foreignId("host_software_id");
            $table->foreign("host_software_id")->references("id")->on("host_software");

            $table->string("run_file")->nullable(false)->comment("runs file");

            $table->longText("log")->nullable(true)->comment("job log");

            $table->enum("status", [Job::PENDING, Job::FAILED, Job::RUNNING, Job::COMPLETED])->default(Job::PENDING);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}

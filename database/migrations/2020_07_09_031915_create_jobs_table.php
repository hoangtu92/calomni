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
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');

            $table->foreignId("host_id");
            $table->foreign("host_id")->references("id")->on("hosts")->onDelete('cascade');;

            $table->foreignId("software_id");
            $table->foreign("software_id")->references("id")->on("software")->onDelete('cascade');

            $table->foreignId("host_software_id");
            $table->foreign("host_software_id")->references("id")->on("host_software")->onDelete('cascade');

            $table->string("run_file")->nullable(true)->comment("runs file");

            $table->longText("log")->nullable(true)->comment("job log");

            $table->enum("status", [Job::WAITING, Job::PENDING, Job::FAILED, Job::RUNNING, Job::COMPLETED, Job::STOPPPED])->default(Job::WAITING);

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

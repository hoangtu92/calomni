<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId("job_id");
            $table->foreign('job_id')->references("id")->on("jobs")->onDelete('cascade');

            $table->decimal("cost")->default(0);

            $table->enum("status", [Task::FAILED, Task::RUNNING, Task::COMPLETED, Task::STOPPED])->default(Task::RUNNING);
            $table->dateTime("start")->default(now());
            $table->dateTime("finish")->nullable(true);

            $table->text("result")->nullable(true);
            $table->string("ip")->nullable(true);

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
        Schema::dropIfExists('tasks');
    }
}

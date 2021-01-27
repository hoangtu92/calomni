<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("host_id");
            $table->foreign("host_id")->references("id")->on("hosts")->onDelete("cascade");

            $table->foreignId("notification_id")->nullable(true);
            $table->foreign("notification_id")->references("id")->on("notifications")->onDelete("cascade");
            $table->boolean("unread")->default(true);
            $table->text("message")->nullable(true);
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
        Schema::dropIfExists('messages');
    }
}

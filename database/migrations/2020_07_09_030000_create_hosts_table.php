<?php

use App\Models\Host;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->string("token")->unique()->comment("MD5 encrypted token is a result of combination of CPU ID, MAC address, HDD Serial ID");
            $table->string("name", 45);
            $table->string("os", 45);
            $table->string("ip", 24);
            $table->string("cpu_name", 50);
            $table->decimal("cpu_freq", 10);
            $table->integer("cpu_cores");
            $table->bigInteger("storage_total");
            $table->bigInteger("storage_free");
            $table->bigInteger("mem_total");
            $table->bigInteger("mem_free");
            $table->text("info");
            $table->timestamp("last_active");
            $table->enum("status", [Host::INACTIVE, Host::ACTIVE])->default(Host::ACTIVE);
            $table->string("mac")->unique();

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
        Schema::dropIfExists('hosts');
    }
}

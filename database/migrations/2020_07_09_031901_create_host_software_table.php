<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('host_software', function (Blueprint $table) {
            $table->id();
            $table->foreignId("software_id");
            $table->foreign("software_id")->references("id")->on("software");

            $table->foreignId("host_id");
            $table->foreign("host_id")->references("id")->on("hosts");

            $table->bigInteger("price")->default(0);
            $table->string("note")->nullable(true);

            $table->boolean("executable")->default(false);

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
        Schema::dropIfExists('host_software');
    }
}

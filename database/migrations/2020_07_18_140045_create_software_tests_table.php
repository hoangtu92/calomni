<?php

use App\Models\SoftwareTest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("host_software_id")->comment("Each host might has many test on a software");
            $table->foreign("host_software_id")->references("id")->on("host_software");
            $table->text("result")->nullable(true);
            $table->enum("status", [SoftwareTest::WAITING, SoftwareTest::FAILURE, SoftwareTest::SUCCESS])->default(SoftwareTest::WAITING);
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
        Schema::dropIfExists('software_tests');
    }
}

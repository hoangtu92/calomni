<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid("uid")->unique()->default(Str::uuid());
            $table->string('name')->nullable(true);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(true);

            $table->enum("login_status", [User::INACTIVE, User::ACTIVE])->default(User::INACTIVE);
            $table->enum("activation_status", [User::ACTIVATED, User::PENDING])->default(User::PENDING);

            $table->enum("role", [User::SH, User::RH, User::ADMIN])->default(User::RH);

            $table->dateTime("last_login")->nullable(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');                   // name will be pulled from azure
            $table->string('email')->unique();        // users do need to provide email upon registration
            $table->string('password')->nullable();   // users can later set a password in case of azure failure
            $table->string('azure_id')->unique();     // initial registration
            $table->boolean('active')->default(0);    // users need admin approval after initial registration
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

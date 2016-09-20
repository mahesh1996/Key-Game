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
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('enrollment')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('wpm_start_time',100)->nullable();
            $table->string('wpm_end_time',100)->nullable();
            $table->string('wpm_completed_word',100)->nullable();
            $table->double('score',15,8)->default(0);
            $table->boolean('started');
            $table->timestamp('started_on')->nullable();
            $table->timestamp('ended_on')->nullable();
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
        Schema::drop('users');
    }
}

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
        Schema::create('users', function (Blueprint $table){
            $table->bigIncrements('id');

            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug')->unique();
            $table->string('avatar');
            $table->text('bio');
            $table->string('location');

            $table->unsignedBigInteger('allowed_space')->default(10737418240);
            $table->string('dropbox_token', 64)->nullable();

            $table->string('password');
            $table->string('confirmation_code')->nullable();
            $table->boolean('confirmed')->default(false);

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

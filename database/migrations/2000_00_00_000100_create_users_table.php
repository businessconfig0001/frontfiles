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

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            $table->string('google_clientId')->nullable();
            $table->string('google_clientSecret')->nullable();
            $table->string('google_refreshToken')->nullable();
            $table->string('google_folderId')->nullable();

            $table->string('dropbox_token')->nullable();
            $table->string('dropbox_app_name')->nullable();

            $table->unsignedBigInteger('allowed_space')->default(10737418240);

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

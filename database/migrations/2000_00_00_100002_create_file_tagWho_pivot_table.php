<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTagWhoPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_tagwho', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->index();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('tagwho_id')->index();
            $table->foreign('tagwho_id')->references('id')->on('tagswho')->onDelete('cascade');
            $table->primary(['file_id', 'tagwho_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file_tagwho');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTagWhatPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_tagwhat', function (Blueprint $table) {
            $table->unsignedBigInteger('file_id')->index();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('tagwhat_id')->index();
            $table->foreign('tagwhat_id')->references('id')->on('tagswhat')->onDelete('cascade');
            $table->primary(['file_id', 'tagwhat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file_tagwhat');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->integer('month');
            $table->integer('year');
            $table->unsignedBigInteger('type_file_id');
            $table->foreign('type_file_id')->references('id')->on('type_files')->onDelete('cascade');
            $table->string('comments')->nullable();
            $table->string('other')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
};

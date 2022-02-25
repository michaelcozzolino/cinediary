<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_movie', function (Blueprint $table) {
            $table->unsignedBigInteger('diary_id');
            $table
                ->foreign('diary_id')
                ->references('id')
                ->on('diaries')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedBigInteger('movie_id');
            $table
                ->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('diary_movie');
    }
};

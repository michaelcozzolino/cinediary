<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiarySeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_series', function (Blueprint $table) {
            $table->unsignedBigInteger('diary_id');
            $table->foreign('diary_id')->references('id')->on('diaries')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('series_id');
            $table->foreign('series_id')->references('id')->on('series')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('diary_series');
    }
}

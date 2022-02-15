<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('title');
            $table->string('originalTitle');
            $table->string('genre')->nullable();
            $table->string('posterPath')->nullable();
            $table->string('backdropPath')->nullable();
            $table->text('overview');
            $table->date('releaseDate');
            $table->unsignedInteger('runtime')->default(0);
            $table->boolean('isPopular');
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
        Schema::dropIfExists('series');
    }
}

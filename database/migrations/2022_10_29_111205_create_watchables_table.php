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
        Schema::create('watchables', function (Blueprint $table) {
            $table->unsignedBigInteger('diary_id');
            $table->foreign('diary_id')
                  ->references('id')
                  ->on('diaries')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->unsignedBigInteger('watchable_id');
            $table->string('watchable_type'); /** TODO: maybe restrict type */
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
        Schema::dropIfExists('watchables');
    }
};

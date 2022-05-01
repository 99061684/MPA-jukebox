<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('artist')->nullable()->default(null);
            $table->string('band')->nullable()->default(null);
            $table->string('album')->nullable()->default(null);
            $table->time('duration');
            $table->string('song_path');
            $table->bigInteger('genre_id')->unsigned();
            $table->string('unique_hash')->unique();
            $table->timestamps();

            $table->foreign('genre_id')->references('id')->on('genres')->onUpdate(
                'cascade'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}

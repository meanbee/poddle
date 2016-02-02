<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->unsignedInteger('podcast_id');
            $table->string('link');
            $table->string('name');
            $table->string('description');
            $table->string('author');
            $table->string('image');
            $table->dateTime('build_date');
            $table->string('category');
            $table->timestamps();

            $table->foreign('podcast_id')->references('id')->on('podcasts');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rss');
    }
}

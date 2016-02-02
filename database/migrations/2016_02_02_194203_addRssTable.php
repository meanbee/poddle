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
            $table->string('url')->unique();
            $table->unsignedInteger('podcast_id')->nullable();
            $table->string('link')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('author')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('build_date')->nullable();
            $table->string('category')->nullable();
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

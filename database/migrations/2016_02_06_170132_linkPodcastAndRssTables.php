<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkPodcastAndRssTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rss', function (Blueprint $table) {
            $table->dropForeign('rss_podcast_id_foreign');
            $table->removeColumn('podcast_id');
        });

        Schema::table('podcasts', function (Blueprint $table) {
            $table->unsignedInteger('rss_id')->nullable();
            $table->foreign('rss_id')->references('id')->on('rss');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rss', function (Blueprint $table) {
            $table->foreign('podcast_id')->references('id')->on('podcast');
            $table->unsignedInteger('podcast_id')->nullable();
        });

        Scheme::table('podcasts', function (Blueprint $table) {
            $table->removeColumn('rss_id');
            $table->dropForeign('podcast_rss_id_foreign');
        });
    }
}

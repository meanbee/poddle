<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPodcastFieldsFromRssFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('podcasts', function (Blueprint $table) {
            $table->string('guid')->nullable();
            $table->string('original_file_type')->nullable();
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('published_date')->nullable();
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('podcasts', function (Blueprint $table) {
            $table->removeColumn('guid');
            $table->removeColumn('original_file_type');
            $table->removeColumn('author');
            $table->removeColumn('description');
            $table->removeColumn('published_date');
            $table->removeColumn('link');
        });
    }
}

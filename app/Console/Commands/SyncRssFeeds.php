<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Rss\RefreshFeed;

class SyncRssFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'podcast:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Podcast Feeds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var RefreshFeed $refreshFeed */
        $refreshFeed = new RefreshFeed();
        $refreshFeed->run();
    }
}

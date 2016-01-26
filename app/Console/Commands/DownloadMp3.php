<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Podcasts\DownloadMp3 as DownloadModel;

class DownloadMp3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'podcast:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download podcast';

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
        $download = new DownloadModel();
        $download->run();
    }
}

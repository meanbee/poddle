<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DownloadConvertUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'podcast:download-convert-upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads episode, converts to opus and converts speech to text';

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
        $this->info('Downloading Podcasts');
        $this->call('podcast:download');

        $this->info('Converting episodes to opus');
        $this->call('podcast:convertToOpus');

        $this->info('Converting text to speech');
        $this->call('ibm:speechToText');
    }
}

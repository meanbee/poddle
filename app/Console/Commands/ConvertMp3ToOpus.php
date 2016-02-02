<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Podcasts\ConvertMp3ToOpus as ConversionModal;

class ConvertMp3ToOpus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'podcast:convertToOpus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert podcast and convert to mp3';

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
        $conversionModel = new ConversionModal();
        $conversionModel->run();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WeatherFetcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:weatherdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulling weather data from 3rd party source';

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
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}

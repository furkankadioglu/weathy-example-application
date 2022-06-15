<?php

namespace App\Console\Commands;

use App\Jobs\FetchWeatherDataJob;
use App\Models\City;
use Carbon\Carbon;
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

        $cities = City::all();

        $this->info("[".$this->getNow()."] Fetch process has been started.", 'v');

        $this->withProgressBar($cities, function($city) {
            FetchWeatherDataJob::dispatch($city);
        });

        $this->line('');
        $this->info("[".$this->getNow()."] Fetch process has been completed.", 'v');
    }

    private function getNow()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return $now;
    }
}

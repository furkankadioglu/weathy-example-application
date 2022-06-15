<?php

namespace App\Jobs;

use App\Events\FetchFailed;
use App\Models\City;
use App\Models\WeatherData;
use App\Sources\OpenWeatherDataSource;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Response;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchWeatherDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * City eloquent model
     * 
     * @var \App\Models\City
     */
    protected City $city;

    /**
     * Weather Data eloquent model
     *
     * @var \App\Models\WeatherData
     */
    protected WeatherData $weatherData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(City $city)
    {
        $this->city = $city;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OpenWeatherDataSource $fetcher)
    {
        $data = $fetcher->setCity($this->city)->fetch();
        
        if($data["cod"] != Response::HTTP_OK)
        {
            FetchFailed::dispatch($this->city);
            throw new Exception("Fetch process failed");
        }

        $now = Carbon::now();

        $findFilters = [
            "city_id" => $this->city->id,
            "date" => $now->format('Y-m-d')
        ];

        $weatherData = WeatherData::updateOrCreate($findFilters, [
            "city_id" => $this->city->id,
            "date" => $now->format('Y-m-d'),
            "data" => json_encode($data)
        ]);

        $this->weatherData = $weatherData;

    }

    public function getWeatherData() : WeatherData
    {
        return $this->weatherData;
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Resources\WeatherDataResource;
use App\Jobs\FetchWeatherDataJob;
use App\Models\City;
use App\Models\WeatherData;
use App\Sources\OpenWeatherDataSource;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WeatherController extends ApiController
{
    /**
     * Get weather results
     *
     * @param OpenWeatherDataSource $fetcher
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWeather(OpenWeatherDataSource $fetcher, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' =>       'required|date',
            'city_name' =>  'required|exists:App\Models\City,name'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        } 
        
        $now = Carbon::now();
        $city = City::whereName(request()->city_name)->firstOrFail();
        $date = request()->date;

        $cachedWeatherData = Cache::get("weather_{$city->name}_{$date}");

        if($cachedWeatherData)
        {
            return $cachedWeatherData;
        }

        $weatherData = WeatherData::whereCityId($city->id)->where('date', $date)->first();
        if($weatherData)
        {
            return Cache::remember("weather_{$city->name}_{$date}", 10, function() use ($weatherData) {
                return $this->respondWithData(new WeatherDataResource($weatherData));
            });
        }
        
        /* 
         * Note:    I couldn't find OpenWeatherAPI historical endpoint (I guess it's premium)
         *          that's why, it's working with only for today but I can easily upgrade.
        */
        if($date == $now->format('Y-m-d'))
        {
            try
            {
                $fetcherJob = new FetchWeatherDataJob($city);
                $fetcherJob->handle($fetcher);
                $weatherData = $fetcherJob->getWeatherData();
            
                return Cache::remember("weather_{$city->name}_{$date}", 10, function() use ($weatherData) {
                    return $this->respondWithData(new WeatherDataResource($weatherData));
                });
            }
            catch(\Exception $e)
            {
                return $this->respondWithError('Date is not available.');
            }
        }

        return $this->respondWithError('Date is not available.');
    }
}

<?php 
namespace App\Sources;

use App\Models\City;
use GuzzleHttp\Client;

final class OpenWeatherDataSource implements BaseSource {

    /**
     * Guzzle client
     *
     * @var \GuzzleHttp\Client
     */
    protected Client $client;

    /**
     * City eloquent model
     * 
     * @var \App\Models\City
     */
    protected City $city;

    /**
     * Base API endpoint
     */
    const BASE_URL = "https://api.openweathermap.org/data";

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Set City to Source
     *
     * @param City $city
     * @return self
     */
    public function setCity(City $city) : self 
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Fetch data from 3rd Party API
     *
     * @return array
     */
    public function fetch() : array
    {
        $url = $this::BASE_URL."/2.5/weather?lat={$this->city->latitude}&lon={$this->city->longitude}&appid=".config('weathy.openweathermap_key');

        $response = $this->client->get($url);

        return json_decode($response->getBody()->getContents(), true);
        
    }
}
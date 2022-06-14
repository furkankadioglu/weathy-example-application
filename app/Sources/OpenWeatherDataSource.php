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
     * Requested weather date
     * @var string
     */
    protected string $date;

    /**
     * Base API endpoint
     */
    const BASE_URL = "https://api.openweathermap.org/data";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function setDate(string $date) : self
    {
        $this->date = $date;
        return $this;
    }

    public function setCity(City $city) : self 
    {
        $this->city = $city;
        return $this;
    }

    public function fetch() : array
    {
        $url = $this::BASE_URL."/2.5/weather?lat={$this->city->latitude}&lon={$this->city->longitude}&appid=".config('weathy.openweathermap_key');

        $response = $this->client->get($url);

        return json_decode($response->getBody()->getContents(), true);
        
    }
}
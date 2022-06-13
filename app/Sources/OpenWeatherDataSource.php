<?php 
namespace App\Sources;

use GuzzleHttp\Client;

final class OpenWeatherDataSource extends BaseSource {

    /**
     * Guzzle client
     *
     * @var \GuzzleHttp\Client
     */
    protected Client $client;

    /**
     * Requested weather date
     * @var string
     */
    protected string $date;

    /**
     * Base API endpoint
     */
    const BASE_URL = "https://api.openweathermap.org/data/";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function setDate(string $date) : self
    {
        $this->date = $date;
        return $this;
    }

    public function fetch()
    {

    }
}
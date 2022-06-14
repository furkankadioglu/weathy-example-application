<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tokyo = new City;
        $tokyo->name = "Tokyo";
        $tokyo->latitude = 35.64472997787036;
        $tokyo->longitude = 139.7415471688272;
        $tokyo->save();

        $london = new City;
        $london->name = "London";
        $london->latitude = 51.483338241906374;
        $london->longitude = -0.11670485097623286;
        $london->save();

        $paris = new City;
        $paris->name = "Paris";
        $paris->latitude = 48.862447552342196;
        $paris->longitude = 2.3552733042262033;
        $paris->save();

        $berlin = new City;
        $berlin->name = "Berlin";
        $berlin->latitude = 52.50132785970817;
        $berlin->longitude = 13.385587701297597;
        $berlin->save();

        $newYork = new City;
        $newYork->name = "New York";
        $newYork->latitude = 40.71562159378648;
        $newYork->longitude = -74.00234696317396;
        $newYork->save();
    }
}

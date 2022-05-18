<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function index()
    {
        // $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

        // dd($posts);

        $data = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => 'gaza',
            'units' => 'metric',
            'appid' => 'dccab945679f3bb9019537a309e05e47',
            'lang' => 'ar'
        ])->json();

        $image = 'http://openweathermap.org/img/wn/'.$data["weather"][0]["icon"].'@2x.png';

        // dd($data['weather'][0]['icon']);

        return redirect()->away($image);
    }
}

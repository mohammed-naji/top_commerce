<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return [
            'name' => 'Mohammed Naji',
            'email' => 'malqumbuz@gmail.com',
            'phone' => '0592418889'
        ];
    }

    public function index2()
    {
        return [
            'name' => 'Mohammed Naji',
            'email' => 'malqumbuz@gmail.com',
            'phone' => '0592418889',
            'image' => 'ddddd'
        ];
    }
}

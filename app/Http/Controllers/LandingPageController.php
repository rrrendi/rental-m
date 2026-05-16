<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->take(6)->get();
        return view('welcome', compact('cars'));
    }
}
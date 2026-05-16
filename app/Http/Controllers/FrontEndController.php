<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
        // Menampilkan 6 mobil terbaru untuk landing page
        $cars = Car::latest()->take(6)->get();
        return view('welcome', compact('cars'));
    }
}
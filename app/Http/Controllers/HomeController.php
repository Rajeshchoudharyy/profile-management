<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $sliders = Slider::where('active', true)->get();
        $profiles = User::where('is_admin', false)->get();
        
        return view('home', compact('sliders', 'profiles'));
    }
}
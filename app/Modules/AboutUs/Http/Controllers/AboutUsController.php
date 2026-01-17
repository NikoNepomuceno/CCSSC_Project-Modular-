<?php

namespace App\Modules\AboutUs\Http\Controllers;

use Illuminate\Routing\Controller;

class AboutUsController extends Controller
{
    public function index()
    {
        return view('about-us::index');
    }
}
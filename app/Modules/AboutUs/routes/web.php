<?php

use App\Modules\AboutUs\Http\Controllers\AboutUsController;
use Illuminate\Support\Facades\Route;

Route::get('/about-us', [AboutUsController::class, 'index'])->name('aboutus.index');
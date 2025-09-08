<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;

Route::get('/top-customers', [CustomerController::class, 'getTopCustomers']);

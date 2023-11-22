<?php

use App\ATDW\Models\Region;
use App\ATDW\Services\Products;
use App\ATDW\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/area-city-map', static fn(): array => (new Products())->getAllAreasSuburbsByRegion(
    Region::fromStateAndArray(State::NSW, config('params.Greater Sydney Region'))
));

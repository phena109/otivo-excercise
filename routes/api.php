<?php

use App\ATDW\Models\Region;
use App\ATDW\SearchBy;
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

Route::get('/area-city-map', static fn(): array => (new Products())->getAllAreasSuburbsByRegion(
    Region::fromStateAndArray(State::NSW, config('params.Greater Sydney Region'))
));

Route::get('/products', static function(Request $request) {
    $by = SearchBy::API_QS[$request->get('by')] ?? SearchBy::Area;
    $value = $request->get('value');
    $productsService = new Products();
    $result = $productsService->getProducts($by, $value, forceRefresh: true);
    $products = $result['data'];
    // @todo a bit stupid to do conversion here
    foreach ($products as $index => $product)
    {
        $result['data'][$index] = $product->toArray();
        foreach ($product->getAddresses() as $i => $address) {
            $result['data'][$index]['addresses'][$i] = $address->toArray();
        }
    }
    return $result;
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/products', function () {
    return Product::select(
        'id',
        'category_id',
        'subcategory_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'product_code',
        'stock',
        'regular_price',
        'sale_price',
        'discount',
        'thumbnail',
        'featured',
        'status'
    )->get();
});

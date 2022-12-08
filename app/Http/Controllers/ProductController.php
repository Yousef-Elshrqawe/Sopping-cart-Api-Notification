<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Http\Resources\ProductCollection as ProductCollection;
use App\Http\Resources\ProductResource as ProductResource;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return new ProductCollection(Product::paginate(10));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }




}

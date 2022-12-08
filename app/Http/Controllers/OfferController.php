<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
      return new OfferCollection(Offer::all());
    }

    public function show(Offer $product)
    {
        return new OfferResource($product);
    }

    public function store(Request $request)
    {

    }

}

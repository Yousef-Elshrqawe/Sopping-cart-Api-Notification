<?php

namespace App\Http\Resources;

use App\Models\Offer;
use App\Models\ProductOffer;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{


    public function toArray($request)
    {
        $ProductOffer = ProductOffer::where('product_id', $this->id)->get();
        $offers = Offer::checkOffer()->whereIn('id', $ProductOffer->pluck('offer_id'))->get();
        $subTotal = OfferResource::collection($offers)->sum('amount_type') == 0 ?
            $this->price - OfferResource::collection($offers)->sum('amount') :
            $this->price - (($this->price * OfferResource::collection($offers)->sum('amount')) / 100);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'Subtotal' => $this->when($offers->count(), $subTotal , $this->price),
            'offers' => $this->when($offers->count(), OfferResource::collection($offers)),
        ];


    }
}



<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Resources\OrderCollection as OrderCollection;
use App\Http\Resources\OrderResource as OrderResource;



class OrderController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        $userOrders = Order::where('user_id', auth()->id())->get();
        return new OrderCollection($userOrders);
    }

    public function show(Order $order)
    {
        if($order->user_id == auth()->id()){
            return new OrderResource($order);
        }else{
            return $this->returnError('E001', 'You are not authorized to view this order');
        }

    }

}

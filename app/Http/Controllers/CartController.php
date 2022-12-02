<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Requests\api\CartRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\api\CartOrderRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\CartItemCollection as CartItemCollection;


class CartController extends Controller
{
    use GeneralTrait;

    public function store(Request $request)
    {
        if (Auth::guard('api-auth')->check()) {
            $user_id = Auth::guard('api-auth')->user()->id;
        }

        $cart = Cart::create([
            'key' => md5(uniqid(rand(), true)),
            'user_id' => $user_id ?? 1,
        ]);
        return $this->returnData('Data', ['cartToken' =>$cart->id , 'cartKey' =>$cart->key], 'A new cart have been created for you!');
    }


    public function show(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->returnError('E001', $validator->errors());
        }
        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            return $this->returnData('Data', ['cart' => $cart->id, 'Items in Cart' => new CartItemCollection($cart->items)], 'Cart data');
        } else {
            return $this->returnError('E001', 'Cart key is not correct');
        }

    }


    public function destroy(Cart $cart, Request $request)
    {
        $validator = Validator::make($request->all(), ['cartKey' => 'required',]);
        if ($validator->fails()) {
            return $this->returnError('E001', $validator->errors());
        }
        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            $cart->delete();
            return $this->returnSuccessMessage('Cart has been deleted');
        } else {
            return $this->returnError('E001', 'Cart key is not correct');
        }

    }


    public function addProducts(Cart $cart, CartRequest $request)
    {
        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        if ($cart->key == $cartKey) {
            try { $Product = Product::findOrFail($productID);} catch (ModelNotFoundException $e) {
                return $this->returnError('E001', 'Product not found');
            }

            //check if the the same product is already in the Cart, if true update the quantity, if not create a new one.
            $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
            } else {
                CartItem::create(['cart_id' => $cart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
            }
            return $this->returnSuccessMessage('Product has been added to the cart successfully');
        } else {
            return $this->returnError('E001', 'Cart key is not correct');
        }

    }


    public function checkout(Cart $cart, CartOrderRequest $request)
    {
        if (Auth::guard('api-auth')->check()) {
            $userID = auth('api-auth')->user()->getKey();
        }

        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            $name = $request->input('name');
            $adress = $request->input('adress');
            $creditCardNumber = $request->input('credit card number');
            $TotalPrice = (float) 0.0;
            $items = $cart->items;
            foreach ($items as $item) {
                $product = Product::find($item->product_id);
                $price = $product->price;
                $inStock = $product->UnitsInStock;
                if ($inStock >= $item->quantity) {
                    $TotalPrice = $TotalPrice + ($price * $item->quantity);
                    $product->UnitsInStock = $product->UnitsInStock - $item->quantity;
                    $product->save();
                } else {
                    return $this->returnError('E001', 'Product out of stock');
                }
            }


            $PaymentGatewayResponse = true;
            $transactionID = md5(uniqid(rand(), true));

            if ($PaymentGatewayResponse) {
                $order = Order::create([
                    'products' => json_encode(new CartItemCollection($items)),
                    'totalPrice' => $TotalPrice,
                    'name' => $name,
                    'address' => $adress,
                    'user_id' => isset($userID) ? $userID : 1,
                    'transactionID' => $transactionID,
                ]);

                $cart->delete();
                return $this->returnData('Data', ['orderID' => $order->getKey()], 'Order has been placed successfully');
            }
        } else {
            return $this->returnError('E001', 'Cart key is not correct');
        }

    }

}


<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use App\Traits\ResponseTrait;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart): string
    {
        if ($cart->get()->count()==0){
           // return redirect()->route('/home');
            return response()->json('cart is empty');
        }
        return response()->json( $cart);
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request, CartRepository $cart): \Illuminate\Http\JsonResponse
    {$request->validate([]);
        $items = $cart->get()->groupBy('product.store_id')->all();
        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                ]);
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);}
                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);}}
            $cart->empty();
            DB::commit();
        } catch (Throwable $exception){
            DB::rollBack();
            throw $exception;}
        return response()->json('order is completed');
    }
}

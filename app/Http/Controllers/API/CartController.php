<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use App\Traits\ResponseTrait;
use Exception;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected CartRepository $cart;
    public function __construct(CartRepository $cart){
        $this->cart = $cart;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart): JsonResponse
    {
        try {
            $items = $cart->get();
            return ResponseTrait::responseSuccess($items,"Cart items retrieved successfully");
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception,'No Found');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart): JsonResponse
    {
        try {
            $request->validate([
                'product_id' => ['required', 'int', 'exists:products,id'],
                'quantity' => ['nullable', 'int', 'min:1'],
            ]);
            $product = Product::findOrFail($request->input('product_id'));
            $cart->add($product, $request->post('quantity'));

            return ResponseTrait::responseSuccess($cart->get(),"Cart Added successfully");
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception,'No Cart Added');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart): JsonResponse
    {
        try {
            $request->validate([
                'product_id'=>['required','int','exists:products,id'],
                'quantity'=>['nullable','int','min:1'],
            ]);
            $product = Product::findOrFail($request->input('product_id'));
            $cart->update($product,$request->post('quantity'));

            return ResponseTrait::responseSuccess($cart->get(),"Cart updated successfully");
        } catch (Exception $exception) {
            return ResponseTrait::responseError($exception,'No Cart Added');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart, $id): JsonResponse
    {
        try {
            $cart->delete($id);
            return response()->json([
                'status' => true,
                'message' => 'Item deleted successfully',
                'data' => $cart->get(),
            ],200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null,
            ],400);
        }
    }

}


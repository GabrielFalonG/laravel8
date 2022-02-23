<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json(['product' => $product]);;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $this->validate($request, Product::rules());

        $product = new Product();
        $data = $request->all();

        $product = $this->save($product, $data);

        return response()->json($product);
    }

    /**
     * @param Product $product
     * @param $data
     * @return Product
     * @throws \Exception
     */
    private function save(Product $product, $data)
    {
        $product->fill($data);
        $product->user_id = null;
        \DB::beginTransaction();

        try {
            $product->save();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $product;
    }
}

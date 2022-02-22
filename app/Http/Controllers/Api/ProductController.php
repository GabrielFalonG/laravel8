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
        $products = Product::orderBy('id', 'DESC');

        return response()->json(['products' => $products->paginate(10)]);
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
        $validator = Validator::make($request->all(), Product::rules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product();
        $data = $request->all();

        $product = $this->save($product, $data);

        if (isset($data['photo']) && $data['photo'] != null)
        {
            $imgPath = 'public/user_' . $product->user->id . '/photos/product_' . $product->id;

            $photoPathSaveInOBJ = $request->file('photo')->store($imgPath);

            $product->photo = $this->replacePublicByStorage($photoPathSaveInOBJ);
            $product->save();
        }

        return response()->json(['product' => $product]);
    }

    /**
     * @param $path
     * @return array|string|string[]
     */
    private function replacePublicByStorage($path)
    {
        $path = str_replace(
            "public",
            "/storage",
            $path
        );

        return $path;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), Product::rules($product));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $product = $this->save($product, $data);

        if (isset($data['photo']) && $data['photo'] != null)
        {
            $imgPath = 'public/user_' . $product->user->id . '/photos/product_' . $product->id;

            $photoPathSaveInOBJ = $request->file('photo')->store($imgPath);

            $product->photo = $this->replacePublicByStorage($photoPathSaveInOBJ);
            $product->save();
        }

        return response()->json(['product' => $product]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->product_id);
        $product->delete();

        return response()->json(['message' => 'Succesfully deleted']);
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
        $product->user_id = \Auth::user()->id;
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

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC');

        return view('product.index')
                ->with('products', $products->paginate(10))
                ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        \Session::flash('success', 'Product successfully created');
        return redirect()->route('product.index');
    }

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit')
                    ->with('product', $product)
                    ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
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

        \Session::flash('success', 'Product successfully updated');
        return redirect()->route('product.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->product_id);
        $product->delete();

        \Session::flash('success', 'Product successfully deleted');
        return redirect()->route('product.index');
    }

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

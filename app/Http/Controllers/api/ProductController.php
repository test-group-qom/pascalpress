<?php

namespace App\Http\Controllers\api;

use App\Product;
use App\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Config;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $language = $request->header('language');
        $languages = ['ar', 'fa', 'en'];
        $page = \App\Config::where('key', 'page')->first(['value']);

        if (!empty($language) && in_array($language, $languages)) {
            $products = Product::with(['productDetails' => function ($productFile) use ($language) {
                $productFile->where('language', '=', $language);
            }, 'productFiles'])->orderBy('created_at', 'desc')->paginate($page['value']);
        } else {
            $products = Product::with('productDetails', 'productFiles')->orderBy('created_at', 'desc')->get();

        }
        return response()->json($products, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('title', 'id'), [
            'title' => 'required|unique:categories',
            'id' => 'required|exists:categories'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $newProduct = collect($request->only('title'))->put('category_id', $request->id);
        $product = Product::create($newProduct->toArray());
        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {

        $language = $request->header('language');
        $languages = ['ar', 'fa', 'en'];
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:products',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $product = Product::find($id);
        if (!empty($language) && in_array($language, $languages)) {
            $productInfo = $product->with(['productDetails' => function ($productFile) use ($language) {
                $productFile->where('language', '=', $language);
            }, 'productFiles'])->orderBy('created_at', 'desc');
        } else {
            $productInfo = $product->with('productDetails', 'productFiles')->orderBy('created_at', 'desc')->get();

        }

        return response()->json($productInfo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(array_merge($request->only('title'), ['id' => $id]), [
            'title' => 'required|unique:categories',
            'id' => 'required|exists:products'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $newProduct = collect($request->only('title'))->put('category_id', $request->id);

        Product::find($id)->update($newProduct->toArray());
        $product = Product::find($id);
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:products',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = Product::onlyTrashed()->find($id);
        if ($result) {
            return response()->json('already deleted', 200);
        }
        Product::find($id)->delete();
        return response()->json('successful', 200);
    }

    public function restore($id)
    {
        $validator = Validator::make(['id' => $id], [

            'id' => 'required|integer|exists:products'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = Product::withTrashed()->find($id)->restore();
        if ($result) {
            $product = Product::find($id);
            return response()->json($product, 200);
        }
    }
}

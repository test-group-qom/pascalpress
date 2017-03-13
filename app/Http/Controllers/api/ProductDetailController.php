<?php

namespace App\Http\Controllers\api;

use App\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productDetails = ProductDetail::OrderBy('created_at', 'desc')->get();
        return response()->json($productDetails, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('config', 'language','descriptions','spesefication', 'id'), [
            'config' => 'required|',
            'descriptions' => 'required|',
            'id' => 'required|exists:products',
            'spesefication' => 'required',
            'language' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $newProductDetail = collect($request->only('config', 'language','descriptions','spesefication'))->put('product_id', $request->id);
        $productDetail = ProductDetail::create($newProductDetail->toArray());
        return response()->json($productDetail, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ProductDetail $productDetail)
    {
        return response()->json($productDetail, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductDetail $productDetail)
    {
        $validator = Validator::make($request->only('config', 'language','descriptions','spesefication', 'id'), [
            'config' => 'required|',
            'descriptions' => 'required|',
            'id' => 'required|exists:products',
            'spesefication' => 'required',
            'language' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $newProductDetail = collect($request->only('config', 'language','descriptions','spesefication'))->put('product_id', $request->id);
        $productDetail->update($newProductDetail->toArray());
        return response()->json($productDetail, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductDetail  $productDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDetail $productDetail)
    {
        $productDetail->delete();

        return response()->json('successful', 204);
    }

    public function restore($id)
    {
        $validator = Validator::make(['id' => $id], [

            'id' => 'required|integer|exists:product_files'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = ProductDetail::withTrashed()->find($id)->restore();
        if ($result) {
            $productDetail = ProductDetail::find($id);
            return response()->json($productDetail, 200);
        }
    }
}

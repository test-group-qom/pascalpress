<?php

namespace App\Http\Controllers\api;

use App\ProductFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Config;

class ProductFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = \App\Config::where('key','page')->first(['value']);
        $productFiles = ProductFile::OrderBy('created_at', 'desc')->paginate($page['value']);
        return response()->json($productFiles, 200);
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
        $validator = Validator::make($request->only('type', 'path', 'id'), [
            'type' => 'required|digits:1|digits_between:1,3',
            'id' => 'required|exists:products',
            'path' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $newProductFile = collect($request->only('type', 'path'))->put('product_id', $request->id);
        $productFile = ProductFile::create($newProductFile->toArray());
        return response()->json($productFile, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductFile $productFile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:product_files',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $productFile = ProductFile::find($id);
        return response()->json($productFile, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductFile $productFile
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductFile $productFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ProductFile $productFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductFile $productFile)
    {
        $validator = Validator::make($request->only('type', 'path', 'id'), [
            'type' => 'required|digits:1|digits_between:1,3',
            'id' => 'required|exists:products',
            'path' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $newProductFile = collect($request->only('type', 'path'))->put('product_id', $request->id);
        $productFile->update($newProductFile->toArray());
        return response()->json($productFile, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductFile $productFile
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:product_details',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = ProductFile::onlyTrashed()->find($id);
        if ($result) {
            return response()->json('already deleted', 200);
        }
        ProductFile::find($id)->delete();


        return response()->json('successful', 200);
    }

    public function restore($id)
    {
        $validator = Validator::make(['id' => $id], [

            'id' => 'required|integer|exists:product_files'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = ProductFile::withTrashed()->find($id)->restore();
        if ($result) {
            $productFile = ProductFile::find($id);
            return response()->json($productFile, 200);
        }
    }
}

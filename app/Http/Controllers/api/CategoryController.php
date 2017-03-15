<?php

namespace App\Http\Controllers\api;

use App\Category;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Config;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = \App\Config::where('key','page')->first(['value']);
        $categories = Category::OrderBy('created_at', 'desc')->paginate($page['value']);
        return response()->json($categories, 200);
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

        $validator = Validator::make($request->only('title'), [
            'title' => 'required|unique:categories',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        $category = Category::create($request->only('title'));
        return response()->json($category, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:categories',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $category = Category::find($id);
        return response()->json($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(array_merge($request->only('title'), ['id' => $id]), [
            'title' => 'required|unique:categories',
            'id' => 'required|integer|exists:categories',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }

        Category::find($id)->update($request->only('title'));
        $category = Category::find($id);
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:categories',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = Category::onlyTrashed()->find($id);
        if ($result) {
            return response()->json('already deleted', 200);
        }
        Category::find($id)->delete();
        return response()->json('successful', 200);
    }

    public function restore($id)
    {
        $validator = Validator::make(['id' => $id], [

            'id' => 'required|integer|exists:categories'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $result = Category::withTrashed()->find($id)->restore();
        if ($result) {
            $category = Category::find($id);
            return response()->json($category, 200);
        }
    }
}

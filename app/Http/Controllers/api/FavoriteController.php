<?php

namespace App\Http\Controllers\api;

use App\Services\EpubService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class FavoriteController extends Controller
{
    protected $epubService;
    protected $user;

    public function __construct(EpubService $epubService)
    {
        $this->epubService = $epubService;
        $this->user = User::all()->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->user->favorites;
        $result = $this->epubService->filterBookAttributes($books);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book_id = $request->only('id');
        $validator = Validator::make($book_id, [
            'id' => 'required|exists:books|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $this->user->favorites()->sync($book_id);
        $result = trans('messages.create_successfully_message');

        return response()->json($result, 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->favorites()->detach($id);
        $result = trans('messages.deleted_successfully_message');

        return response()->json($result, 200);
    }
}

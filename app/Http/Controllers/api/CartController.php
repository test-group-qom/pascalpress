<?php

namespace App\Http\Controllers\api;

use App\Services\EpubService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ResponseException;

use Validator;

class CartController extends Controller
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
        $books = $this->user->cart;
        $result = $this->epubService->filterBookAttributes($books);

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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
        $this->user->cart()->attach($book_id);
        $result = trans('messages.create_successfully_message');
        return response()->json($result, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->user->cart()->detach($id);
        $result = trans('messages.deleted_successfully_message');
        return response()->json($result, 200);
    }

    public function bill()
    {
        try {
            $this->epubService->isEmptyCart();
            $books = $this->user->cart;
            $bill = $this->epubService->calcBill($books);

            return response()->json($bill, 200);
        } catch (ResponseException  $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $e->getData()
            ]);
        }
        return response()->json($plucked);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Book;
use App\Services\EpubService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    protected $epubService;

    protected $user;

    public function __construct(EpubService $epubService)
    {
        $this->epubService = $epubService;

        $this->user = User::all()->first();
    }

    public function index()
    {
        $books = Book::OrderBy('created_at','desc')->get();

        $result = $this->epubService->filterBookAttributes($books);

        return response()->json($result, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::whereId($id)->get();

        $result = $this->epubService->filterBookAttributes($book);

        return response()->json($result, 200);
    }

}

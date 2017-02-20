<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsDetail;

class newsController extends Controller
{
    public function index()
    {

    	$news = News::all();
        return view('news.index',compact('news'));
    }

    public function show($id)
    {
    	$news_d = NewsDetail::where('news_id', $id)->get();
        return view('news.show',compact('news_d'));
    }
}

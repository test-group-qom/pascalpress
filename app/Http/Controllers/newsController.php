<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsDetail;

class newsController extends Controller
{
    protected $rule = [
        'image' => ['required'],
       // 'lang' => ['required'],
       // 'title' => ['required','unique:news_details']
    ];
    // public function index()
    // {

    // 	$news = News::all();
    //     return view('news.index',compact('news'));
    // }

    // public function show($id)
    // {
    // 	$news_d = NewsDetail::where('news_id', $id)->get();
    //     return view('news.show',compact('news_d'));
    // }

    /**
        * Display a listing of the resource.
        * @return Response
        */
        public function index()
        {
            $news = \App\News::with('newsdetails')->get();
            return $news;
            //$news = \App\News::first();
            // return $news->newsdetails;
            //return \App\News::all();
            //return \App\News::paginate();
        }
        
        /**
        * Show the form for creating a new resource.
        * @return Response
        */
        public function create()
        {

        }
        
        /**
        * Store a newly created resource in storage.
        * @return Response
        */
        public function store(Request $request)
        {
            $validator = \Validator::make($request->all(), $this->rule);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);
            $news = new News;
            $news->image = $request->input('image');
            $news->options = $request->input('options');
            $news->save();

            return response($news, 201); //201 is the HTTP status code (HTTP/1.1 201 created) for created   
        }

    
        /**
        * Display the specified resource.
        * @param  int  $id
        * @return Response
        */
        public function show($id)
        {
            return \App\News::findOrFail($id);
        }
    
        /**
        * Show the form for editing the specified resource.
        * @param  int  $id
        * @return Response
        */
        public function edit($id)
        {
            return \App\News::findOrFail($id);
        }
    
        /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
        public function update(Request $request,$id)
        {
            $input = \Input::json();
            $news = \App\News::findOrFail($id);
            $news->image = $input->get('image');
            $news->options = $input->get('options');
            $news->save();
            return response($news, 200)
                ->header('Content-Type', 'application/json');
        }

        /**
        * Remove the specified resource from storage.
        * @param  int  $id
        * @return Response
        */
        public function delete($id)
        {
            $news = News::find($id);
            $news->delete();
            return response('soft Deleted.', 200);
        }
    
        /**
        * Remove the specified resource from storage.
        * @param  int  $id
        * @return Response
        */
        public function destroy($id)
        {
            $news = News::find($id);
            $news->forceDelete();
            return response('force Deleted.', 200);
        }

        public function restore($id)
        {
            News::withTrashed()->find($id)->restore();
            return response('restore.', 200);
        }

         /**
        * Display the specified resource.
        * @param  Request  $request, News $news
        * @return Response
        */
        // public function search(Request $request, News $news)
        // {
        //     return $news
        //         ->where('name',
        //           'like',
        //           '%'.$request->get('name').'%')
        //         ->get();
        // }
}

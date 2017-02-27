<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsDetail;

class newsController extends Controller
{
    protected $rule = [
        'image' => ['required'],
        'lang' => ['required'],
        'title' => ['required','unique:news_details']
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
        * Display the specified resource.
        * @param  int  $id
        * @return Response
        */
        public function show($id)
        {
            $news = \App\News::find($id);
            $newsdetail = $news->newsdetails;
            return $news;//array('news' => $news, 'news_detail' => $newsdetail);
           // return \App\News::findOrFail($id);
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
<<<<<<< HEAD

            $validator = \Validator::make($request->all(), $this->rule);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);


            //$this->validate($request,$this->rule);

            //$input = \Input::json();

=======
            $validator = \Validator::make($request->all(), $this->rule);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);
>>>>>>> e24923dea752ad46375d328d2bcda54fc6adc417
            $news = new News;
            $news->image = $request->input('image');
            $news->options = $request->input('options');
            $news->save();
           
            $newsdetails = new NewsDetail;
            $newsdetails->lang = $request->input('lang');
            $newsdetails->title = $request->input('title');
            $newsdetails->summary = $request->input('summary');
            $newsdetails->text = $request->input('text');
            $newsdetails->tags = $request->input('tags');
            $news->newsdetails()->save($newsdetails);

            return response(array('news' => $news, 'news_details' => $newsdetails), 201); 
            //201 is the HTTP status code (HTTP/1.1 201 created) for created   
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
            $validator = \Validator::make($request->all(), $this->rule);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);

            $news = \App\News::findOrFail($id);
            $news->image = $request->input('image');
            $news->options = $request->input('options');
            $news->save();

            $newsdetail = $news->newsdetails;
            $newsdetails->lang = $request->input('lang');
            $newsdetails->title = $request->input('title');
            $newsdetails->summary = $request->input('summary');
            $newsdetails->text = $request->input('text');
            $newsdetails->tags = $request->input('tags');
            $news->newsdetails()->save($newsdetails);

            return response(array('news' => $news, 'news_details' => $newsdetails), 200)
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
        public function search(Request $request, NewsDetail $newsdetails)
        {
            return $newsdetails
                ->where('title',
                  'like',
                  '%'.$request->get('title').'%')
                ->get();
        }
}

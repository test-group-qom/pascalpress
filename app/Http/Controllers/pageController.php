<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsDetail;
use App\Config;
use Illuminate\Support\Facades\Input;

class pageController extends Controller
{
     protected $rule = [
        'image' => ['required'],
        'lang' => ['required'/*,'unique:news_details,news_id,'.$news->id*/],
        'title' => ['required','unique:news_details,title'],
        'text' => ['required'],
        'tags' => ['required'],
        'summary' => ['required'],
        'lang2' => ['required'/*,'unique:news_details,news_id,'.$news->id*/],
        'title2' => ['required','unique:news_details,title'],
        'text2' => ['required'],
        'tags2' => ['required'],
        'summary2' => ['required'],
        'lang3' => ['required'/*,'unique:news_details,news_id,'.$news->id*/],
        'title3' => ['required','unique:news_details,title'],
        'text3' => ['required'],
        'tags3' => ['required'],
        'summary3' => ['required'],
    ];

    /**
        * Display a listing of the resource.
        * @return Response
        */
        public function index(Request $request)
        {    // this is for pagination.............         
            $page = \App\Config::where('key','page')->first(['value']);

            // select language.....................
            if($request->header('language'))
                $lang = $request->header('language');
            else if (Input::get('language'))
                $lang =  Input::get('language');
            else $lang = 'en';
            
            // query.................................
            $news = \App\News::OrderBy('created_at', 'desc')->with(['newsdetails' => function ($query) use ($lang) {
                $query->where('lang', '=', $lang);
            }])->where('type','p')->paginate($page['value']);

            // this is for web........................
            if(\Route::currentRouteName() == 'web.page.index'){
                return view('news.index',compact('news'));
            }

            // this is for api........................
            return $news;
        }
    
         /**
        * Display the specified resource.
        * @param  int  $id
        * @return Response
        */
        public function show($id,Request $request)
        {
            // select language.....................
            if($request->header('language'))
                $lang = $request->header('language');
            else if (Input::get('language'))
                $lang =  Input::get('language');
            else $lang = 'en';

            // query.................................
            $news = \App\News::with(['newsdetails' => function ($query) use ($lang,$id) {
                $query->where('lang', '=', $lang);
            }])->where('id', '=', $id)->where('type','p')->get();

            if($news->isEmpty()){
                if(\Route::currentRouteName() == 'web.page.show'){
                    return view('errors.404');
                }
                return response('',404);
            }

            // this is for web........................
            if(\Route::currentRouteName() == 'web.page.show'){
                 return view('news.show',compact('news'));
            }

            // this is for api........................
            return $news;
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

            $page = new News;
            $page->image = $request->input('image');
            $page->options = $request->input('options');
            $page->type = 'p';
            $page->save();
           
            $pagedetails = new NewsDetail;
            $pagedetails->lang = $request->input('lang');
            $pagedetails->title = $request->input('title');
            $pagedetails->summary = $request->input('summary');
            $pagedetails->text = $request->input('text');
            $pagedetails->tags = $request->input('tags');
            $page->newsdetails()->save($pagedetails);

            $pagedetails2 = new NewsDetail;
            $pagedetails2->lang = $request->input('lang2');
            $pagedetails2->title = $request->input('title2');
            $pagedetails2->summary = $request->input('summary2');
            $pagedetails2->text = $request->input('text2');
            $pagedetails2->tags = $request->input('tags2');
            $page->newsdetails()->save($pagedetails2);

            $pagedetails3 = new NewsDetail;
            $pagedetails3->lang = $request->input('lang3');
            $pagedetails3->title = $request->input('title3');
            $pagedetails3->summary = $request->input('summary3');
            $pagedetails3->text = $request->input('text3');
            $pagedetails3->tags = $request->input('tags3');
            $page->newsdetails()->save($pagedetails3);

            return response(array('page' => $page, 'page_details1' => $pagedetails, 'page_details2' => $pagedetails2, 'page_details3' => $pagedetails3), 201); 
            //201 is the HTTP status code (HTTP/1.1 201 created) for created   
        }
    
        /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
        public function update(Request $request,$id)
        {
            $news = \App\News::find($id);
            if(empty($news)){
                return response('',404);
            }
            $all_newsdetails = $news->newsdetails;

            $validator = \Validator::make($request->all(), [
                'image' => ['required'],
                'lang' => ['required'/*,'unique:news_details,news_id,'.$news->id*/],
                'title' => ['required','unique:news_details,title,'.$all_newsdetails[0]['id']],
                'text' => ['required'],
                'tags' => ['required'],
                'summary' => ['required'],
                'lang2' => ['required'/*,'unique:news_details,news_id,'.$news->id*/],
                'title2' => ['required','unique:news_details,title,'.$all_newsdetails[1]['id']],
                'text2' => ['required'],
                'tags2' => ['required'],
                'summary2' => ['required'],
                'lang3' => ['required'/*,'unique:news_details,news_id,'.$news->id*/],
                'title3' => ['required','unique:news_details,title,'.$all_newsdetails[2]['id']],
                'text3' => ['required'],
                'tags3' => ['required'],
                'summary3' => ['required'],
            ]);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);
            
            $news->image = $request->input('image');
            $news->options = $request->input('options');
            $news->save();

            $newsdetails = $all_newsdetails[0];
            $newsdetails->lang = $request->input('lang');
            $newsdetails->title = $request->input('title');
            $newsdetails->summary = $request->input('summary');
            $newsdetails->text = $request->input('text');
            $newsdetails->tags = $request->input('tags');
            $news->newsdetails()->save($newsdetails);

            $newsdetails2 = $all_newsdetails[1];
            $newsdetails2->lang = $request->input('lang2');
            $newsdetails2->title = $request->input('title2');
            $newsdetails2->summary = $request->input('summary2');
            $newsdetails2->text = $request->input('text2');
            $newsdetails2->tags = $request->input('tags2');
            $news->newsdetails()->save($newsdetails2);

            $newsdetails3 = $all_newsdetails[2];
            $newsdetails3->lang = $request->input('lang3');
            $newsdetails3->title = $request->input('title3');
            $newsdetails3->summary = $request->input('summary3');
            $newsdetails3->text = $request->input('text3');
            $newsdetails3->tags = $request->input('tags3');
            $news->newsdetails()->save($newsdetails3);

            return response(array('news' => $news), 201);                
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

}

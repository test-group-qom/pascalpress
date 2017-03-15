<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\NewsDetail;
use App\Product;
use App\ProductDetail;
use Illuminate\Support\Facades\Auth;
use App\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

class newsController extends Controller
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
        public function index(Request $request)
        {
            $page = \App\Config::where('key','page')->first(['value']);
            $lang = $request->header('language');
            if($lang){
                $news = \App\News::with(['newsdetails' => function ($query) use ($lang) {
                    $query->where('lang', '=', $lang);
                }])->where('type','n')->paginate($page['value']);
                return $news;
            }

            $news = \App\News::with('newsdetails')->where('type','n')->paginate($page['value']);
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
        public function show($id,Request $request)
        {
            $lang = $request->header('language');
            if($lang){
                $news = \App\News::with(['newsdetails' => function ($query) use ($lang,$id) {
                    $query->where('lang', '=', $lang);
                }])->where('id', '=', $id)->where('type','n')->get();
                if(empty($news)){
                    return response('',404);
                }
                return $news;
            }

            $news = \App\News::find($id);
            if(empty($news)){
                return response('',404);
            }
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
            $validator = \Validator::make($request->all(), $this->rule);
            if ($validator->fails()) 
                return response()->json($validator->errors(), 422);

            $news = new News;
            $news->image = $request->input('image');
            $news->options = $request->input('options');
            $news->type = 'n';
            $news->save();
           
            $newsdetails = new NewsDetail;
            $newsdetails->lang = $request->input('lang');
            $newsdetails->title = $request->input('title');
            $newsdetails->summary = $request->input('summary');
            $newsdetails->text = $request->input('text');
            $newsdetails->tags = $request->input('tags');
            $news->newsdetails()->save($newsdetails);

            $newsdetails2 = new NewsDetail;
            $newsdetails2->lang = $request->input('lang2');
            $newsdetails2->title = $request->input('title2');
            $newsdetails2->summary = $request->input('summary2');
            $newsdetails2->text = $request->input('text2');
            $newsdetails2->tags = $request->input('tags2');
            $news->newsdetails()->save($newsdetails2);

            $newsdetails3 = new NewsDetail;
            $newsdetails3->lang = $request->input('lang3');
            $newsdetails3->title = $request->input('title3');
            $newsdetails3->summary = $request->input('summary3');
            $newsdetails3->text = $request->input('text3');
            $newsdetails3->tags = $request->input('tags3');
            $news->newsdetails()->save($newsdetails3);

            return response(array('news' => $news, 'news_details1' => $newsdetails, 'news_details2' => $newsdetails2, 'news_details3' => $newsdetails3), 201); 
            //201 is the HTTP status code (HTTP/1.1 201 created) for created   
        }
    
        /**
        * Show the form for editing the specified resource.
        * @param  int  $id
        * @return Response
        */
        public function edit($id)
        {
            $news = \App\News::find($id);
            $newsdetail = $news->newsdetails;
            return $news;
            //return \App\News::findOrFail($id);
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

         /**
        * Display the specified resource.
        * @param  Request  $request, News $news
        * @return Response
        */
        public function search($string,Request $request)
        {
            $page = \App\Config::where('key','page')->first(['value']);
           
            $search = DB::table('news_details') 
            ->join('news','news.id','=','news_details.news_id')
            ->where('news_details.title','like','%'.$string.'%')
            ->orwhere('news_details.text','like','%'.$string.'%')
            ->orwhere('news_details.tags','like','%'.$string.'%')
            ->select('news_details.id','news_details.title', 'news_details.text', 'news_details.tags','news.type');

            $search2 = DB::table('product_details') 
            ->join('products','products.id','=','product_details.product_id')
            ->where('products.title','like','%'.$string.'%')
            ->orwhere('product_details.config','like','%'.$string.'%')
            ->select('product_details.id','products.title', 'product_details.config as text', 'product_details.language as tags',DB::raw('"pr" as tempfield'))
            ->union($search)
            ->get();
       
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $page['value'];
        $offset = ($currentPage * $perPage) - $perPage;

        $currentPageSearchResults = $search2->slice($offset, $perPage)->all();

        $result= new LengthAwarePaginator($currentPageSearchResults, count($search2), $perPage);
$result->setPath($request->url());
            return $result;
        }
}

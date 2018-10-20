<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Config;
use App\Model\Post;
use App\helper\jdf;
use Validator;
use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function index()
    {
        $config = Config::find( 1 );
        $articles  = $this->query_posts( 7, 3 );
        $news   = $this->query_posts( 8, 4 );
        $slides   = Post::where( 'post_type', 3 )->where( 'status', 1 )->get();
        $mainCat = Category::wherename('محصولات')->first();
        if (empty($mainCat)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        }
        $categories = Category::where('parent_id', $mainCat->id)->orderBy('created_at', 'desc');
        $categories = $categories->skip( 0 )->take( 6 )->get();

        return view( 'front.index', compact( [ 'config', 'news', 'articles', 'slides', 'categories' ] ) );
    }

    public function news(Request $request)
    {
        $cat_id = 8;
        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount  = $request->mount > 0 ? (int) $request->mount : 6;

        $news     = $this->get_posts( $cat_id, $offset, $mount );
        $posts = $news[0];
        $count    = $news[1];
        $config   = Config::find( 1 );
        $thumb= Category::where('name', 'اخبار')->first()->thumb;

        return view( 'front.news', compact( [ 'config', 'posts', 'count', 'thumb'] ) );
    }

    public function articles(Request $request)
    {
        $cat_id = 7;
        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount  = $request->mount > 0 ? (int) $request->mount : 6;

        $articles     = $this->get_posts( $cat_id, $offset, $mount );
        $posts = $articles[0];
        $count    = $articles[1];
        $config   = Config::find( 1 );
        $thumb = Category::where('name', 'مقالات')->first()->thumb;


        return view( 'front.articles', compact( [ 'config', 'posts', 'count', 'thumb'] ) );
    }

    public function products(Request $request, $id)
    {
        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount  = $request->mount > 0 ? (int) $request->mount : 6;

        $category = Category::find($id);
        $products   = $category->posts()->where( 'status', 1 )->orderBy( 'created_at', 'desc' );
        $count    = $products->get()->count();
        $products = $products->skip( $offset )->take( $mount )->get();

        $config   = Config::find( 1 );

        return view( 'front.products', compact( [ 'config', 'products', 'count' ,'category'] ) );
    }

    public function productsCat(Request $request) {
        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount = $request->mount > 0 ? (int) $request->mount : 6;

        $mainCat = Category::wherename('محصولات')->first();
        if(empty($mainCat)){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        }
        $categories = Category::where('parent_id',$mainCat->id )->orderBy('created_at', 'desc');
        $count = $categories->get()->count();
        $categories = $categories->skip($offset)->take($mount)->get();

        $config = Config::find(1);
        return view('front.products-cat', compact(['config', 'categories', 'count']));
    }

    public function catalogs(Request $request)
    {

        $products   = Post::where( 'post_type', 2 )->where( 'status', 1 )->orderBy( 'created_at', 'desc' )->get();
        $catalogs = [];
        $catalogs = $products->map(function ($item) use ($catalogs) {
            if (!empty($item->files['catalog'])) {
                $catalogs['title'] = $item->title;
                $catalogs['file'] = $item->files['catalog'];
                return $catalogs ;
            }
        });
         $catalogs = array_filter($catalogs->toArray(), function ($val) {
            return $val != null;
         });
        //dd($catalogs);

        $config   = Config::find( 1 );

        return view( 'front.catalogs', compact( [ 'config', 'catalogs' ] ) );
    }

    public function single_post($id)
    {

        $validator = Validator::make( [ 'id' => $id ], [
            'id' => 'required|numeric|exists:posts,id,deleted_at,NULL'
        ] );
        if ($validator->fails()) {
            return back( 302 )->with( [ 'errors' => $validator->errors() ] );
        }

        $post = Post::where( 'id', $id )->where( 'status', 1 )->first();
        if ($post == null) {
            return back( 302 )->with( [ 'errors' => 'با عرض پوزش ، مطلب مورد نظر یافت نشد!' ] );
        }

        $post->visit += 1;
        $post->update();

        //publish date
        $jdf                = new jdf();
        $list               = date_parse( $post->created_at );
        $post->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );


        $post->category->map( function ($item) {
            unset( $item->pivot );
        } );

        $post->tags->map( function ($item) {
            unset( $item->pivot );
        } );

        $config = Config::find( 1 );

        return view( 'front.single_post', compact( [ 'post', 'config' ] ) );
    }
    public function single_product($id)
    {

        $validator = Validator::make( [ 'id' => $id ], [
            'id' => 'required|numeric|exists:posts,id,deleted_at,NULL'
        ] );
        if ($validator->fails()) {
            return back( 302 )->with( [ 'errors' => $validator->errors() ] );
        }

        $product = Post::where('post_type', 2)->where( 'id', $id )->where( 'status', 1 )->first();
        if ($product == null) {
            return back( 302 )->with( [ 'errors' => 'با عرض پوزش ، محصول مورد نظر یافت نشد!' ] );
        }

        $product->visit += 1;
        $product->update();

        //publish date
        $jdf                = new jdf();
        $list               = date_parse( $product->created_at );
        $product->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );


        $product->category->map( function ($item) {
            unset( $item->pivot );
        } );

        $product->tags->map( function ($item) {
            unset( $item->pivot );
        } );

        $config = Config::find( 1 );

        return view( 'front.single_product', compact( [ 'product', 'config' ] ) );
    }

    
    public function query_posts($cat_id, $take)
    {
        $category = Category::find( $cat_id );
        $all_post = $category->posts()->where( 'status', 1 )->orderBy( 'created_at', 'desc' );
        $all_post = $all_post->skip( 0 )->take( $take )->get();
        $all_post->map( function ($item) {
            //publish date
            $jdf                = new jdf();
            $list               = date_parse( $item->created_at );
            $item->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );

            $item->category = $item->category->map( function ($cat) {
                unset( $cat->pivot );

                return $cat->name;
            } );

            preg_match( '/^([^.!?\s]*[\.!?\s]+){0,40}/', strip_tags( $item->content ), $abstract );
            $item->content = $abstract[0] . ' ...';

            $item->category = $item->category->toArray();

            $item->tags->map( function ($tag) {
                unset( $tag->pivot );
            } );
        } );

        return $all_post;
    }

    public function get_posts($cat_id, $skip, $take)
    {
        $category = Category::find( $cat_id );
        $all_post = $category->posts()->where( 'status', 1 )->orderBy( 'id', 'desc' );
        $count    = $all_post->get()->count();
        $all_post = $all_post->skip( $skip )->take( $take )->get();
        $all_post->map( function ($item) {
            //publish date
            $jdf                = new jdf();
            $list               = date_parse( $item->created_at );
            $item->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );

            $item->category = $item->category->map( function ($cat) {
                unset( $cat->pivot );

                return $cat->name;
            } );

            preg_match( '/^([^.!?\s]*[\.!?\s]+){0,40}/', strip_tags( $item->content ), $abstract );
            $item->content = $abstract[0] . ' ...';

            $item->category = $item->category->toArray();

            $item->tags->map( function ($tag) {
                unset( $tag->pivot );
            } );
        } );

        return [ $all_post, $count ];
    }

    

    public function contact(Request $request)
    {
        $config = Config::find( 1 );

        return view( 'front.contact', compact( 'config' ) );
    }

    public function about(Request $request)
    {
        $config = Config::find( 1 );
        $about = Post::where('id', 13)->where('title', 'درباره ما')->first();


        return view( 'front.about', compact( ['config','about'] ) );
    }
}

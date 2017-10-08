<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Post;
use App\Model\PostCategory;
use App\Model\PostTag;
use App\Model\Tag;
use Illuminate\Http\Request;
use Validator;
use App\helper\jdf;

class PostController extends Controller
{
    public function index(Request $request)
    {

        if (empty( $request->post_type ) || (int) $request->post_type > 2 || (int) $request->post_type < 0) {
            $post_type = 0;
        } else {
            $post_type = $request->post_type;
        }

        $order_type = strtolower( $request->order_type );
        if (! empty( $order_type ) && $order_type == 'visit') {
            $order_type = 'visit';
        } else {
            $order_type = 'created_at';
        }

        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount  = $request->mount > 0 ? (int) $request->mount : 10;

        $all_post = Post::where( 'post_type', $post_type )->orderBy( $order_type, 'desc' );
        $count    = $all_post->get()->count();
        $all_post = $all_post->skip( $offset )->take( $mount )->get();
        $all_post->map( function ($item) {
            //publish date
            $jdf                = new jdf();
            $list               = date_parse( $item->created_at );
            $item->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );

            $item->category = $item->category->map( function ($cat) {
                unset( $cat->pivot );

                return $cat->name;
            } );
            $item->category = $item->category->toArray();

            $item->tags->map( function ($tag) {
                unset( $tag->pivot );
            } );
        } );

        return view( 'admin.post.index', compact( [ 'all_post', 'count', 'post_type' ] ) );
    }

    public function show($id)
    {
        $validator = Validator::make( [ 'id' => $id ], [
            'id' => 'required|numeric|exists:posts,id,deleted_at,NULL'
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }

        $post = Post::where( 'id', $id )->where( 'status', 1 )->first();
        if ($post == null) {
            return response()->json( [ 'message' => 'not found!' ], 404 );
        }

        $post->visit += 1;
        $post->update();

        $post->category->map( function ($item) {
            unset( $item->pivot );
        } );

        $post->tags->map( function ($item) {
            unset( $item->pivot );
        } );

        return view( 'admin.post.show', [ 'post' => $post ] );
    }

    public function add(Request $request)
    {
        if (empty( $request->post_type )) {
            $post_type = 0;
        } else {
            $post_type = $request->post_type;
        }
        $categories = Category::all();
        $tags       = Tag::all();

        return view( 'admin.post.create', compact( [ 'categories', 'tags', 'post_type' ] ) );
    }

    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'cat_id.*'  => 'required|numeric|exists:categories,id,deleted_at,NULL',
            'tag_id.*'  => 'nullable|numeric|exists:tags,id,deleted_at,NULL',
            'title'     => 'required|max:255',
            'content'   => 'required|min:5',
            'post_type' => 'nullable|numeric|between:0,2',
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }
 
        #####################
        // Specs
        $spec =   $this->get_prop( $request->spec_name, $request->spec_value );
        // Properties
        $prop = $this->get_prop( $request->prop_name, $request->prop_value );
        
        $catalog_type=[];
        $catalog_file =[];

        //get each file
        if (!empty($request->catalog_file)) {
            $catalog_type=$request->catalog_type;
            foreach ($request->file('catalog_file') as $item) {
                if ($request->hasFile('catalog_file') && $item->isValid()) {
                    $randNum = mt_rand(00000, 99999);
                    $filename = $randNum.'_'.$item->getClientOriginalName();
                    $item->move(public_path('/upload/products/'), $filename);
                    $item = $filename;
                }
                array_push($catalog_file, $item);
            }
        }
        
        // Catalog Files
        $catalog = $this->get_prop( $catalog_type, $catalog_file );

        #####################
        // TAG
        if (! empty( $request->tags )) {
            $new_tags = explode( ',', $request->tags );
        }

        //exist tags
        $tags = [];
        if (! empty( $request->result_tags )) {
            $tags      = explode( ',', $request->result_tags );
            $tags_name = Tag::whereIn( 'id', $tags )->pluck( 'name' );
        }

        //compare old_list with new_list
        if (! empty( $new_tags ) && ! empty( $tags_name )) {
            $new_tags = array_diff( $new_tags, $tags_name->toArray() );
        }

        // save new tags
        $new_ids = array();
        if (! empty( $new_tags )) {
            foreach ($new_tags as $item) {
                $tag = Tag::create( [ 'name' => $item, ] );
                array_push( $new_ids, $tag->id );
            }
        }

        if (! empty( $new_ids )) {
            $tags = array_merge( $tags, $new_ids );
        }

        if (! empty( $request->excerpt )) {
            $excerpt = $request->excerpt;
        } else {
            $excerpt = null;
        }

        // END TAG
        #####################

        if (empty( $request->thumb )) {
            $thumb = null;
        } else {
            $file = $request->file( 'thumb' );
            if ($request->hasFile( 'thumb' ) && $file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $file->move( public_path( "/upload/images/" ), $fileName );
                $thumb = $fileName;
            }
        }

        if ($request->post_type == null || $request->post_type == '0') {
            $post_type = 0;
        } else {
            $post_type = (int) $request->post_type;
        }

        if (! empty( $request->excerpt )) {
            $excerpt = $request->excerpt;
        } else {
            $excerpt = null;
        }

        $post = Post::create( [
            'title'     => $request->title,
            'thumb'     => $thumb,
            'excerpt'   => $request->excerpt,
            'content'   => $request->input( 'content' ),
            'post_type' => $post_type,
            'specs'     => $spec,
            'property'  => $prop,
            'files'  => $catalog,
        ] );

        $post->category()->sync( $request->cat_id );

        if (! empty( $tags )) {
            $post->tags()->sync( $tags );
        }

        if ($post_type != 0) {
            return redirect( '/admin/post?post_type=' . $post_type, 302 );
        }

        return redirect( '/admin/post', 302 );
    }

    public function edit(Request $request, $id)
    {
        if ($request->post_type == null || $request->post_type == '0') {
            $post_type = 0;
        } else {
            $post_type = (int) $request->post_type;
        }

        $validator = Validator::make( [ 'id' => $id ], [
            'id' => 'required|numeric|exists:posts,id,deleted_at,NULL',
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }

        $post = Post::find( $id );
        $post->category->map( function ($cat) {
            unset( $cat->pivot );
        } );

        $categories = Category::all();
        $tags       = Tag::all();

        return view( 'admin.post.edit', compact( [ 'post', 'categories', 'tags', 'post_type' ] ) );
    }

    public function update(Request $request, $id)
    {
        $request = array_add( $request, 'id', $id );

        $validator = Validator::make( $request->all(), [
            'id'       => 'required|numeric|exists:posts,id,deleted_at,NULL',
            'cat_id.*' => 'required|numeric|exists:categories,id,deleted_at,NULL',
            'title'    => 'required|max:255',
            'thumb'    => 'nullable|max:2048',
            'content'  => 'required',
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }

                #####################
        // Specs
        $spec =   $this->get_prop( $request->spec_name, $request->spec_value );
        // Properties
        $prop = $this->get_prop( $request->prop_name, $request->prop_value );
        
        $catalog_type=[];
        $catalog_file =[];

        //get each file
        if (!empty($request->catalog_file)) {
            $catalog_type=$request->catalog_type;

            foreach ($request->file('catalog_file') as $item) {
                if ($request->hasFile('catalog_file') && $item->isValid()) {
                    $randNum = mt_rand(00000, 99999);
                    $filename = $randNum.'_'.$item->getClientOriginalName();
                    $item->move(public_path('/upload/products/'), $filename);
                    $item = $filename;
                }
                array_push($catalog_file, $item);
            }
        }
        
        if (!empty($request->exist_catalog_type) && !empty($request->exist_catalog_file)) {
            $catalog_type = array_merge($catalog_type, $request->exist_catalog_type);
            $catalog_file = array_merge($catalog_file, $request->exist_catalog_file);
            //dd($catalog_type, $catalog_file ,$request->exist_catalog_type, $request->exist_catalog_file);
        }

        // Catalog Files
        $catalog = $this->get_prop( $catalog_type, $catalog_file );

        #####################
        //********* TAGs
        if (! empty( $request->tags )) {
            $new_tags = explode( ',', $request->tags );
        }

        //exist tags
        $tags = [];
        if (! empty( $request->result_tags )) {
            $tags      = explode( ',', $request->result_tags );
            $tags_name = Tag::whereIn( 'id', $tags )->pluck( 'name' );
        }

        //compare old_list with new_list
        if (! empty( $new_tags ) && ! empty( $tags_name )) {
            $new_tags = array_diff( $new_tags, $tags_name->toArray() );
        }

        // save new tags
        $new_ids = array();
        if (! empty( $new_tags )) {
            foreach ($new_tags as $item) {
                $tag = Tag::create( [ 'name' => $item, ] );
                array_push( $new_ids, $tag->id );
            }
        }

        if (! empty( $new_ids )) {
            $tags = array_merge( $tags, $new_ids );
        }

        if (! empty( $request->excerpt )) {
            $excerpt = $request->excerpt;
        } else {
            $excerpt = null;
        }

        //********* END TAGs

        $post        = Post::find( $id );
        $post->title = $request->title;
        if ($request->thumb !== null) {
            $file = $request->file( 'thumb' );
            if ($request->hasFile( 'thumb' ) && $file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $file->move( public_path( "/upload/images/" ), $fileName );
                $thumb       = $fileName;
                $post->thumb = $thumb;
            }
        }
        $post->excerpt  = $request->input( 'excerpt' );
        $post->content  = $request->input( 'content' );
        $post->specs    = $spec;
        $post->property = $prop;
        $post->files = $catalog;
        $post->update();

        $post->category()->sync( $request->cat_id );

        if (! empty( $tags )) {
            $post->tags()->sync( $tags );
        }

        if ($request->post_type != 0) {
            return redirect( '/admin/post?post_type=' . $request->post_type, 302 );
        }

        return redirect( '/admin/post', 302 );
    }

    public function destroy(Request $request, $id)
    {
        $validator = Validator::make( [ 'id' => $id ], [
            'id' => 'required|numeric|exists:posts,id,deleted_at,NULL'
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }

        $post = Post::find( $id );

// post categories
        $cats = PostCategory::where( 'post_id', $post->id )->get();
        $cats->map( function ($item) {
            $item->delete();
        } );

// post tags
        $tags = PostTag::where( 'post_id', $post->id )->get();
        $tags->map( function ($item) {
            $item->delete();
        } );

        $post->delete();

        if ($request->post_type != 0) {
            return redirect( '/admin/post?post_type=' . $request->post_type, 302 );
        }

        return back( 302 );
    }

    public function status(Request $request, $id)
    {
        $validator = Validator::make( [ 'id' => $id ], [
            'id' => 'required|numeric|exists:posts,id,deleted_at,NULL',
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }
        $post = Post::find( $id );
        if ($post->status == 0) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }

        $post->update();

        if ($post->status == 1) {
            $status = 'activate';
        } else {
            $status = 'deactivated';
        }

        if ($request->post_type != 0) {
            return redirect( '/admin/post?post_type=' . $request->post_type, 302 );
        }

        return back( 302 );
    }

    public function cat_post(
        Request $request,
        $cat_id
    ) {
        $validator = Validator::make( [ 'cat_id' => $cat_id ], [
            'cat_id' => 'required|numeric|exists:categories,id,deleted_at,NULL'
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }

        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount  = $request->mount > 0 ? (int) $request->mount : 10;

        $category = Category::find( $cat_id );
        $all_post = $category->posts();
        $count    = $all_post->get()->count();
        $all_post = $all_post->skip( $offset )->take( $mount )->get();
        $all_post->map( function ($item) {
            unset( $item->pivot );
        } );

        return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
    }

    public function tag_post(
        Request $request,
        $tag_id
    ) {
        $validator = Validator::make( [ 'tag_id' => $tag_id ], [
            'tag_id' => 'required|numeric|exists:tags,id,deleted_at,NULL'
        ] );
        if ($validator->fails()) {
            return back()->with( [ 'errors' => $validator->errors() ] );
        }

        $offset = $request->offset > 0 ? (int) $request->offset : 0;
        $mount  = $request->mount > 0 ? (int) $request->mount : 10;

        $tag      = Tag::find( $tag_id );
        $all_post = $tag->posts();
        $count    = $all_post->get()->count();
        $all_post = $all_post->skip( $offset )->take( $mount )->get();

        $all_post->map( function ($item) {
            unset( $item->pivot );
        } );

        return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
    }


    /**
     * convert latin number to persian
     *
     * @param string $string
     *   string that we want change number format
     *
     * @return formatted string
     */
    function LatinToPersian($string)
    {
        //arrays of persian and latin numbers
        $persian_num = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );//۲۳۵۰۰۰
        $latin_num   = range( 0, 9 );

        $string = str_replace( $latin_num, $persian_num, $string );

        return $string;
    }

    /**
     * convert persian number to latin
     *
     * @param string $string
     *   string that we want change number format
     *
     * @return formatted string
     */
    function PersianToLatin($string)
    {
        //arrays of persian and latin numbers
        $persian_num = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
        $latin_num   = range( 0, 9 );

        $string = str_replace( $persian_num, $latin_num, $string );

        return $string;
    }

    public function get_prop($arr_name, $arr_value)
    {
        if (count($arr_name) > 0) {
            if (! empty( array_filter( $arr_name ) ) && ! empty( array_filter( $arr_value ) )) {
                $result=[];
                for ($i=0; $i<count($arr_name); $i++) {
                    if (!empty($arr_name[$i]) && !empty($arr_value[$i])) {
                        $result[$arr_name[$i]][]=$arr_value[$i];
                    }
                }

                // $result = array_combine( $arr_name, $arr_value );

                /*$result = array_filter( $result, function ($value) {
                    return $value != null || $value != '';
                } );

                $result = array_filter( array_flip( $result ), function ($value) {
                	return $value != null || $value != '';
                } );

                $result = array_flip( $result );*/

                return $result;
            }
        }

        return null;
    }
}

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

class PostController extends Controller {
	public function index( Request $request ) {

		if ( empty( $request->post_type ) ) {
			$post_type = 0;
		} else {
			$post_type = 1;
		}

		$order_type = strtolower( $request->order_type );
		if ( ! empty( $order_type ) && $order_type == 'visit' ) {
			$order_type = 'visit';
		} else {
			$order_type = 'created_at';
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$all_post = Post::where( 'post_type', $post_type )->orderBy( $order_type, 'desc' );
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();
		$all_post->map( function ( $item ) {
			//publish date
			$jdf                = new jdf();
			$list               = date_parse( $item->created_at );
			$item->publish_date = $jdf->gregorian_to_jalali( $list['year'], $list['month'], $list['day'], '/' );

			$item->category = $item->category->map( function ( $cat ) {
				unset( $cat->pivot );

				return $cat->name;
			} );
			$item->category = $item->category->toArray();

			$item->tags->map( function ( $tag ) {
				unset( $tag->pivot );
			} );
		} );

		return view( 'post.index', compact( [ 'all_post', 'count', 'post_type' ] ) );
	}

	public function show( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:posts,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post = Post::where( 'id', $id )->where( 'status', 1 )->first();
		if ( $post == null ) {
			return response()->json( [ 'message' => 'not found!' ], 404 );
		}

		$post->visit += 1;
		$post->update();

		$post->category->map( function ( $item ) {
			unset( $item->pivot );
		} );

		$post->tags->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return view( 'post.show', [ 'post' => $post ] );
	}

	public function add() {
		$categories = Category::all();
		$tags       = Tag::all();

		return view( 'post.create', compact( [ 'categories', 'tags' ] ) );
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'cat_id.*'  => 'required|numeric|exists:categories,id,deleted_at,NULL',
			'tag_id.*'  => 'nullable|numeric|exists:tags,id,deleted_at,NULL',
			'title'     => 'required|max:255',
			'thumb'     => 'nullable|max:2048',
			'content'   => 'required|min:5',
			'post_type' => 'nullable|numeric|between:0,1',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

//********* TAGs
		if ( ! empty( $request->tags ) ) {
			$new_tags = explode( ',', $request->tags );
		}

		//exist tags
		$tags = null;
		if ( ! empty( $request->result_tags ) ) {
			$tags      = explode( ',', $request->result_tags );
			$tags_name = Tag::whereIn( 'id', $tags )->pluck( 'name' );
		}

		//compare old_list with new_list
		if ( ! empty( $new_tags ) && ! empty( $tags_name ) ) {
			$new_tags = array_diff( $new_tags, $tags_name->toArray() );
		}

		// save new tags
		$new_ids = array();
		if ( ! empty( $new_tags ) ) {
			foreach ( $new_tags as $item ) {
				$tag = Tag::create( [ 'name' => $item, ] );
				array_push( $new_ids, $tag->id );
			}
		}

		if ( ! empty( $new_ids ) ) {
			$tags = array_merge( $tags, $new_ids );
		}

		if ( !empty($request->excerpt) ) {
			$excerpt = $request->excerpt;
		} else {
			$excerpt = null;
		}

		//********* END TAGs

		if ( empty( $request->thumb ) ) {
			$thumb = null;
		} else {
			$file = $request->file( 'thumb' );
			if ( $request->hasFile( 'thumb' ) && $file->isValid() ) {
				$fileName = $file->getClientOriginalName();
				$file->move( public_path( "/upload/images/" ), $fileName );
				$thumb = $fileName;
			}
		}


		if ( $request->post_type == null || $request->post_type == '0' ) {
			$post_type = 0;
		} else {
			$post_type = (int) $request->post_type;
		}

		if ( !empty($request->excerpt) ) {
			$excerpt = $request->excerpt;
		} else {
			$excerpt = null;
		}

		$post = Post::create( [
			'title'     => $request->title,
			'thumb'     => $thumb,
			'excerpt'   => $request->excerpt,
			'content'   => $request->input( 'content' ),
			'post_type' => $post_type
		] );

		$post->category()->sync( $request->cat_id );

		if ( ! empty( $tags ) ) {
			$post->tags()->sync( $tags );
		}

		return redirect( '/admin/post' );
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:posts,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post = Post::find( $id );
		$post->category->map( function ( $cat ) {
			unset( $cat->pivot );
		} );

		$categories = Category::all();
		$tags       = Tag::all();

		return view( 'post.edit', compact( [ 'post', 'categories', 'tags' ] ) );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );

		$validator = Validator::make( $request->all(), [
			'id'       => 'required|numeric|exists:posts,id,deleted_at,NULL',
			'cat_id.*' => 'required|numeric|exists:categories,id,deleted_at,NULL',
			'title'    => 'required|max:255',
			'thumb'    => 'nullable|max:255',
			'content'  => 'required',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		//********* TAGs
		if ( ! empty( $request->tags ) ) {
			$new_tags = explode( ',', $request->tags );
		}

		//exist tags
		$tags = null;
		if ( ! empty( $request->result_tags ) ) {
			$tags      = explode( ',', $request->result_tags );
			$tags_name = Tag::whereIn( 'id', $tags )->pluck( 'name' );
		}

		//compare old_list with new_list
		if ( ! empty( $new_tags ) && ! empty( $tags_name ) ) {
			$new_tags = array_diff( $new_tags, $tags_name->toArray() );
		}

		// save new tags
		$new_ids = array();
		if ( ! empty( $new_tags ) ) {
			foreach ( $new_tags as $item ) {
				$tag = Tag::create( [ 'name' => $item, ] );
				array_push( $new_ids, $tag->id );
			}
		}

		if ( ! empty( $new_ids ) ) {
			$tags = array_merge( $tags, $new_ids );
		}

		if ( !empty($request->excerpt) ) {
			$excerpt = $request->excerpt;
		} else {
			$excerpt = null;
		}

		//********* END TAGs

		if ( $request->post_type == null || $request->post_type == '' ) {
			$post_type = 0;
		} else {
			$post_type = $request->post_type;
		}

		$post        = Post::find( $id );
		$post->title = $request->title;
		if ( $request->thumb !== null ) {
			$file = $request->file( 'thumb' );
			if ( $request->hasFile( 'thumb' ) && $file->isValid() ) {
				$fileName = $file->getClientOriginalName();
				$file->move( public_path( "/upload/images/" ), $fileName );
				$thumb       = $fileName;
				$post->thumb = $thumb;
			}
		}
		$post->excerpt = $request->input( 'excerpt' );
		$post->content = $request->input( 'content' );
		$post->update();

		$post->category()->sync( $request->cat_id );

		if ( ! empty( $tags ) ) {
			$post->tags()->sync( $tags );
		}

		return redirect( '/admin/post' );
	}

	public
	function destroy(
		$id
	) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:posts,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$post = Post::find( $id );

		// post categories
		$cats = PostCategory::where( 'post_id', $post->id )->get();
		$cats->map( function ( $item ) {
			$item->delete();
		} );

		// post tags
		$tags = PostTag::where( 'post_id', $post->id )->get();
		$tags->map( function ( $item ) {
			$item->delete();
		} );

		$post->delete();

		return back();
	}

	public
	function status(
		$id
	) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:posts,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$post = Post::find( $id );
		if ( $post->status == 0 ) {
			$post->status = 1;
		} else {
			$post->status = 0;
		}

		$post->update();

		if ( $post->status == 1 ) {
			$status = 'activate';
		} else {
			$status = 'deactivated';
		}

		return back();
	}

	public
	function cat_post(
		Request $request, $cat_id
	) {
		$validator = Validator::make( [ 'cat_id' => $cat_id ], [
			'cat_id' => 'required|numeric|exists:categories,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$category = Category::find( $cat_id );
		$all_post = $category->posts();
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();
		$all_post->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
	}

	public
	function tag_post(
		Request $request, $tag_id
	) {
		$validator = Validator::make( [ 'tag_id' => $tag_id ], [
			'tag_id' => 'required|numeric|exists:tags,id,deleted_at,NULL'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$offset = $request->offset > 0 ? (int) $request->offset : 0;
		$mount  = $request->mount > 0 ? (int) $request->mount : 10;

		$tag      = Tag::find( $tag_id );
		$all_post = $tag->posts();
		$count    = $all_post->get()->count();
		$all_post = $all_post->skip( $offset )->take( $mount )->get();

		$all_post->map( function ( $item ) {
			unset( $item->pivot );
		} );

		return response( [ 'all_post' => $all_post, 'count' => $count ], 200 );
	}
}

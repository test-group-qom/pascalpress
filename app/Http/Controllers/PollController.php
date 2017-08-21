<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Poll;
use App\Model\PollVote;
use Illuminate\Http\Request;
use Validator;

class PollController extends Controller {
	public function index() {
		$polls = Poll::orderBy( 'created_at' )->get();
		$polls->map( function ( $poll ) {
			$poll->votes;
		} );

		$categories = Category::all();

		return view( 'poll.index', compact( 'polls', 'categories' ) );
	}

	public function show( $id ) {
		$poll        = Poll::findOrFail( $id );
		$poll->likes = $this->GetLike( $id );

		return [ 'poll' => $poll, 'results' => $this->calcResults( $poll ) ];
	}

	public function edit( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:polls,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$poll = Poll::find( $id );
		$categories = Category::all();

		return view( 'poll.edit', compact( 'poll', 'categories' ) );
	}

	public function update( Request $request, $id ) {
		$request = array_add( $request, 'id', $id );
		$validator = Validator::make( $request->all(), [
			'id'         => 'required|numeric|exists:polls,id,deleted_at,NULL',
			'cat_id.*'   => 'required|numeric|exists:categories,id,deleted_at,NULL',
			'title'      => 'required|max:255',
			'item.*'      => 'required|max:255'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$cat_id   = $request->cat_id;
		$items    = $request->item;
		$newItems = array_combine( $cat_id, $items );

		$poll        = Poll::find( $id );
		$poll->title = $request->title;
		$poll->update();

		$votes = PollVote::where('poll_id',$id)->get();

		$i=0;
		foreach ($votes as $vote){
			$vote->update([
				'cat_id'=>$cat_id[$i],
				'item' => $items[$i]
			]);
			$i++;
		}


		return redirect('/admin/poll');
	}

	public function store( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'cat_id.*'   => 'required|numeric|exists:categories,id,deleted_at,NULL',
			'title'      => 'required|max:255',
			'item.*'      => 'required|max:255'
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$cat_id   = $request->cat_id;
		$items    = $request->item;
		$newItems = array_combine( $cat_id, $items );

		$poll        = new Poll();
		$poll->title = $request->title;
		$poll->save();

		$poll_id = $poll->id;

		foreach ( $newItems as $key => $val ) {
			PollVote::create( [
				'poll_id' => $poll_id,
				'cat_id'  => $key,
				'item'    => $val,
				'value'   => 25,
			] );
		}

		return back();
	}

	protected function calcResults( Poll $poll ) {
		return $poll->votes()->groupBy( 'item' )->select( 'item', DB::raw( 'count(*) as total' ) )->get();
	}

	public function destroy( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:polls,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}

		$poll = Poll::find( $id );

		// delete poll votes
		$poll->votes->each(function($vote){
			$vote->delete();
		});

		$poll->delete();

		return back();
	}

	public function status( $id ) {
		$validator = Validator::make( [ 'id' => $id ], [
			'id' => 'required|numeric|exists:polls,id,deleted_at,NULL',
		] );
		if ( $validator->fails() ) {
			return back()->with( [ 'errors' => $validator->errors() ] );
		}
		$poll = Poll::find( $id );
		if ( $poll->status == 0 ) {
			$poll->status = 1;
		} else {
			$poll->status = 0;
		}

		$poll->update();

		return back();
	}
}

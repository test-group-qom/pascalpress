@extends('welcome')
@section('content')
	<div>News</div>
	@foreach($news as $n)
		<li> <a href="{{ route('news.show', $n->id) }}">{{$n->id}} </a></li>
	@endforeach
@endsection
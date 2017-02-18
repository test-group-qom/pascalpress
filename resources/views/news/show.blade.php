@extends('welcome')
@section('content')
	<h3>جزئیات اخبار</h3>
	<hr>
	@foreach($news_d as $n)
		<div> زبان: {{$n->lang}} </div>
		<div> عنوان: {{$n->title}} </div>
		<div> خلاصه: {{$n->summary}} </div>
		<div> متن: {{$n->text}} </div>
		<div> تگ: {{$n->tags}} </div>
		<hr>
	@endforeach

	<a href="{{ route('news.index') }}" >بازگشت</a>
@endsection
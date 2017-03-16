@extends('Home')
@section('content')

@foreach($result as $res)
<?php 
switch($res->tempfield){
	case 'n': {$t = 'News'; $r = 'web.news.show';}
	break;
	case 'p': {$t = 'Page';$r = 'web.page.show';}
	break;
	case 'a': {$t = 'Article';$r = 'web.article.show';}
	break;	
	case 'pr': {$t = 'Product';$r = 'product.show';}
	break;
}
?>
	<ul>
		<h3>{{$t}}</h3>
		<li> <a href="{{ route($r, $res->id) }}">{{$res->title}} </a></li>	
	</ul>
	<hr>		
	@endforeach

	@section('title', 'search')
@endsection
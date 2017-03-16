@extends('Home')
@section('content')

<?php 
switch($news[0]['type']){
	case 'n': {echo '<h2>News</h2>'; $t = 'News'; $r = 'web.news.show';}
	break;
	case 'p': {echo '<h2>Page</h2>'; $t = 'Page';$r = 'web.page.show';}
	break;
	case 'a': {echo '<h2>Article</h2>'; $t = 'Article';$r = 'web.article.show';}
	break;	
}
?>
	
	@foreach($news as $n)
		<li> <a href="{{ route($r, $n->id) }}">{{$n->id}} </a></li>
		<li> {{$n->type}}</li>
		<image src="{{url($n->image)}}" alt="image"/> 

		<?php $newsdetails = $n->newsdetails; ?>
		@foreach ($newsdetails as $nd)
		    <ul>
		    	<li>{{$nd->lang}}</li>
				<li>{{$nd->title}}</li>
			</ul>
		@endforeach
	@endforeach

	@section('title', $t)
@endsection
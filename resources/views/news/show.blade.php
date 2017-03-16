@extends('Home')
@section('content')

<?php 
$type = $news[0]['type'];
switch($type){
	case 'n': {echo '<h2>News Details</h2>'; $t = 'News';$r = 'web.news.index';}
	break;
	case 'p': {echo '<h2>Page Details</h2>'; $t = 'Page';$r = 'web.page.index';}
	break;
	case 'a': {echo '<h2>Article Details</h2>'; $t = 'Article';$r = 'web.article.index';}
	break;	
}
?>
<!-- <h3>جزئیات اخبار</h3> -->
	<hr>
	<?php 
		$tags = ''; 
		$news = $news[0];
		$newsdetails = $news->newsdetails;
	?>
	@foreach ($newsdetails as $nd)
	    <div> زبان: {{$nd->lang}} </div>
		<div> عنوان: {{$nd->title}} </div>
		<div> خلاصه: {{$nd->summary}} </div>
		<div> متن: {{$nd->text}} </div>
		<div> تگ: {{$nd->tags}} </div>
		<hr>
		<?php 
			$tags.= $nd->tags.',';
		?>
	@endforeach
	
	@section('keywords',  rtrim($tags,',') )
	@section('title', $t)

	<a href="{{ route($r) }}" >بازگشت</a>
@endsection
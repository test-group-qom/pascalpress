@section('title','درباره ما')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')

<div class="container single" >

  @include ('front.layouts.logo_min')
    <div class="flex--parnet">
      <div class="flex--cover">
        @if($about->thumb != null)
          <img src="{{asset('upload/images/' . $about->thumb )}}" class="img--user">
        @else
          <img src="{{asset('upload/images/no-image.png')}}" class="img--user"/>
        @endif
      </div>
    </div>

  @include('front.layouts.menu_down')

  <div class="flex---about">
    
  </div>
</div>
</div>
</div>
<div class="flex--about">
  <div class="wrapper">
      <div class="post">
          <?php echo $about->content;?>
      </div>
  </div>
</div>

</div>

@include ('front.layouts.footer')
@endsection
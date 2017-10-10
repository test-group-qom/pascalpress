@php($page_title = $post->title)
@section('title',$post->title)
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')

<div class="container single" >

  @include ('front.layouts.logo_min')
    <div class="flex--parnet">
      <div class="flex--cover">

        @if($post->thumb != null)
          <img src="{{asset('upload/images/' . $post->thumb )}}" class="img--user">
        @else
          <img src="{{asset('upload/images/no-image.png')}}" class="img--user"/>
        @endif

      </div>
    </div>

  @include('front.layouts.menu_down')

  <div class="flex---about">
    <div class="wrapper">
      <div class="flex--parent" style="margin-top: 10px;">
        <div class="flex--text">
          <div class="flex---left">
            <div class="flex--item">
              <div class="flex--right">
                <span class="day">{{$post->publish_date}}</span>
                <img src="{{asset('front/styles/img/little14.svg')}}" class="pic" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
<div class="flex--about">
  <div class="wrapper">
    <div class="flex--center">
      <h3 class="text">{{$post->title}}</h3>
    </div>
    <div class="flex---single">
      <div class="flex---desrcption">
        <div class="flex--desrcption">
          <div class="flex--right">
            <img src="{{asset('front/styles/img/quotations.svg')}}" class="icon--quotations" alt="">
          </div>

          <div class="flex--left">
            <p class="desrcption">
               {{$post->excerpt}}
            </p>
            <div class="flex--icon"> <!-- left -->
              <img src="{{asset('front/styles/img/quotations.svg')}}" class="icon--quotations" alt="">
            </div>
          </div>
        </div>

      </div>
      <div class="flex--info--item">
        <div class="flex--right">
        @if($post->thumb != null)
          <img src="{{asset('upload/images/' . $post->thumb )}}" class="user--img">
        @else
          <img src="{{asset('upload/images/no-image.png')}}" class="user--img"/>
        @endif
        </div>
        <div class="flex--left">
          <div class="post">
          <?php echo $post->content;?>
          </div>
        </div>
      </div>
      <div class="links">
        <div class="wrapper">
          <div class="flex---right">
            <div class="flex--links">
            @if($post->tags != null)
              @foreach($post->tags as $tag)
              <div class="flex--right">
                <button class="button" name="button">
                    <svg version="1.1" class="icon--link" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                    width="98.388px" height="98.388px" viewBox="0 0 98.388 98.388" style="enable-background:new 0 0 98.388 98.388;"
                    xml:space="preserve">
                    <path d="M91.466,6.921C87.002,2.458,81.06,0,74.729,0S62.456,2.458,57.992,6.922L44.259,20.655
                    c-4.459,4.458-6.922,10.378-6.935,16.67l0,0c-6.291,0.013-12.211,2.476-16.669,6.933L6.922,57.992
                    c-9.229,9.229-9.229,24.246,0,33.475c4.462,4.462,10.406,6.92,16.737,6.921c6.33,0,12.273-2.458,16.737-6.921l13.733-13.732
                    c4.459-4.459,6.922-10.379,6.936-16.672h0.001c6.291-0.013,12.211-2.476,16.669-6.933l13.732-13.733
                    C100.695,31.167,100.695,16.151,91.466,6.921z M82.882,31.813l-13.73,13.732c-2.274,2.274-5.336,3.479-8.549,3.365
                    c-0.956-0.042-1.912,0.336-2.6,1.022l-8.072,8.072c-0.687,0.688-1.058,1.627-1.023,2.598c0.111,3.184-1.113,6.299-3.36,8.547
                    L31.812,82.883c-2.173,2.174-5.068,3.372-8.152,3.372s-5.979-1.196-8.154-3.373c-2.174-2.174-3.371-5.069-3.371-8.153
                    s1.197-5.98,3.371-8.154l13.735-13.733c2.172-2.174,5.045-3.372,8.09-3.372c0.148,0,0.296,0.003,0.445,0.01
                    c0.974,0.034,1.919-0.334,2.608-1.022l8.072-8.072c0.687-0.687,1.058-1.627,1.023-2.598c-0.111-3.184,1.113-6.299,3.36-8.547
                    l13.738-13.735c2.173-2.174,5.068-3.371,8.152-3.371s5.979,1.197,8.152,3.373c2.174,2.174,3.371,5.07,3.371,8.154
                    S85.056,29.639,82.882,31.813z"/>
                    <path d="M68.428,25.01L25.01,68.427c-1.367,1.367-1.367,3.583,0,4.95c0.684,0.684,1.579,1.025,2.475,1.025
                    s1.791-0.342,2.475-1.025L73.378,29.96c1.367-1.367,1.367-3.583,0-4.95C72.01,23.644,69.796,23.644,68.428,25.01z"/>
                  </svg>
                  {{$tag->name}}
                </button>
              </div>
              @endforeach
            @endif
          

      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>



@include ('front.layouts.footer')
@endsection
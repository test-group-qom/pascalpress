@section('title','مقالات')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')
@include ('front.layouts.logo_min')

<div class="container news">
 
  <div class="flex--parnet">
    <div class="flex--cover">
      
      @if($thumb != null)
        <img src="{{asset('upload/images/'.$thumb)}}" class="img--user"/>
      @else
        <img src="{{asset('upload/images/no-image.png')}}" class="img--user"/>
      @endif

    </div>
    @include ("front.layouts.menu_down")
    <div class="flex--items">
      <div class="flex---items">
          <div class="wrapper">
            <div class="flex--parent">
                <div class="flex--text">
                    <h3 class="text">
                        مقالات
                        <div class="flex--line">
                            <div class="flex--right">      <!-- right -->
                                <span class="line"></span>
                            </div>
                            <div class="flex--left">          <!-- left -->
                                <span class="line"></span>
                            </div>
                        </div>
                    </h3>
              </div>
              <div class="flex---wrap">
              
                @foreach($posts as $post)
                <div class="flex--item" >
                  <a href="/articles/{{$post->id}}" >
                    <div class="flex--img">
                      @if($post->thumb!=null)
                        <img src="{{asset('upload/images/' .$post->thumb)}}" class="img--content"/>
                      @else
                        <img src="{{asset('upload/images/no-image.png')}}" class="img--content"/>
                      @endif
                    </div>
                    <div class="flex--content">
                      <h3 class="title">{{$post->title}}</h3>
                      <p class="descrption">
                        {{$post->excerpt}}
                      </p>
                    </div>
                  </a>
                </div>
                @endforeach

                
                <div class="cls"></div>

                <!-- pagination -->
                    @if($count > 6)
                        <?php
                        $offset = 0;
                        $mount = 6;
                        $total_page = $count / $mount;
                        $remaining = $count % $mount;
                        ?>

                        <ul class="pagination">

                            <?php
                            for($i = 1; $i <= (int) $total_page; $i ++){
                            ?>
                            <li class=""><a href="?offset={{$offset}}" class="button">{{$i}}</a></li>
                            <?php
                            $offset += 6;
                            }

                            if($remaining > 0){
                            ?>
                            <li class=""><a href="?offset={{$offset}}" class="button">{{$i}}</a></li>
                            <?php } ?>
                        </ul>

                    @endif
                <!-- end pagination -->


              </div>
            </div>
          </div>
        </div>
    </div>
  </div>

</div>

@include ('front.layouts.footer')
@endsection
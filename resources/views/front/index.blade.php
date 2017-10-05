@section('title','صفحه اصلی')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')

<div class="container" >
  <div class="flex--wrap">
    <div class="flex---slider">
      @include ('front.layouts.logo_min')
      @include ('front.layouts.flickity')
    </div>
    <div class="flex---content">
      <div class="logo-min2">
        <div class="min--logo">
          <a href="/">
            <img src="{{asset('front/styles/img/logo.png')}}" class="img--logo" alt="">
          </a>
        </div>
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
              @foreach($articles as $article)
                <div class="flex--item">
                  <a href="/single_post/{{$article->id}}" >
                    <div class="flex--img">
                      @if($article->thumb != null)
                      <img src="{{asset('upload/images/' . $article->thumb )}}" class="img--content" alt="">
                      @else
                        <img src="{{asset('upload/images/no-image.png')}}" class="img--content"/>
                      @endif
                    </div>
                    <div class="flex--content">
                      <h3 class="title">{{$article->title}}</h3>
                      <p class="descrption">
                        {{$article->excerpt}}
                      </p>
                    </div>
                  </a>
                </div>
                @endforeach
              </div>
              <div class="flex--button">
                <a href="articles" >
                  <button type="button" class="button" name="button">بیشتر</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="flex---products">
          <div class="flex--text">
            <h3 class="text">
            محصولات
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
          <div class="flex--product">
            <div class="wrapper">
              <div class="flex--pic">
                <div class="flex--right">
                    <div class="min--pic" href="product.php">
                      <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--user" alt="">
                    </div>
                </div>
                <div class="flex--right">
                    <div class="min--pic" href="product.php">
                      <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--user" alt="">
                    </div>
                </div>
                <div class="flex--right">
                    <div class="min--pic" href="product.php">
                      <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--user" alt="">
                    </div>
                </div>
                <div class="flex--right">
                    <div class="min--pic" href="product.php">
                      <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--user" alt="">
                    </div>
                </div>
                <div class="flex--right">
                    <div class="min--pic" href="product.php">
                      <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--user" alt="">
                    </div>
                </div>
                <div class="flex--right">
                    <div class="min--pic" href="product.php">
                      <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--user" alt="">
                    </div>
                </div>
              </div>
              <div class="flex--button">
                <a href="single.php">
                  <button type="button" class="button" name="button">بیشتر</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="flex---news">
          <div class="wrapper">
            <div class="flex--parent">
              <div class="flex---right">
                <div class="flex--right">
                  <a href="/single_post/{{$news[0]->id}}" >
                    <div class="flex--img">
                      @if($news[0]->thumb != null)
                      <img src="{{asset('upload/images/' . $news[0]->thumb )}}" class="img--user" alt="">
                      @else
                        <img src="{{asset('upload/images/no-image.png')}}" class="img--content"/>
                      @endif
                    </div>
                    <div class="flex--status">
                      <?php
                      $date = array();
                      $date = explode("/",$news[0]->publish_date);
                      $year = $date[0];
                      $month = $date[1];
                      $day = $date[2];

                      switch($month){
                        case 1:
                        $month = "فروردین";
                        break;
                        case 2:
                        $month = "اردیبهشت";
                        break;
                        case 3:
                        $month = "خرداد";
                        break;
                        case 4:
                        $month = "تیر";
                        break;
                        case 5:
                        $month = "مرداد";
                        break;
                        case 6:
                        $month = "شهریور";
                        break;
                        case 7:
                        $month = "مهر";
                        break;
                        case 8:
                        $month = "آبان";
                        break;
                        case 9:
                        $month = "آذر";
                        break;
                        case 10:
                        $month = "دی";
                        break;
                        case 11:
                        $month = "بهمن";
                        break;
                        case 12:
                        $month = "اسفند";
                        break;
                      }
                      ?>
                      <div class="flex--time">
                        <span class="time">{{$day}}</span>
                      </div>
                      <div class="flex--day">
                      
                        <span class="day">{{$month}}</span>
                      </div>
                    </div>
                    <div class="flex--info">
                      <h3 class="title">{{$news[0]->title}}</h3>
                      <p class="descrption">
                        {{$news[0]->excerpt}}
                      </p>
                    </div>
                  </a>
                </div>
              </div>
              <div class="flex---left">
                <div class="flex--about">
                  <div class="flex--text">
                    <h3 class="text">
                      اخبار
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
                  <div class="flex--news">
                    <div class="flex--group">

                    @foreach($news as $news_item)
                        <div class="flex--item">
                            <div class="flex--right">
                              <a href="/single_post/{{$news_item->id}}" >
                                <div class="flex--img">  <!-- right -->
                                  <img src="{{asset('upload/images/' . $news_item->thumb )}}" class="img--user" alt="">
                                </div>
                              </a>
                            </div>
                            <div class="flex--left">
                              <div class="flex--padding">
                                <a href="/single_post/{{$news_item->id}}" >
                                  <h3 class="title">{{$news_item->title}}</h3>
                                  <p class="descrption">
                                  {{$news_item->excerpt}}
                                  </p>
                                </a>
                              </div>
                            </div>
                        </div>
                    @endforeach

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
</div>


@include ('front.layouts.footer')
@endsection

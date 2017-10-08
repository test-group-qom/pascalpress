@section('title','محصولات')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')
@include ('front.layouts.logo_min')

<div class="container single">
  <div class="flex--parnet">
    <div class="flex--cover">
      <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
    </div>
  </div>
  @include('front.layouts.menu_down')
  <div class="flex---about">
    <div class="wrapper">
      <div class="flex--parent">
        <div class="flex--text">
          <div class="flex---right">
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
          <div class="flex---left">
            <div class="flex--item">
              <div class="flex--right">
                <span class="day">۱۳۷۶/۱۱/۲۲</span>
                <img src="{{asset('front/styles/img/little14.svg')}}" class="pic" alt="">
              </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<div class="flex---min">
  <div class="wrapper">
    <div class="flex---slider">
      <div class="flex---right">
        <div class="flex--slider" ng-controller="NavSliderCtrl">
          <div class="slider" id="slider1">
            <div class="main-carousel">
              <div class="carousel-cell easyzoom easyzoom--overlay is-ready">
                <a href="{{asset('front/styles/img/cover_news.jpg')}}">
                  <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                </a>
              </div>
              <div class="carousel-cell easyzoom easyzoom--overlay is-ready">
                <a href="{{asset('front/styles/img/cover_news.jpg')}}">
                  <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                </a>
              </div>
              <div class="carousel-cell easyzoom easyzoom--overlay is-ready">
                <a href="{{asset('front/styles/img/cover_news.jpg')}}">
                  <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                </a>
              </div>
              <div class="carousel-cell easyzoom easyzoom--overlay is-ready">
                <a href="{{asset('front/styles/img/cover_news.jpg')}}">
                  <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                </a>
              </div>
            </div>
          </div>
          <div class="nav_slider2" id="sliderNav1">
            <div class="carousel-nav">
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>  <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
              <div class="carousel-cell">
                <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex---left">
        <div class="flex---text">
          <h3 class="text">مشخصات کلی</h3>
        </div>
        <div class="flex--cols">
          <div class="flex--col">
            <div class="flex--right">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
            <div class="flex--left">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
          </div>
          <div class="flex--col">
            <div class="flex--right">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
            <div class="flex--left">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
          </div>
          <div class="flex--col">
            <div class="flex--right">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
            <div class="flex--left">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
          </div>
          <div class="flex--col">
            <div class="flex--right">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
            <div class="flex--left">
              <h3 class="title">تعداد سیم کارت</h3>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="flex--tabs">
  <div class="wrapper">
    <div class="menu_tab ">
      <div class="tabs">
        <ul>
          <li class="selected">
            <h3 class="title">نقد و بررسی تخصصی</</h3>
          </li>
          <li>
            <h3 class="title">مشخصات فنی</h3>
          </li>
          <li>
            <h3 class="title">گالری فیلم</h3>
          </li>
          <li>
            <h3 class="title"> کاتالوگ  </h3>

          </li>
        </ul>
      </div>
      <div class="flex---descrption">
        <div class="flex--descrption">
          <div class="Checking_tab">
            <h3 class="title">نقد و بررسی تخصصی</h3>
            <p class="descrption">
              لورم ایپسوم یا طرح‌نما (به انگلیسی: Lorem ipsum) به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. معمولا طراحان گرافیک برای صفحه‌آرایی، نخست از متن‌های آزمایشی و بی‌معنی استفاده می‌کنند تا صرفا به مشتری یا صاحب کار خود نشان دهند که صفحه طراحی یا صفحه بندی شده بعد از اینکه متن در آن قرار گیرد چگونه به نظر می‌رسد و قلم‌ها و اندازه‌بندی‌ها چگونه در نظر گرفته شده‌است. از آنجایی که طراحان عموما نویسنده متن نیستند و وظیفه رعایت حق تکثیر متون را ندارند و در همان حال کار آنها به نوعی وابسته به متن می‌باشد آنها با استفاده از محتویات ساختگی، صفحه گرافیکی خود را صفحه‌آرایی می‌کنند تا مرحله طراحی و صفحه‌بندی را به پایان برند.
            </p>
          </div>
        </div>
        <div class="flex--descrption">
          <div class="Checking_tab">
            <h3 class="title">نقد و بررسی تخصصی</h3>
            <div class="property">
              <div class="flex--cols">
                <div class="flex--col">
                  <div class="item">ویژگی ها</div>
                </div>
                <div class="flex--col">
                  <div class="item">ویژگی ها</div>
                </div>
                <div class="flex--col">
                  <div class="item">ویژگی ها</div>
                </div>
                <div class="flex--col">
                  <div class="item">ویژگی ها</div>
                </div>
                <div class="flex--col">
                  <div class="item">ویژگی ها</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex--descrption display--none" ng-controller="slider2Ctrl">
          <div class="flex--slider">
            <div class="wrapper">
              <div class="slider" id="slider2" >
                <div class="main-carousel">
                  <div class="carousel-cell">
                    <video class="video" controls>
                      <source src="{{asset('front/styles/img/test.mp4')}}" type="video/mp4">
                      </video>
                    </div>
                    <div class="carousel-cell">
                      <video class="video" controls>
                        <source src="{{asset('front/styles/img/test.mp4')}}" type="video/mp4">
                        </video>
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="nav_slider2" id="sliderNav2">
                    <div class="carousel-nav">
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class=" img--user" >
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>  <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                      <div class="carousel-cell">
                        <img src="{{asset('front/styles/img/cover_news.jpg')}}" class="img--user" alt="">
                      </div>
                    </div>
                  </div>
                </div>


              </div>

            </div>
            <div class="flex--descrption">
              <div class="flex---items">
                <div class="wrapper">
                  <div class="flex--parent">
                    <div class="flex---wrap">
                      <a ui-sref="master.single">
                        <div class="flex--item">
                          <div class="flex--img">
                            <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--content" alt="">
                          </div>
                          <div class="flex--content">
                            <h3 class="title">عنوان اطلاعیه در اینقسمت</h3>
                            <a ui-sref="master.single" class="descrption">لینک</a>
                          </div>
                        </a>
                      </div>
                      <div class="flex--item">
                        <a ui-sref="master.single">
                          <div class="flex--img">
                            <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--content" alt="">
                          </div>
                          <div class="flex--content">
                            <h3 class="title">عنوان اطلاعیه در اینقسمت</h3>
                            <a href="#" class="descrption">لینک</a>
                          </div>
                        </a>
                      </div>
                      <div class="flex--item">
                        <a ui-sref="master.single">
                          <div class="flex--img">
                            <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--content" alt="">
                          </div>
                          <div class="flex--content">
                            <h3 class="title">عنوان اطلاعیه در اینقسمت</h3>
                            <a href="#" class="descrption">لینک</a>
                          </div>
                        </a>
                      </div>
                      <div class="flex--item">
                        <a ui-sref="master.single">
                          <div class="flex--img">
                            <img src="{{asset('front/styles/img/img-content.jpg')}}" class="img--content" alt="">
                          </div>
                          <div class="flex--content">
                            <h3 class="title">عنوان اطلاعیه در اینقسمت</h3>
                            <a href="#" class="descrption">لینک</a>
                          </div>
                        </a>
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
</div>

@include ('front.layouts.footer')
@endsection
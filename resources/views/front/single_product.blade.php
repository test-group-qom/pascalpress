@php($page_title = $product->title)
@section('title',$product->title)
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')
@include ('front.layouts.logo_min')

<script>
function openTab(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" selected", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " selected";
}
</script>

<div class="container single">

  <div class="flex--parnet">
    <div class="flex--cover">
      @if($product->thumb!=null)
        <img src="{{asset('upload/images/' .$product->thumb)}}" class="img--user"/>
      @else
        <img src="{{asset('upload/images/no-image.png')}}" class="img--user"/>
      @endif
    </div>
  </div>

  @include('front.layouts.menu_down')

  <div class="flex---about">
    <div class="wrapper">
      <div class="flex--parent">
          <div class="flex--text" >
              <h3 class="text">
                  
              </h3>
        </div>
      </div>
    </div>
  </div>

  <div class="flex---min">
    <div class="wrapper">
      <div class="flex---slider">
        <div class="flex---right">
          <div class="flex--slider">
            <div class="slider" id="slider1">
              <div class="main-carousel">

                @if(!empty($product->files['image']))
                @foreach($product->files['image'] as $img)
                  <div class="carousel-cell easyzoom easyzoom--overlay is-ready">              
                    <a href="{{asset('upload/products/'.$img)}}">
                      <img src="{{asset('upload/products/'.$img)}}" class="img--user" alt="">
                    </a>
                  </div>
                @endforeach
                @endif
              
              </div>
            </div>
            <div class="nav_slider2" id="sliderNav1">
              <div class="carousel-nav">
                @if(!empty($product->files['image']))
                @foreach($product->files['image'] as $img)
                <div class="carousel-cell">
                  <img src="{{asset('upload/products/'.$img)}}" class="img--user" alt="">
                </div>
                @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="flex---left">
          <div class="flex--cols">

            @if(!empty($product->specs))
              @foreach($product->specs as $Skey=>$Svalue)
                @foreach($Svalue as $val)
                  <div class="flex--col">
                    <div class="flex--right">
                        <span class="key">{{$Skey}}</span>
                    </div>
                    <div class="flex--left">
                        <span class="value">{{$val}}</span>
                    </div>
                  </div>
                @endforeach
              @endforeach
            @endif
            
          </div>

        </div>
      </div>
    </div>
  </div>
  
  <br><br><br><br>

  <div class="flex--tabs">
    <div class="wrapper">
      <div class="menu_tab ">

        <div class="tabs">
          <ul>
            <li class="tablinks selected" onclick="openTab(event, 'Tab1')"><span class="tab">نقد و بررسی تخصصی</span></li>
            <li class="tablinks" onclick="openTab(event, 'Tab2')"><span class="tab">مشخصات فنی</span></li>
            <li class="tablinks" onclick="openTab(event, 'Tab3')"><span class="tab">گالری فیلم</span></li>
            <li class="tablinks" onclick="openTab(event, 'Tab4')"><span class="tab"> کاتالوگ</span></li>
          </ul>
        </div>

        <div class="flex---descrption">

          <div class="flex--descrption tabcontent" id="Tab1">
            <div class="Checking_tab">  
              <div class="descrption">
                <?php echo $product->content ?>
              </div>
            </div>
          </div>

          <div class="flex--descrption tabcontent" id="Tab2">
            <div class="Checking_tab">
              <div class="property">
                  
                @if(!empty($product->property))
                  <table class="table">
                    @foreach($product->property as $Pkey=>$Pvalue)
                      @foreach($Pvalue as $val)
                      <tr>
                        <td class="prop_name">
                          {{$Pkey}}
                        </td>
                        <td class="prop_value">
                        {{$val}}
                        </td>
                      </tr>
                      @endforeach
                    @endforeach
                  </table>
                @endif

              </div>
            </div>
          </div>

          <div class="flex--descrption tabcontent " id="Tab3" style="display:none">

            @if(!empty($product->files['video']))
              <div class="flex---items">
                @foreach($product->files['video'] as $video)

                  <div class="flex--item product_file">
                    <div class="flex--img">
                        <video class="video" controls="" id="video_{{$video}}" width="300">
                        <source src="{{asset('upload/products/'.$video)}}" type="video/mp4">
                      </video>
                    </div>   
                  </div>

                @endforeach
                <div class="cls"></div>
              </div>
            @endif

          </div>

          <div class="flex--descrption tabcontent" id="Tab4">

            @if(!empty($product->files['catalog']))
              <div class="flex---items">
                @foreach($product->files['catalog'] as $catalog)

                  <div class="flex--item product_file">
                    <a href="{{asset('upload/products/'.$catalog)}}" target="_blank">
                      <div class="flex--img">
                        <img src="{{asset('/upload/catalog-icon.png')}}" width="128" alt="">
                      </div>                
                      <p align="center"><span>{{$catalog}}</span></p>
                    </a>
                  </div>

                @endforeach
                <div class="cls"></div>
              </div>
            @endif
            
          </div>

        </div>

      </div>
    </div>
  </div>

</div>
</div>
@include ('front.layouts.footer')
@endsection
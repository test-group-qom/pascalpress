@section('title','کاتالوگ')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')
@include ('front.layouts.logo_min')

<div class="Repertory">
  <div class="flex--descrption">
    <div class="flex---items">
      <div class="wrapper">
        <div class="flex--parent">
          <div class="flex---wrap">

          @foreach($catalogs as $item)
            
            
                  <h3 class="title" style=" display: block;width: 100%;border-bottom: 2px solid #eee;">{{$item['title']}}</h3>
                @foreach($item['file'] as $file)
            <div class="flex--item">
                
              
              <a href="{{asset('upload/products/'.$file)}}" target="_blank">

                <div class="flex--img">
                  <img src="{{asset('/upload/images/no-image.png')}}" class="img--content" alt="">
                </div>                

                <p align="center"><span>{{$file}}</span> </p>
              </a>
              
            </div>
            <div class="cls"></div>

            @endforeach
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
@include ('front.layouts.footer')
@endsection
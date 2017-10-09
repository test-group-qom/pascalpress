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
            
            
                  <h3 class="title" style=" display: block;width: 100%;margin-bottom: 10px;border-bottom: 2px solid #eee;">{{$item['title']}}</h3>
                @foreach($item['file'] as $file)
            <div class="flex--item product_file">
                              
              <a href="{{asset('upload/products/'.$file)}}" target="_blank">

                <div>
                  <img src="{{asset('/upload/catalog-icon.png')}}">
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
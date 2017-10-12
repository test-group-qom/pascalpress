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

        @if($catalogs != null)
            <table class="table catalog_table">
              <thead>
                <tr>
                  <th style="width: 50px;">ردیف</th>
                  <th>عنوان محصول</th>
                  <th>کاتالوگ</th>
                </tr>
              </thead>
            @foreach($catalogs as $item)
              <tr>
                <td style="text-align:center">{{$loop->iteration}}</td>
                <td>{{$item['title']}}</td>
                <td class="product_file">
                  <a href="{{asset('upload/products/'.$item['file'][0])}}" target="_blank">    
                    <span>دریافت کاتالوگ</span>
                  </a>
                </td>
              </td>  
            @endforeach
          </table>
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
@include ('front.layouts.footer')
@endsection
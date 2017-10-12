<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{$config->description}}">
    <meta name="keyword" content="{{$config->keyword}}">

    <title>{{$config->title}} | @yield('title')</title>

    <!-- links -->
    <link rel="stylesheet" href="{{asset('front/styles/css/simplePagination.css')}}">
    <link rel="stylesheet" href="{{asset('front/styles/css/flickity.css')}}">
    <link rel="stylesheet" href="{{asset('front/styles/css/Humber.css')}}">
    <link rel="stylesheet" href="{{asset('front/styles/css/easyzoom.css')}}">
    <link rel="stylesheet" href="{{asset('front/styles/css/import.css')}}">
    <link rel="stylesheet" href="{{asset('front/styles/css/rtl-app.css')}}">
    <!--<link rel="stylesheet" href="{{asset('front/styles/sass/import.scss')}}">-->
 
    <!-- core scripts -->
    <script src="{{asset('front/js/jquery.min.js')}}"></script>
    <script src="{{asset('front/js/jquery.simplePagination')}}"></script>
    <script src="{{asset('front/js/flickity/flickity.pkgd.min.js')}}"></script>
    <script src="{{asset('front/js/slider.js')}}"></script>
    <script src="{{asset('front/js/easyzoom.js')}}"></script>
    <script src="{{asset('front/js/product/Nav_Slider.js')}}"></script>

 

  </head>
  <body>

@yield('main_content')

</body>
</html>
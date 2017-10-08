<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('admin/img/favicon.html')}}">

    <title>{{env('APP_TITLE')}} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/bootstrap-reset.css')}}" rel="stylesheet">
    <script src="{{asset('admin/css/dropzone.css')}}"></script>
    <script src="{{asset('admin/js/jquery-1.8.3.min.js')}}"></script>
    <!--external css-->
    <link href="{{asset('admin/assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/style-responsive.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('admin/fonts/iranianSans/iranianSans.css')}}"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('admin/js/html5shiv.js')}}"></script>
    <script src="{{asset('admin/js/respond.min.js')}}"></script>

    <![endif]-->
</head>


@yield('main_content')

        <!-- js placed at the end of the document so the pages load faster -->
<script src="{{asset('admin/js/jquery.js')}}"></script>
<script src="{{asset('admin/js/jquery-1.8.3.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/jquery.sparkline.js')}}" type="text/javascript"></script>

<script src="{{asset('admin/js/jquery.customSelect.min.js')}}"></script>

<!--custom tagsinput-->
<script src="{{asset('admin/js/jquery.tagsinput.js')}}"></script>
<!--common script for all pages-->
<script src="{{asset('admin/js/common-scripts.js')}}"></script>
<!--script for this page-->
<script src="{{asset('admin/js/form-component.js')}}"></script>
<!--<script src="{{asset('admin/js/dropzone.js')}}"></script>-->

</html>
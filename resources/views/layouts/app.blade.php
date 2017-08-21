<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="{{asset('img/favicon.html')}}">

    <title>{{env('APP_TITLE')}} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-reset.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-1.8.3.min.js')}}"></script>
    <!--external css-->
    <link href="{{asset('assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/iranianSans/iranianSans.css')}}"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>

    <![endif]-->
</head>


@yield('main_content')

        <!-- js placed at the end of the document so the pages load faster -->
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/jquery-1.8.3.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.sparkline.js')}}" type="text/javascript"></script>

<script src="{{asset('js/jquery.customSelect.min.js')}}"></script>

<!--custom tagsinput-->
<script src="{{asset('js/jquery.tagsinput.js')}}"></script>
<!--common script for all pages-->
<script src="{{asset('js/common-scripts.js')}}"></script>
<!--script for this page-->
<script src="{{asset('js/form-component.js')}}"></script>

</html>
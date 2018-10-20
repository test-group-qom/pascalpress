   <!-- Bootstrap core CSS -->
    <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/bootstrap-reset.css')}}" rel="stylesheet">
@section('title','تماس با ما')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')
@include ('front.layouts.logo_min')

<div class="contact">
  <div class="wrapper">
    <div class="flex--contact">
      <div class="flex---right">
          <div class="">
            <h2>اطلاعات تماس</h2><br>
          <?php echo $config->info ?>
        </div>
      </div>
      <div class="flex---left">
      <form class="form-horizontal form-register form-box" method="POST" action="{{ url('contact') }}">
          {{ csrf_field() }}
          <h2>فرم تماس</h2><br>
        @if ($errors->any())
          <div class="alert alert-block alert-danger fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
               <i class="icon-remove"></i>
            </button>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

<!-- show this msg after submit form  -->
@if(Session::has('sendMsg'))
          <div class="alert alert-success">
            {{ Session::get('sendMsg') }}
          </div>
 @endif

        <div class="flex--inputs">

          <div class="flex--input">
            <input class="input" placeholder="نام" name="name" type="text" required>
          </div>

          <div class="flex--input">
            <input class="input" placeholder="ادرس الکترونیکی" name="email" type="text" required>
          </div>

          <textarea name="message" placeholder="متن نظر" class="textarea" rows="8" cols="80" required></textarea>
          
          <button type="submit" class="submit" name="button">ارسال</button>
        
        </div>

        </form>

      </div>
    </div>
  </div>
  
</div>

@include ('front.layouts.footer')
@endsection
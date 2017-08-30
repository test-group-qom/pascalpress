@if(Auth::check())
    @if (Auth::user()->isAdmin())
        <script type="text/javascript">
            window.location = "/admin/dashboard";
        </script>
    @endif
@endif
@section('title', 'ورود')
@extends('admin.layouts.app')
@section('main_content')

    <body class="login-body">

    <div class="container">

        <form class="form-signin" method="post" action="{{ route('login') }}">
            {{csrf_field()}}
            <h2 class="form-signin-heading">ورود به ناحیه کاربری</h2>
            <div class="login-wrap">
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


                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="نام کاربری" autofocus>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="کلمه عبور">
                </div>

                <div class="form-group">
                    <span class="pull-right" style="margin-bottom: 15px;"> <a href="{{ route('password.request') }}">
                            کلمه عبور را فراموش کرده اید؟</a></span>
                </div>

                <button class="btn btn-lg btn-login btn-block" type="submit">ورود</button>


            </div>

        </form>

    </div>

    </body>
@endsection
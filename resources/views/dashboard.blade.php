@if(Auth::user()->isAdmin())
    @section('title', 'داشبورد')
@extends('layouts.app')
@section('main_content')
    <body>
    <section id="container" class="">
        @include('layouts.header')
        @include('layouts.sidebar')
        @section('contents')
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">داشبورد</header>
                        <div class="panel-body" style="min-height: 400px;">

                            <!-- دسترسی سریع -->
                            <section id="dashboard-icon">
                                <ul class="dashboard-menu">


                                    <li>
                                        <a href="/admin/category" class="">
                                            <i class="icon-list-ul" style="color: #ff6c60;"></i>
                                            <span>دسته بندی ها</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="/admin/tag" class="">
                                            <i class="icon-tags" style="color: #90dbff;"></i>
                                            <span>تگ ها</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="/admin/post" class="">
                                            <i class="icon-file-text" style="color: #a9d86e;"></i>
                                            <span>مطالب</span>
                                        </a>
                                    </li>

                                    <li>

                                        <form action="/admin/post" method="post">
                                            {{csrf_field()}}
                                            {{ method_field('GET') }}
                                            <input type="hidden" name="post_type" value="1"/>
                                            <button type="submit"
                                                    style="background:none;border:none;color:#fff;margin:0;padding:0;">
                                                <a>
                                                    <i class="icon-file" style="color: #1ac7a7;"></i>
                                                    <span>صفحات</span>
                                                </a>
                                            </button>
                                        </form>

                                    </li>

                                    <li>
                                        <a href="/admin/product" class="">
                                            <i class="icon-shopping-cart" style="color: #ffbf60;"></i>
                                            <span>محصولات</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="" href="/admin/contact">
                                            <i class="icon-envelope" style="color: #d479bc;"></i>
                                            <span>تماس ها</span>
                                        </a>
                                    </li>

                                    <div style="clear: both"></div>
                                </ul>
                            </section>

                        </div>
                    </section>
                </div>
            </div>
        @stop
        @include('layouts.content')
    </section>
    </body>
@endsection
@endif
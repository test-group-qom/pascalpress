@section('title','محصولات')
@extends('front.layouts.app')
@section('main_content')

@include ('front.layouts.header')
@include ('front.layouts.menu_top')
@include ('front.layouts.logo_min')

    <div class="container news">

    <div class="flex--parnet">
        <div class="flex--cover">


            <img src="{{asset('upload/images/no-image.png')}}" class="img--user"/>

        </div>
        @include ("front.layouts.menu_down")
        <div class="flex--items">
            <div class="flex---items">
                <div class="wrapper">
                    <div class="flex--parent">
                        <div class="flex---products-cat" style="color: #333; height: auto; background: none;">
                            <div class="flex--text">
                                <h3 class="text" style="color: #333; margin-top: 25px;">
                                    دسته های محصولات
                                    <div class="flex--line">
                                        <div class="flex--right">      <!-- right -->
                                            <span class="line"></span>
                                        </div>
                                        <div class="flex--left">          <!-- left -->
                                            <span class="line"></span>
                                        </div>
                                    </div>
                                </h3>
                            </div>
                            <div class="flex--product">
                                <div class="wrapper">
                                    <div>
                                        <div class="flex--pic">
                                            @foreach($categories as $category)
                                            <div class="flex--right product_items">
                                                <div class="min--pic" href="product.php">
                                                    <a href="/products/{{$category->id}}">
                                                    @if($category->thumb != null)
                                                        <img src="{{asset('upload/images/' . $category->thumb )}}" class="img--user">
                                                    @else
                                                        <img src="{{asset('upload/images/no-image.png')}}" class="img--user"/>
                                                        @endif
                                                        {{$category->name}}
                                                    </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="cls"></div>

                                        <!-- pagination -->
                                        @if($count > 6)
                                        <?php
                                        $offset = 0;
                                        $mount = 6;
                                        $total_page = $count / $mount;
                                        $remaining = $count % $mount;
                                        ?>

                                        <ul class="pagination">

                                            <?php
                                            for ($i = 1; $i <= (int) $total_page; $i ++) {
                                                ?>
                                                <li class=""><a href="?offset={{$offset}}" class="button">{{$i}}</a></li>
                                                <?php
                                                $offset += 6;
                                            }

                                            if ($remaining > 0) {
                                                ?>
                                                <li class=""><a href="?offset={{$offset}}" class="button">{{$i}}</a></li>
                                                <?php } ?>
                                        </ul>

                                        @endif
                                        <!-- end pagination -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <br>            
            <br>
            <br>


            @include ('front.layouts.footer')
            @endsection

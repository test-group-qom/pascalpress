@section('title', 'مطالب')
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
                        <header class="panel-heading">مطالب
                            <a href="/admin/post/add" class="btn btn-xs btn-success custom-btn">مطلب جدید</a>
                        </header>
                        <div class="panel-body">

                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th class="text-center" style="width: 110px;">تصویر شاخص</th>
                                    <th>عنوان</th>
                                    <th style="width: 230px;">دسته بندی</th>
                                    <th class="text-center" style="width: 80px;">تاریخ</th>
                                    <th class="text-center" style="width: 60px;">بازدید</th>
                                    <th class="text-center" style="width: 60px;">وضعیت</th>
                                    <th class="text-center" style="width: 110px;">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $all_post as $post)

                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center" style="padding: 0;">
                                            @if($post->thumb!=null)
                                                <img src="{{asset("upload/images/".$post->thumb)}}" width="36px"
                                                     height="36px"
                                                     style=" padding: 1px; border: 1px solid #f0f1df;"/>
                                            @else
                                                <img src="{{asset("upload/images/no-image.png")}}" width="36px"
                                                     height="36px"
                                                     style=" padding: 1px; border: 1px solid #f0f1df;"/>
                                            @endif
                                        </td>
                                        <td>{{$post->title}}</td>
                                        <td>
                                            @foreach($post->category as $cat)
                                                {{$cat}}
                                                @if(count($post->category) > 1)
                                                    {{' ,'}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{$post->publish_date}}</td>
                                        <td class="text-center">{{$post->visit}}</td>
                                        <td class="text-center">
                                            @if($post->status==1)
                                                <a href="/admin/post_status/{{$post->id}}" class="btn btn-success">
                                                    {{ $stateValue='فعال'}}
                                                </a>
                                            @else
                                                <a href="/admin/post_status/{{$post->id}}" class="btn btn-danger">
                                                    {{ $stateValue= 'غیرفعال' }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="/admin/post/edit/{{$post->id}}">
                                                <button type="submit" class="btn btn-primary btn-xs">
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </a>
                                            <form role="form" method="post" action="/admin/post/{{$post->id}}">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-xs"
                                                        onclick='return confirm(" آیا از حذف گزینه مورد نظر اطمینان دارید؟");'>
                                                    <i class="icon-trash "></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <!-- pagination -->
                            @if($count > 10)
                                <?php

                                $offset = 0;
                                $mount = 10;
                                $total_page = $count / $mount;
                                $remaining = $count % $mount;
                                ?>
                                <div class="dataTables_paginate paging_bootstrap pagination">
                                    <ul>

                                        <?php
                                        for($i = 1; $i <= (int) $total_page; $i ++){
                                        ?>
                                        <li class=""><a href="?offset={{$offset}}">{{$i}}</a></li>
                                        <?php
                                        $offset += 10;
                                        }

                                        if($remaining > 0){
                                        ?>
                                        <li class=""><a href="?offset={{$offset}}">{{$i}}</a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </section>
                </div>
            </div>
        @stop

        @include('layouts.content')
    </section>
    </body>
@endsection
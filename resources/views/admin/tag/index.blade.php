@section('title', 'تگ ها')
@extends('admin.layouts.app')
@section('main_content')
    <body>
    <section id="container" class="">
        @section('admin_name')
            {{ Auth::user()->name }}
        @stop
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')

        @section('contents')
            <div class="row">
                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">تگ ها</header>
                        <div class="panel-body">

                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>عنوان</th>
                                    <th class="text-center" style="width: 110px;">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $tags as $tag)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>{{$tag->name}}</td>
                                        <td class="text-center">
                                            <a href="{{ url('admin/tag/edit/'.$tag->id) }}">
                                                <button type="submit" class="btn btn-primary btn-xs" >
                                                    <i class="icon-pencil"></i>
                                                </button>
                                            </a>

                                            <form role="form" method="post" action="{{ url('admin/tag/'.$tag->id) }}">
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
                <div class="col-sm-6">
                    <section class="panel">

                        <header class="panel-heading add">تگ جدید</header>
                        <div class="panel-body" style="padding: 15px !important">
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
                            <form role="form" method="POST" action="{{ url('admin/tag') }}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="tag_name">عنوان تگ</label>
                                    <input type="text" class="form-control" name="name" id="tag_name">
                                </div>
                                <button type="submit" class="btn btn-info">ذخیره</button>
                            </form>

                        </div>
                    </section>
                </div>
            </div>
        @stop

        @include('admin.layouts.content')
    </section>
    </body>
@endsection
@section('title', 'تماس ها')
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
                        <header class="panel-heading">تماس ها</header>
                        <div class="panel-body">

                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>نام</th>
                                    <th>ایمیل</th>
                                    <th>موبایل</th>
                                    <th>پیام</th>
                                    <th class="text-center" style="width: 110px;">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $all_contact as $contact)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>
                                            @if($contact->name == null)
                                                نامشخص
                                            @else
                                                {{$contact->name}}
                                            @endif
                                        </td>
                                        <td>{{$contact->email}}</td>
                                        <td>
                                            @if($contact->mobile == null)
                                                نامشخص
                                            @else
                                                {{$contact->mobile}}
                                            @endif
                                        </td>
                                        <td>{{$contact->message}}</td>
                                        <td class="text-center">
                                            <form role="form" method="post" action="{{url('admin/contact/'.$contact->id)}}">
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
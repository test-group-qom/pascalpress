@section('title', 'ویرایش تگ')
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

                        <header class="panel-heading add">ویرایش دسته بندی</header>
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
                            <form role="form" method="POST" action="{{ url('admin/tag/'.$tag->id) }}">
                                {{csrf_field()}}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label for="tag_name">عنوان تگ</label>
                                    <input type="text" class="form-control" name="name" id="tag_name"
                                           value="{{$tag->name}}">
                                </div>
                                <button type="submit" class="btn btn-info">ذخیره</button>
                                <a href="{{url('/admin/tag')}}" class="btn btn-info">انصراف</a>
                            </form>
                        </div>


                    </section>
                </div>
            </div>

        @stop

        @include('layouts.content')
    </section>
    </body>
@endsection
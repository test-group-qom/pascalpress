@section('title', 'ویرایش دسته محصولات')
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
                            <form role="form" method="POST" action="{{ url('admin/product_cat/'.$oneCat->id) }}">
                                {{csrf_field()}}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label for="cat_name">نام دسته</label>
                                    <input type="text" class="form-control" name="name" id="cat_name"
                                           value="{{$oneCat->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="parent">دسته والد</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">هیچکدام</option>
                                        @foreach( $categories as $category)

                                            @if($category->parent_id == null)

                                                @if($oneCat->parent_id == $category->id)
                                                    <option class="red"
                                                            value="{{$category->id}}"
                                                            selected>{{$category->name}}</option>
                                                @else
                                                    <option class="red"
                                                            value="{{$category->id}}">{{$category->name}}</option>
                                                @endif

                                                @if(count( $category->Childs) > 0 )

                                                    @foreach($category->Childs as $sub1)

                                                        @if($oneCat->parent_id == $sub1->id)
                                                            <option style="color: #666666" value="{{$sub1->id}}"
                                                                    selected><span
                                                                        style="font-size: 18px"> _ </span>{{$sub1->name}}
                                                            </option>
                                                        @else
                                                            <option style="color: #666666" value="{{$sub1->id}}"><span
                                                                        style="font-size: 18px"> _ </span>{{$sub1->name}}
                                                            </option>
                                                        @endif

                                                        @if(count( $sub1->Childs) > 0 )

                                                            @foreach($sub1->Childs as $sub2)

                                                                @if($oneCat->parent_id == $sub2->id)
                                                                    <option style="color: #888888" value="{{$sub2->id}}"
                                                                            selected>
                                                                        <span style="font-size: 18px"> _ _ </span>{{$sub2->name}}
                                                                    </option>
                                                                @else
                                                                    <option style="color: #888888"
                                                                            value="{{$sub2->id}}">
                                                                        <span style="font-size: 18px"> _ _ </span>{{$sub2->name}}
                                                                    </option>
                                                                @endif

                                                            @endforeach

                                                        @endif

                                                    @endforeach

                                                @endif

                                            @endif

                                        @endforeach


                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info">ذخیره</button>
                                <a href="{{url('/admin/product_cat')}}" class="btn btn-info">انصراف</a>
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
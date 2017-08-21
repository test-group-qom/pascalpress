@section('title', 'دسته بندی ها')
@extends('layouts.app')
@section('main_content')
    <body>
    <section id="container" class="">
        @include('layouts.header')
        @include('layouts.sidebar')

        @section('contents')
            <div class="row">
                <div class="col-sm-6">
                    <section class="panel">
                        <header class="panel-heading">دسته بندی ها</header>
                        <div class="panel-body">

                            <table class="table table-advance table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>نام دسته</th>
                                    <th class="text-center" style="width: 110px;">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $num = 1; ?>
                                @foreach( $categories as $category)


                                    @if($category->parent_id == null)

                                        <tr style="background-color: #f5f5f5;">
                                            <td class="text-center">{{$num}}</td>
                                            <td style="color: #9a6f2d;">{{$category->name}}</td>
                                            <td class="text-center">
                                                <a href="{{ url('admin/category/edit/'.$category->id) }}">
                                                    <button type="submit" class="btn btn-primary btn-xs">
                                                        <i class="icon-pencil"></i>
                                                    </button>
                                                </a>

                                                <form role="form" method="post"
                                                      action="{{ url('admin/category/'.$category->id) }}">
                                                    {{csrf_field()}}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-xs"
                                                            onclick='return confirm(" آیا از حذف گزینه مورد نظر اطمینان دارید؟");'>
                                                        <i class="icon-trash "></i>
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>

                                        @if(count( $category->Childs) > 0 )

                                            @foreach($category->Childs as $sub1)
                                                <tr>
                                                    <td class="text-center" style="background: #f5f5f5;"></td>
                                                    <td><span style="font-size: 18px"> _ </span>{{$sub1->name}}</td>
                                                    <td class="text-center">
                                                        <a href="{{ url('admin/category/edit/'.$sub1->id) }}">
                                                            <button type="submit" class="btn btn-primary btn-xs">
                                                                <i class="icon-pencil"></i>
                                                            </button>
                                                        </a>

                                                        <form role="form" method="post"
                                                              action="{{ url('admin/category/'.$sub1->id) }}">
                                                            {{csrf_field()}}
                                                            {{ method_field('DELETE') }}
                                                            <button type="submit" class="btn btn-danger btn-xs"
                                                                    onclick='return confirm(" آیا از حذف گزینه مورد نظر اطمینان دارید؟");'>
                                                                <i class="icon-trash "></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                @if(count( $sub1->Childs) > 0 )

                                                    @foreach($sub1->Childs as $sub2)

                                                        <tr>
                                                            <td class="text-center" style="background: #f5f5f5;"></td>
                                                            <td>
                                                                <span style="font-size: 18px"> _ _ </span>{{$sub2->name}}
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ url('admin/category/edit/'.$sub2->id) }}">
                                                                    <button type="submit"
                                                                            class="btn btn-primary btn-xs">
                                                                        <i class="icon-pencil"></i>
                                                                    </button>
                                                                </a>

                                                                <form role="form" method="post"
                                                                      action="{{ url('admin/category/'.$sub2->id) }}">
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
                                                @endif

                                            @endforeach

                                        @endif
                                        <?php $num ++; ?>
                                    @endif


                                @endforeach

                                </tbody>
                            </table>


                        </div>


                    </section>
                </div>
                <div class="col-sm-6">
                    <section class="panel">

                        <header class="panel-heading add">دسته بندی جدید</header>
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
                            <form role="form" method="POST" action="{{url('/admin/category/')}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="cat_name">نام دسته</label>
                                    <input type="text" class="form-control" name="name" id="cat_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent">دسته والد</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">هیچکدام</option>

                                        @foreach( $categories as $category)

                                            @if($category->parent_id == null)

                                                <option class="red" value="{{$category->id}}">{{$category->name}}</option>

                                                @if(count( $category->Childs) > 0 )

                                                    @foreach($category->Childs as $sub1)

                                                        <option style="color: #666666" value="{{$sub1->id}}"><span style="font-size: 18px"> _ </span>{{$sub1->name}}</option>

                                                        @if(count( $sub1->Childs) > 0 )

                                                            @foreach($sub1->Childs as $sub2)

                                                                <option style="color: #888888" value="{{$sub2->id}}"><span style="font-size: 18px"> _ _ </span>{{$sub2->name}}</option>

                                                            @endforeach

                                                        @endif

                                                    @endforeach

                                                @endif

                                            @endif

                                        @endforeach

                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info">ذخیره</button>
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
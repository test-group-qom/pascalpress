@section('title', 'ویرایش محصول')
@extends('admin.layouts.app')
@section('main_content')

        <!--CKEditor-->
<script src="{{asset('plugin/ckeditor/ckeditor.js') }}"></script>
<!--CKEditor-->

<body>
<section id="container" class="">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    @section('contents')

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading add">ویرایش محصول</header>
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


                        <form role="form" method="POST" class="form-horizontal tasi-form"
                              action="/admin/product/{{$post->id}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            {{method_field('PUT')}}

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">تصویر</label>
                                    <div class="col-lg-10">
                                        <input type="file" name="thumb" class="btn btn-default btn-sm">
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">عنوان</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="title" value="{{$post->title}}"
                                               required>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group" style="margin-left: 0;margin-right: 0;">
                                    <textarea name="content" id="editor1" required>{{$post->content}}</textarea>
                                    <script>
                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        CKEDITOR.replace('editor1', {
                                            width: '100%',
                                            filebrowserBrowseUrl: '{{asset("plugin/kcfinder/browse.php?type=files")}}',
                                            filebrowserImageBrowseUrl: '{{asset("plugin/kcfinder/browse.php?type=images")}}',
                                            filebrowserFlashBrowseUrl: '{{asset("plugin/kcfinder/browse.php?type=flash")}}',
                                            filebrowserUploadUrl: '{{asset("plugin/kcfinder/upload.php?type=files")}}',
                                            filebrowserImageUploadUrl: '{{asset("plugin/kcfinder/upload.php?type=images")}}',
                                            filebrowserFlashUploadUrl: '{{asset("plugin/kcfinder/upload.php?type=flash")}}'
                                        });
                                    </script>

                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">کاربرد</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="usage" id="usage"
                                               value="{{$post->usage}}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">قیمت</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="price" id="price"
                                               value="{{$post->price}}" required/>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4">
                                <?php
                                $cat_ids = array();
                                $post_productCat = $post->productCat;
                                foreach ( $post_productCat as $pc ) {
                                    array_push( $cat_ids, $pc->id );
                                }
                                ?>
                                <label class=" red">دسته بندی</label>
                                <div class="form-group">

                                    <div class="col-lg-10 checkbox-container" style="height: 532px;">
                                        @foreach( $categories as $category)

                                            @if($category->parent_id == null)

                                                <div class="checkbox-box">

                                                    @if(in_array($category->id,$cat_ids))
                                                        <label class="checkbox-inline red" >
                                                            <input type="checkbox" name="cat_id[]"
                                                                   value="{{$category->id}}" checked>{{$category->name}}
                                                        </label>
                                                    @else
                                                        <label class="checkbox-inline red" >
                                                            <input type="checkbox" name="cat_id[]"
                                                                   value="{{$category->id}}">{{$category->name}}
                                                        </label>
                                                    @endif

                                                    @if(count( $category->Childs) > 0 )

                                                        @foreach($category->Childs as $sub1)

                                                                @if(in_array($sub1->id,$cat_ids))
                                                                    <label class="checkbox-inline checkbox-lvl1">
                                                                        <input type="checkbox" name="cat_id[]"
                                                                               value="{{$sub1->id}}" checked>{{$sub1->name}}
                                                                    </label>
                                                                @else
                                                                    <label class="checkbox-inline checkbox-lvl1" >
                                                                        <input type="checkbox" name="cat_id[]"
                                                                               value="{{$sub1->id}}">{{$sub1->name}}
                                                                    </label>
                                                                @endif

                                                            @if(count( $sub1->Childs) > 0 )

                                                                @foreach($sub1->Childs as $sub2)

                                                                            @if(in_array($sub2->id,$cat_ids))
                                                                    <label class="checkbox-inline checkbox-lvl2">
                                                                        <input type="checkbox" name="cat_id[]"
                                                                               value="{{$sub2->id}}" checked>{{$sub2->name}}
                                                                    </label>
                                                                            @else
                                                                                <label class="checkbox-inline checkbox-lvl2">
                                                                                    <input type="checkbox" name="cat_id[]"
                                                                                           value="{{$sub2->id}}">{{$sub2->name}}
                                                                                </label>
                                                                                @endif


                                                                @endforeach
                                                            @endif

                                                        @endforeach

                                                    @endif

                                                </div>
                                            @endif

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="clear" style="margin-bottom: 15px"></div>

                            <button type="submit" class="btn btn-info">ذخیره</button>
                            <a href="{{url('/admin/product')}}" class="btn btn-info">انصراف</a>
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
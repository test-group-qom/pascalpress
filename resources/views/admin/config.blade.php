@section('title', 'تنظیمات')
@extends('admin.layouts.app')
@section('main_content')

<!--CKEditor-->
<script src="{{asset('admin/plugin/ckeditor/ckeditor.js') }}"></script>
<!--CKEditor-->

<body>
<section id="container" class="">
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    @section('contents')

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading add">تنظیمات</header>
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
                        <form role="form" class="form-horizontal tasi-form" method="POST" action="{{ url('admin/config/'.$config->id) }}">
                            {{csrf_field()}}
                            {{ method_field('PUT') }}
                            <div class="form-group">
                                <label class="control-label col-lg-2 red">عنوان سایت</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="title" value="{{$config->title}}"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2 red">توضیحات</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="description"
                                           value="{{$config->description}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2 red">کلمات کلیدی (با کاما "," از هم جدا
                                    کنید)</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="keyword" value="{{$config->keyword}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2 red">متن کپی رایت</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="copyright"
                                           value="{{$config->copyright}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2 red">اطلاعات تماس</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="editor1" name="info">
                                        {{$config->info}}
                                    </textarea>
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
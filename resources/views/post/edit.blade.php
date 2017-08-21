@section('title', 'ویرایش مطلب')
@extends('layouts.app')
@section('main_content')

        <!--CKEditor-->
<script src="{{asset('plugin/ckeditor/ckeditor.js') }}"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!--CKEditor-->

<body>
<section id="container" class="">
    @include('layouts.header')
    @include('layouts.sidebar')

    @section('contents')

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading add">ویرایش مطلب</header>
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


                        <form role="form" method="POST" action="/admin/post/{{$post->id}}"
                              class="form-horizontal tasi-form"
                              enctype="multipart/form-data" onsubmit="return getTags()">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="col-lg-8">

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">تصویر شاخص</label>
                                    <div class="col-lg-10">
                                        <input type="file" name="thumb" class="btn btn-default btn-sm">
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">عنوان</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="title" name="title"
                                               value="{{$post->title}}"
                                               required>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">خلاصه مطلب</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" name="excerpt"
                                                  style="line-height:18px;padding:10px 5px;height:100px;"
                                                  required>{{$post->excerpt}}</textarea>
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
                                    <?php
                                    $all = array();
                                    $tag_ids = array();
                                    $tag_names = array();
                                    $postTags = $post->tags;



                                    foreach ( $postTags as $pt ) {
                                        array_push( $tag_ids, $pt->id );
                                        array_push( $tag_names, $pt->name );
                                    }

                                    $all = $postTags->map( function ( $item ) {
                                        $new         = array();
                                        $new['id']   = $item->id;
                                        $new['name'] = $item->name;

                                        return $new;
                                    } );

                                    //$all = array_combine( $tag_ids, $tag_names );


                                    ?>
                                    <label class="control-label col-lg-2 red">تگ</label>
                                    <div class="col-lg-10">
                                        <input name="tags" id="tagsinput" class="tagsinput"
                                               value="{{implode(',',$tag_names)}}"/>
                                        <input type="hidden" id="result_tags" name="result_tags" value="">
                                        <div id="tag_suggestion"></div>
                                    </div>
                                    <script type="text/javascript">

                                        var tags = <?php echo json_encode( $tags ); ?>;

                                        function getTags() {
                                            //first object from php
                                            var valarray = <?php echo json_encode( $all ); ?>;
                                            str = JSON.stringify(tags);

                                            // tagsinput entry
                                            var entry = document.getElementById("tagsinput").value;
                                            entry = entry.split(',');

                                            var exist_result = [];
                                            var new_tags = [];
                                            for (var i = 0; i < entry.length; i++) {
                                                for (var j = 0; j < tags.length; j++) {
                                                    if (tags[j].name === entry[i]) {
                                                        exist_result.push(tags[j].id);
                                                    }
                                                }
                                            }

                                            document.getElementById('result_tags').value = exist_result;
                                        }

                                        // make unique array
                                        function onlyUnique(value, index, self) {
                                            return self.indexOf(value) === index;
                                        }

                                        // suggestion list of tags
                                        function makeUL(data) {
                                            var a = '<ul id="suggestion">';
                                            var b = '</ul>';
                                            var m = [];

                                            for (var i = 0; i < data.length; i++) {
                                                m += '<li ><a>' + data[i] + '</a></li>';
                                            }

                                            document.getElementById('tag_suggestion').innerHTML = a + m + b;
                                        }


                                        $(document).on('keyup', "#tagsinput_addTag input[id='tagsinput_tag']", function () {
                                            if (this.value.length < 3) {
                                                document.getElementById('tag_suggestion').style["display"] = "none";
                                            } else {

                                                var suggestion = [];
                                                for (var i = 0; i < tags.length; i++) {
                                                    if (tags[i].name.includes(this.value)) {
                                                        document.getElementById('tag_suggestion').style["display"] = "block";
                                                        suggestion.push(tags[i].name);
                                                        var unique = suggestion.filter(onlyUnique);
                                                    }
                                                }

                                                if (unique != null) {
                                                    makeUL(unique);
                                                }

                                            }
                                        });

                                        $(document).on('mousedown', "ul#suggestion li", function () {
                                            var tag_input = $("#tagsinput_addTag input[id='tagsinput_tag']");
                                            tag_input.val($(this).text());
                                            e = jQuery.Event("keypress")
                                            e.which = 13 //choose the one you want
                                            tag_input.keypress(function(){

                                            }).trigger(e)
                                            //alert($(this).text());
                                        });
                                        $(document).on('mouseup', "ul#suggestion li a", function () {
                                            document.getElementById('tag_suggestion').style["display"] = "none";
                                        });

                                    </script>

                                    <div class="clear"></div>
                                </div>

                            </div>

                            <div class="col-lg-4">
                                <?php
                                $cat_ids = array();
                                $postCat = $post->category;
                                foreach ( $postCat as $pc ) {
                                    array_push( $cat_ids, $pc->id );
                                }
                                ?>

                                <label class=" red">دسته بندی</label>
                                <div class="form-group">

                                    <div class="col-lg-10 checkbox-container">
                                        @foreach($categories as $category)

                                            @if($category->parent_id == null)

                                                <div class="checkbox-box">

                                                    @if(in_array($category->id,$cat_ids))
                                                        <label class="checkbox-inline" style="color: #749413;">
                                                            <input type="checkbox" name="tag_id[]"
                                                                   value="{{$category->id}}" checked>{{$category->name}}
                                                        </label>
                                                    @else
                                                        <label class="checkbox-inline" style="color: #749413;">
                                                            <input type="checkbox" name="tag_id[]"
                                                                   value="{{$category->id}}">{{$category->name}}
                                                        </label>
                                                    @endif



                                                    @if(count( $category->Childs) > 0 )

                                                        @foreach($category->Childs as $sub1)


                                                            @if(in_array($sub1->id,$cat_ids))
                                                                <label class="checkbox-inline checkbox-lvl1">
                                                                    <input type="checkbox" name="tag_id[]"
                                                                           value="{{$sub1->id}}" checked>{{$sub1->name}}
                                                                </label>
                                                            @else
                                                                <label class="checkbox-inline checkbox-lvl1">
                                                                    <input type="checkbox" name="tag_id[]"
                                                                           value="{{$sub1->id}}">{{$sub1->name}}
                                                                </label>
                                                            @endif



                                                            @if(count( $sub1->Childs) > 0 )

                                                                @foreach($sub1->Childs as $sub2)


                                                                    @if(in_array($sub2->id,$cat_ids))
                                                                        <label class="checkbox-inline checkbox-lvl2">
                                                                            <input type="checkbox" name="tag_id[]"
                                                                                   value="{{$sub2->id}}"
                                                                                   checked>{{$sub2->name}}
                                                                        </label>
                                                                    @else
                                                                        <label class="checkbox-inline checkbox-lvl2">
                                                                            <input type="checkbox" name="tag_id[]"
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
                            <a href="{{url('/admin/post')}}" class="btn btn-info">انصراف</a>
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
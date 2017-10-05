<?php
if ( $post_type == 0 ) {
    $title = 'مطلب';
} elseif ( $post_type == 1 ) {
    $title = 'صفحه';
} else {
    $title = 'محصول';
}
?>
@section('title', 'افزودن '.$title)
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
                    <header class="panel-heading add">افزودن
                        {{$title}}
                    </header>
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
                        <form role="form" class="form-horizontal tasi-form dropzone" id="my-awesome-dropzone" method="POST" action="/admin/post"
                              enctype="multipart/form-data" onsubmit="return getTags();check_spec();">
                            {{csrf_field()}}
                            <input type="hidden" name="post_type" value="{{$post_type}}">
                            <div class="col-lg-8">

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">تصویر
                                        شاخص</label>
                                    <div class="col-lg-10">
                                        <input type="file" name="thumb" class="btn btn-default btn-sm">
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">عنوان</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="title" required>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                @if($post_type==0)
                                <div class="form-group">
                                    <label class="control-label col-lg-2 red">خلاصه مطلب</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" name="excerpt"
                                                  style="line-height:18px;padding:10px 5px;height:100px;"></textarea>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                @endif


                                <div class="form-group" style="margin-left: 0;margin-right: 0;">
                                    <textarea name="content" id="editor1" required></textarea>
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

                                    $all = $tags->map( function ( $item ) {
                                        $new         = array();
                                        $new['id']   = $item->id;
                                        $new['name'] = $item->name;

                                        return $new;
                                    } );
                                    ?>

                                    <label class="control-label col-lg-2 red">تگ</label>
                                    <div class="col-lg-10">
                                        <input name="tags" id="tagsinput" class="tagsinput" value=""/>
                                        <input type="hidden" id="result_tags" name="result_tags" value="">
                                        <div id="tag_suggestion"></div>
                                    </div>
                                    <script type="text/javascript">

                                        var tags = <?php echo json_encode( $all ); ?>;

                                        function getTags() {
                                            //first object from php
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
                                            tag_input.keypress(function () {

                                            }).trigger(e)
                                            //alert($(this).text());
                                        });
                                        $(document).on('mouseup', "ul#suggestion li a", function () {
                                            document.getElementById('tag_suggestion').style["display"] = "none";
                                        });

                                    </script>
                                    <div class="clear"></div>
                                </div>

                                @if($post_type==2)
                                    <div class="form-group">
                                        <label class="control-label col-lg-2 red">مشخصات کلی</label>
                                        <div class="col-lg-10">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4" style="padding: 3px">مشخصه</div>
                                                <div class="col-lg-2" style="padding: 3px">مقدار</div>
                                                <div class="col-lg-3" style="margin-right: 10px;">
                                                    <button type="button" class="btn btn-success btn-xs"
                                                            onclick="addRow('specTable')" style="width: 100px">
                                                        افزودن مشخصه
                                                    </button>
                                                </div>
                                                <div class="clear"></div>
                                            </div>

                                            <table id="specTable" style="margin: 5px 15px; width: 70%">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="spec_name[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="spec_value[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                                onclick=" deleteRow('specTable',this); ">
                                                            <i class="icon-trash "></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="clear"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2 red">ویژگی ها</label>
                                        <div class="col-lg-10">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4" style="padding: 3px">ویژگی</div>
                                                <div class="col-lg-2" style="padding: 3px">مقدار</div>
                                                <div class="col-lg-3" style="margin-right: 10px;">
                                                    <button type="button" class="btn btn-success btn-xs"
                                                            onclick="addRow('propTable')" style="width: 100px">
                                                        افزودن ویژگی
                                                    </button>
                                                </div>
                                                <div class="clear"></div>
                                            </div>

                                            <table id="propTable" style="margin: 5px 15px; width: 70%">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="prop_name[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="prop_value[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                                onclick=" deleteRow('propTable',this); ">
                                                            <i class="icon-trash "></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                        <div class="clear"></div>
                                        <script>
                                            function addRow(tableID) {
                                                var table = document.getElementById(tableID);
                                                var rowCount = table.rows.length;
                                                var row = table.insertRow(rowCount);
                                                var colCount = table.rows[0].cells.length;
                                                for (var i = 0; i < colCount; i++) {
                                                    var newcell = row.insertCell(i);
                                                    newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                                                }
                                            }

                                            function getId(element) {
                                                rowNumber = element.parentNode.parentNode.rowIndex;
                                                cellNumber = element.parentNode.cellIndex;
                                                return rowNumber;
                                            }

                                            function deleteRow(tableID, rowNum) {
                                                var target_row = getId(rowNum);
                                                var table = document.getElementById(tableID);
                                                var rowCount = table.rows.length;
                                                if (rowCount > 1) {
                                                    table.deleteRow(target_row);
                                                }
                                            }
                                        </script>
                                    </div>




                                    <div class="form-group">
                                        <label class="control-label col-lg-2 red">کاتالوگ</label>
                                        <div class="col-lg-10">

                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>

                                        </div>
                                        <div class="clear"></div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-2 red">فیلم ها</label>
                                        <div class="col-lg-10">
                                            <input type="file" name="video" class="btn btn-default btn-sm">
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                @endif

                            </div>

                            <div class="col-lg-4">

                                <label class=" red">دسته بندی</label>
                                <div class="form-group">

                                    <div class="col-lg-10 checkbox-container">
                                        @foreach($categories as $category)

                                            @if($category->parent_id == null)

                                                <div class="checkbox-box">


                                                    <label class="checkbox-inline" style="color: #749413;">
                                                        <input type="checkbox" name="cat_id[]"
                                                               value="{{$category->id}}">{{$category->name}}
                                                    </label>


                                                    @if(count( $category->Childs) > 0 )

                                                        @foreach($category->Childs as $sub1)

                                                            <label class="checkbox-inline checkbox-lvl1">
                                                                <input type="checkbox" name="cat_id[]"
                                                                       value="{{$sub1->id}}">{{$sub1->name}}
                                                            </label>


                                                            @if(count( $sub1->Childs) > 0 )

                                                                @foreach($sub1->Childs as $sub2)

                                                                    <label class="checkbox-inline checkbox-lvl2">
                                                                        <input type="checkbox" name="cat_id[]"
                                                                               value="{{$sub2->id}}">{{$sub2->name}}
                                                                    </label>

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
                        </form>

                            <form action="/upload" class="dropzone needsclick dz-clickable" id="demo-upload">

                                <div class="dz-message needsclick">
                                    Drop files here or click to upload.<br>
                                    <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                                </div>

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
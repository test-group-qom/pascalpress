@section('title', 'جزییات تماس')
@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header card-header-icon" data-background-color="rose">
                    <i class="material-icons">mode_edit</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">{{trans('labels.category.edit_category_detail')}}</h4>
                    {{ Form::model($category, array('route' => array('category.update', $category->id), 'method' => 'PUT'))  }}
                        {{csrf_field()}}
                        <div class="row">
                            <label class="col-md-3 label-on-left">{{trans('labels.category.title')}}</label>
                            <div class="col-md-9">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label"></label>
                                    <input type="text" value="{{$category->title}}" name="title" class="form-control">
                                    <span class="material-input"></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label-on-left">{{trans('labels.book.parent')}}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="parent" class="selectpicker" data-live-search="true">
                                        <option value="{{null}}">{{trans('labels.book.parent')}}</option>
                                        @foreach($categories as $cat)
                                            @php($selected=($cat->id == $category->id)?'selected':'')
                                            <option {{$selected}} value="{{$cat->id}}">{{$cat->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-fill btn-rose">{{trans('labels.book.update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
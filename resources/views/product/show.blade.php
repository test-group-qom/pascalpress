@extends('layouts.app')
@section('keywords')
    {{json_decode($product->title)->fa}}, {{json_decode($product->title)->en}},{{json_decode($product->title)->ar}}
@endsection
@section('content')
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h1 class="panel-title"> {{json_decode($product->title)->fa}}</h1>
            </div>
            <div class="panel-body">
                <h2>Details:<span class="badge">{{count($product->productDetails)}}</span></h2>
                <hr>
                <div class="row">
                    @foreach($product->productDetails as $productDetail)
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

                            <div class="well well-sm">
                                <div class="text-center">Detail:#{{$loop->iteration}} -
                                    Language: {{$productDetail->language}}</div>
                                <h5>
                                    <span class="label label-info">spesefication:</span>{{$productDetail->spesefication}}
                                </h5>
                                <h5><span class="label label-info">config:</span>{{$productDetail->config}}</h5>
                                <h5><span class="label label-info">descriptions:</span>{{$productDetail->descriptions}}
                                </h5>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h2>Files:<span class="badge">{{count($product->productFiles)}}</span></h2>
                <hr>
                <div class="row">
                    @foreach($product->productFiles as $productFile)
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

                            <div class="well well-sm">
                                <div class="text-center">File:#{{$loop->iteration}}</div>
                                <h5><span class="label label-info">type:</span>{{$productFile->type}}</h5>
                                <h5><span class="label label-info">path:</span>{{$productFile->path}}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('keywords')
    @foreach($products as $product)
        {{json_decode($product->title)->fa}}, {{json_decode($product->title)->en}},{{json_decode($product->title)->ar}}
    @endforeach
@endsection
@section('content')
    @foreach($products as $product)
        <div class="container">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h1 class="panel-title"><span
                                class="badge">#{{$loop->iteration}}</span> <a
                                href="{{url('/productDetail/'.$product->id.'?language='.$language)}}">{{json_decode($product->title)->fa}}</a>
                    </h1>
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
                                    <h5>
                                        <span class="label label-info">descriptions:</span>{{$productDetail->descriptions}}
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
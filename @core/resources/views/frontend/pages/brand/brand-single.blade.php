@extends('frontend.frontend-page-master')

@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.brand.single',$brand->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$brand->title}}" />
    <meta property="og:image" content="" />
@endsection
@section('page-meta-data')
    <meta name="description" content="">
    <meta name="tags" content="{{$brand->meta_tag}}">
@endsection
@section('site-title')
    {{$brand->title}}
@endsection
@section('page-title')
    {{$brand->title}}
@endsection
@section('content')
    <!-- Add brand content here -->
@endsection
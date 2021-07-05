@extends('layouts.template')

@section('page-title','最新消息')

@section('css')
<style>
</style>
@endsection


@section('main')
<div class="container my-3">
    @foreach ( $news as $item )
    <h1>第{{$item->id}}筆資料</h1>
    <h1>{{ $item->title }}</h1>
    <h2>{{ $item->publish_date }}</h2>
    {!! $item->content !!}
    <hr>
    @endforeach
</div>
@endsection


@section('js')

@endsection

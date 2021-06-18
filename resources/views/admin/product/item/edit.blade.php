@extends('layouts.app')

@section('page-title','產品品項編輯')


@section('css')
    <style>
        .card-header h2{
            margin-bottom: 0
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('admin/home') }}">Home</a></li>
                <li class="breadcrumb-item"active>產品管理</li>
                <li class="breadcrumb-item"><a href="{{ asset('/admin/product/item') }}">產品品項管理</a></li>
                <li class="breadcrumb-item active" aria-current="page">產品品項編輯</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>產品品項編輯</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ asset('/admin/product/item/update') }}/{{ $record->id }}"  method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="product_type_id">產品種類</label>
                                <select class="form-control" id="product_type_id" name="product_type_id">
                                    @foreach ($type as $item)
                                        <option @if($item->id === $record->type->id ) selected @endif value="{{ $item->id }}">{{ $item->type_name }}</option>
                                        {{-- <option @if ($record->type ==$item) selected @endif value="{{ $item->id }}">{{ $item-> type_name }}</option> --}}
                                        @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="product_name">產品品項名稱</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $record->product_name }}">
                            </div>

                            <div class="form-group">
                                <label for="price">價格</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ $record->price }}">
                            </div>

                            {{-- 讓使用者可以在編輯資料時，砍掉關聯的圖片 --}}
                            <div class="form-group row">
                                <label class="col-12" for="">既有產品內容圖片</label>
                                @foreach ($photos as $item)
                                    <div class="col-md-3">
                                        <img class="w-100" src="{{ $item->photo }}" alt="">
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="photos">新增產品內容圖片</label>
                                <input type="file" class="form-control" id="photos" name="photos[]" multiple>
                            </div>

                            <div class="form-group">
                                <label for="discript">產品描述</label>
                                <textarea class="form-control" name="discript" id="discript" cols="30" rows="10">{{ $record->discript }}</textarea>
                                {{-- <input type="text" class="form-control" id="discript" name="discript"> --}}
                            </div>

                            <button type="submit" class="btn btn-primary">編輯</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

@extends('layouts.app')

@section('page-title','聯絡我們-查看更多')


@section('css')
<style>
    .card-header h2 {
        margin-bottom: 0
    }
    .more-card{
        margin: 0 0 20px 0 ;
    }

    .more-title {
        font-size: 20px;
        font-weight: 600;
        color: plum;
    }
</style>
@endsection

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ asset('admin/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ asset('/admin/contactus') }}">聯絡我們管理</a></li>
            <li class="breadcrumb-item active" aria-current="page">聯絡我們-查看更多</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>聯絡我們-查看更多</h2>
                </div>


                <div class="card-body">
                    <div class="more-card">
                        <div class="more-title">姓名 : </div>
                        <td>{{ $more->name }}</td>
                    </div>
                    <div class="more-card">
                        <div class="more-title">信箱 : </div>
                        <td>{{ $more->email }}</td>
                    </div>
                    <div class="more-card">
                        <div class="more-title">主旨 : </div>
                        <td>{{ $more->subject }}</td>
                    </div>
                    <div class="more-card">
                        <div class="more-title">內文 : </div>
                        <td>{{ $more->message }}</td>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#my-datatable').DataTable();
    });
</script>
@endsection

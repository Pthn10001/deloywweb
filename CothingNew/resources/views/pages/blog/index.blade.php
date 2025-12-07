@extends('layout')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 60px;">
    <h2 class="text-center mb-4">📰 Blog Thời Trang</h2>
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset($post['image']) }}" class="card-img-top" alt="{{ $post['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post['title'] }}</h5>
                        <p class="card-text">{{ $post['summary'] }}</p>
                        <a href="{{ $post['link'] }}" class="btn btn-outline-primary btn-sm">Đọc thêm</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

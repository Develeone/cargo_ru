@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="block ads banner no-margin" id="ads-block-1"></div>
    </div>

    <div class="row top-buffer">
        <div class="col-md-2 ads-container">
            @include('includes.left_sidebar')
        </div>
        <div class="col-md-8">
            @yield('central_content')
        </div>
        <div class="col-md-2 ads-container">
            @include('includes.right_sidebar')
        </div>
    </div>

@endsection

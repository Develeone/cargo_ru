@extends('layouts.sidebars')

@section('central_content')
    <H1>Реклама, типа</H1>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            SetAdsBlocksAsPayable();
        });
    </script>
@endsection
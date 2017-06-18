@extends('layouts.sidebars')

@section('central_content')
    <div class="col-md-offset-1 col-md-10 no-padding">
        <ul class="nav nav-tabs categories">
            @for($i = 0; $i < $categories->count(); $i++)
                <li class="col-md-2 no-padding {{$i == 0 ? 'active' : ''}}">
                    <a data-toggle="tab" href="#category" class="category-tab" data-category-id="{{$categories[$i]->id}}">{{$categories[$i]->name}}</a>
                </li>
            @endfor
        </ul>
    </div>
    <hr class="clearfix"/>

    <div class="tab-content">
        @foreach($categories as $category)
            @include('includes.category_tab_content')
        @endforeach
    </div>

    @include('includes.question_modal')
    @include('includes.new_question_modal')
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            SetAdsBlocks();
        });
    </script>
@endsection
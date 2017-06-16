@extends('layouts.sidebars')

@section('central_content')
    <ul class="nav nav-tabs">
        @for($i = 0; $i < $categories->count(); $i++)
            <li class="{{$i == 0 ? 'active' : ''}}">
                <a data-toggle="tab" href="#category" class="category-tab" data-category-id="{{$categories[$i]->id}}">{{$categories[$i]->name}}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content">
        @include('includes.category_tab_content')
    </div>

    @include('includes.question_modal')
    @include('includes.new_question_modal')
@endsection
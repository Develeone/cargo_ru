@extends('layouts.sidebars')

@section('questions')
    <ul class="nav nav-tabs">
        @for($i = 0; $i < $categories->count(); $i++)
            <li class="{{$i == 0 ? 'active' : ''}}">
                <a data-toggle="tab" href="#{{$categories[$i]->name}}">{{$categories[$i]->name}}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content">

        @foreach($categories as $category)
            @include('includes.category_tab_content')
        @endforeach
    </div>

    @include('includes.question_modal')
    @include('includes.new_question_modal')
@endsection
<div id="{{$category->name}}" class="tab-pane fade {{$category == $categories->first() ? 'in active':''}}">

    @if($category->needCities)
        <select class="questions-by-city-select">
            <option value="all">Все города</option>
            @foreach($category->cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    @endif


    @foreach($category->groupedQuestions as $date => $questionsOfDate)
        <div class="questions-of-date" data-day="{{ $date }}">

            <H4>{{ $date }}</H4>
            @foreach($questionsOfDate as $question)
                @include('includes.question', ["question" => $question])
            @endforeach
        </div>
    @endforeach

</div>
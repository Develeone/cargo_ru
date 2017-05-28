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
        <H4>{{ $date }}</H4>

        @foreach($questionsOfDate as $question)
            @include('includes.question', ["question" => $question])
        @endforeach
    @endforeach

</div>
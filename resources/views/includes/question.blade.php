<div class="question panel panel-primary cursor-pointer"
    data-question-id="{{$question->id}}"
    data-city-id="{{$question->city_id}}"
    data-toggle="modal"
    data-target="#question-modal"
    onclick="LoadQuestionModal({{$question->id}})">

    <div class="panel-heading">
        <input type="checkbox" {{ $question->solved ? "checked" : "" }} disabled class="question-solved-checkbox">
        {{ $question->text }}
    </div>

    <div class="panel-body">Ответов: <b class="answers-count" data-question-id="{{$question->id}}">{{ $question->answers->count() }}</b>... Вопрос опубликован: {{ $question->created_at }}</div>

</div>
<div id="new-question-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="question-text">
                    Задать вопрос
                </h4>
            </div>
            <div class="modal-body">
                <form id="new-question">
                    {{ csrf_field() }}
                    <p>
                        <select name="category_id" class="category-select">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" data-need-cities="{{!is_null($category->needCities)}}">
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>

                        <select name="city_id" class="city-select {{ is_null($categories->first()->needCities) ? 'hidden' : '' }}">
                            <option selected disabled>Выберите город</option>
                            @foreach(\App\City::all() as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </p>

                    <textarea name="text" placeholder="Введите свой вопрос"></textarea>

                    <p><input type="submit" id="submit-question-button" value="Отправить"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
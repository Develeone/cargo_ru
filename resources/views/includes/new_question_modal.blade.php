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
                    <div class="form-group">
                        <select name="category_id" class="category-select form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>

                        <select name="country_id" class="country-select form-control top-buffer hidden" disabled>
                            <option selected disabled>Выберите страну</option>
                            @foreach(\App\Country::all() as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>

                        <select name="region_id" class="region-select form-control top-buffer hidden" disabled>
                            <option selected disabled>Выберите регион</option>
                        </select>

                        <select name="city_id" class="city-select form-control top-buffer hidden" disabled>
                            <option selected disabled>Выберите город</option>
                        </select>
                    </div>

                    <textarea name="text" placeholder="Введите свой вопрос" class="form-control" maxlength="500" id="new-question-text"></textarea>

                    <br />

                    <div id="new-question-recaptcha"></div>

                    <p><input type="submit" id="submit-question-button" value="Отправить" class="form-control btn-success top-buffer"></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
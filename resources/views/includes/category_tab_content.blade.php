<div id="category-content" class="tab-pane fade in active">

    <select name="country_id" class="country-select form-control top-buffer hidden" disabled>
        <option selected value='all'>Все страны</option>
        @foreach(\App\Country::all() as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
        @endforeach
    </select>

    <select name="region_id" class="region-select form-control top-buffer hidden" disabled>
        <option selected value='all'>Все регионы</option>
    </select>

    <select name="city_id" class="city-select form-control top-buffer hidden" disabled>
        <option selected value='all'>Все города</option>
    </select>


    <script type="text/template" id="category-questions-template">
        <% for (var dateGroup in category.groupedQuestions) { %>
        <div class="questions-of-date">
            <div class="centered-content">
                <H4 class="label label-info"><%- dateGroup %></H4>
            </div>

            <% category.groupedQuestions[dateGroup].forEach(function(question) { %>
                <div class="question panel panel-primary cursor-pointer"
                    data-question-id="<%- question.id %>"
                    data-toggle="modal"
                    data-target="#question-modal"
                    onclick="LoadQuestionModal('<%- question.id %>')">

                    <div class="panel-heading">
                        <input type="checkbox" disabled class="question-solved-checkbox"
                            <% question.solved ? "checked" : "" %>
                        >
                        <%- question.text %>
                    </div>

                </div>
            <% }); %>
        </div>
        <% } %>
    </script>

    <div id="category-questions">

    </div>

</div>
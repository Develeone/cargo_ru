<div id="category-content" class="tab-pane fade in active">

    <script type="text/template" id="category-cities-template">
        <% if (category.need_cities) { %>
            <div class="form-group" id="category-cities-selector-container">
                <select class="questions-by-city-select form-control top-buffer" onchange="CategoryCityChanged($(this))">
                    <option value="all">Все города</option>
                    @foreach($regions as $region)
                        <option disabled>{{ $region->name }}</option>

                        @foreach($region->cities as $city)
                            <option value="{{ $city->id }}" <%- category.city == {{ $city->id }} ? "selected" : "" %> >{{ $city->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        <% } %>
    </script>

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
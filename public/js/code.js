var selectedCategoryId = 0;

$("#new-answer").submit(function (e) {
    e.preventDefault();

    $.post('/answer/new', $(this).serialize(), function (question_id) {
        LoadQuestionModal(question_id);

        var answers_counter = $(".question[data-question-id='"+question_id+"'] .answers-count");
        var question_solved_checkbox = $(".question[data-question-id='"+question_id+"'] .question-solved-checkbox");

        var answers_count = parseInt(answers_counter.html());
        answers_counter.html(++answers_count);

        if (answers_count >= 15)
            question_solved_checkbox.attr('checked', 'checked');
    });
});

$("#new-question").submit(function (e) {
    e.preventDefault();

    $.post('/question/new', $(this).serialize(), function (data) {
        location.reload();
    });
});

$("#new-question-modal .category-select").change(function(){
    $.get('/category/'+$(this).val()+'/getGeoParams', function (geoParams) {
        geoParams = JSON.parse(geoParams);

        var needCities      = geoParams.cities;
        var needRegions     = geoParams.regions;
        var needCountries   = geoParams.countries;

        var city_select     = $("#new-question-modal .city-select");
        var region_select   = $("#new-question-modal .region-select");
        var country_select  = $("#new-question-modal .country-select");


        city_select.children().removeAttr('selected');
        region_select.children().removeAttr('selected');
        country_select.children().removeAttr('selected');

        city_select.children()[0].setAttribute('selected', 'selected');
        region_select.children()[0].setAttribute('selected', 'selected');
        country_select.children()[0].setAttribute('selected', 'selected');

        if (needCities) {
            city_select.removeClass('hidden');
            city_select.removeAttr('disabled');
        }
        else {
            city_select.addClass('hidden');
            city_select.attr('disabled', 'disabled');
        }

        if (needRegions) {
            region_select.removeClass('hidden');
            region_select.removeAttr('disabled');
        }
        else {
            region_select.addClass('hidden');
            region_select.val(1);
            region_select.attr('disabled', 'disabled');
        }

        if (needCountries) {
            country_select.removeClass('hidden');
            country_select.removeAttr('disabled');
        }
        else {
            country_select.addClass('hidden');
            SetRegionsSelectByCountryId(1);
            country_select.attr('disabled', 'disabled');
        }
    });
});

$("#new-question-modal .country-select").change(function() {
    SetRegionsSelectByCountryId($(this).val());
    SetCitiesSelectByRegionId(-1);
});

$("#new-question-modal .region-select").change(function() {
    SetCitiesSelectByRegionId($(this).val());
});

function SetRegionsSelectByCountryId(country_id) {
    $.get('/geo/getRegionsByCountryId/'+country_id, function(regions){
        var options = "<option selected disabled>Выберите регион</option>";

        for (var i = 0; i < regions.length; i++) {
            options += '<option value="'+regions[i].id+'">'+regions[i].name+'</option>';
        }

        $("#new-question-modal .region-select").html(options);
    });
}

function SetCitiesSelectByRegionId(region_id) {
    $.get('/geo/getCitiesByRegionId/'+region_id, function(cities){
        var options = "<option selected disabled>Выберите город</option>";

        for (var i = 0; i < cities.length; i++) {
            options += '<option value="'+cities[i].id+'">'+cities[i].name+'</option>';
        }

        $("#new-question-modal .city-select").html(options);
    });
}

$(".category-tab").click(function(){
    selectedCategoryId = $(this).attr("data-category-id");

    $.get("/category/"+selectedCategoryId+"/getContent", function (category) {
        ShowCategory(category);
    })
});

function LoadQuestionModal (questionId) {
    $.get('/question/'+questionId, function (question) {
        // Set question text
        $("#question-modal #question-text").html(question.text);

        // Set answers
        var answersHtml = "";

        for (var i = 0; i < question.answers.length; i++) {
            answersHtml += "<div>" +
                "<b>" + question.answers[i].get_owner.name + "</b>: " +
                question.answers[i].text +
                "<br />" +
                "<button data-answer-id='"+question.answers[i].id+"' onclick='GetContacts($(this));'>Получить контакты</button>"+
                "</div><hr>";
        }

        if (auth_id == question.owner)
            $("#question-modal #answers-container").html(answersHtml);
        else
            $("#question-modal #answers-container").html('');

        // Set new answer form
        var newAnswerForm = $("#question-modal #new-answer");
        var messageBlock = $("#question-modal .message");

        var isUserAnswerExists = question.answers.filter(function( obj ) {
            return obj.owner == auth_id;
        }).length;

        // Show or hide new answer form
        if (!auth_id || question.owner == auth_id || isUserAnswerExists || question.answers.length >= 15) {
            newAnswerForm.addClass('hidden');

            messageBlock.show();

            if (!auth_id)
                messageBlock.html("Вы должны быть зарегистрированы для того чтобы отвечать на вопросы");
            else if (question.answers.length >= 15)
                messageBlock.html("Вопрос закрыт, на него больше нельзя отвечать");
            else if (isUserAnswerExists)
                messageBlock.html("Вы уже ответили на этот вопрос");
            else
                messageBlock.hide();
        }
        else {
            newAnswerForm.removeClass('hidden');
            messageBlock.hide();
        }

        if (question.answers.length <= 0) {
            messageBlock.html("");//На этот вопрос еще никто не ответил.");
            messageBlock.hide();
        }

        // Set the hidden "question_id" input field
        $("#question-modal #question-id").val(question.id);
    })
}

function ShowCategory(category, doNotReplaceGeo) {
    category = JSON.parse(category);
    console.log(category);

    if (!doNotReplaceGeo) {
        var geoParams = category.geoParams;

        var needCities = geoParams.cities;
        var needRegions = geoParams.regions;
        var needCountries = geoParams.countries;

        var city_select = $("#category-content .city-select");
        var region_select = $("#category-content .region-select");
        var country_select = $("#category-content .country-select");

        city_select.children().removeAttr('selected');
        region_select.children().removeAttr('selected');
        country_select.children().removeAttr('selected');

        city_select.children()[0].setAttribute('selected', 'selected');
        region_select.children()[0].setAttribute('selected', 'selected');
        country_select.children()[0].setAttribute('selected', 'selected');

        if (needCities) {
            city_select.removeClass('hidden');
            city_select.removeAttr('disabled');
        }
        else {
            city_select.addClass('hidden');
            city_select.attr('disabled', 'disabled');
        }

        if (needRegions) {
            region_select.removeClass('hidden');
            region_select.removeAttr('disabled');
        }
        else {
            region_select.addClass('hidden');
            region_select.val(1);
            region_select.attr('disabled', 'disabled');
        }

        if (needCountries) {
            country_select.removeClass('hidden');
            country_select.removeAttr('disabled');
        }
        else {
            country_select.addClass('hidden');
            SetRegionsSelectByCountryIdCategory(1);
            country_select.attr('disabled', 'disabled');
        }
    }

    var questionsTemplate = _.template(document.getElementById('category-questions-template').innerHTML);
    var questionsResult = questionsTemplate({ category: category });

    $("#category-questions").html(questionsResult);
}

$("#category-content .country-select").change(function() {
    SetRegionsSelectByCountryIdCategory($(this).val());
    SetCitiesSelectByRegionIdCategory(-1);

    var selectedCountryId = $(this).val();

    if (selectedCountryId == "all") {
        $.get("/category/"+selectedCategoryId+"/getContent", function (category) {
            ShowCategory(category, true);
        });
    } else {
        $.get("/category/" + selectedCategoryId + "/getContent?country=" + selectedCountryId, function (category) {
            ShowCategory(category, true);
        });
    }
});

$("#category-content .region-select").change(function() {
    SetCitiesSelectByRegionIdCategory($(this).val());

    var selectedRegionId = $(this).val();

    if (selectedRegionId == "all") {
        var country_id = $("#category-content .country-select").val();
        var query_params = "";
        if (country_id != "all")
            query_params = "?country="+$("#category-content .country-select").val();
        $.get("/category/"+selectedCategoryId+"/getContent"+query_params,
            function (category) {
                ShowCategory(category, true);
            }
        );
    } else {
        $.get("/category/" + selectedCategoryId + "/getContent?region=" + selectedRegionId, function (category) {
            ShowCategory(category, true);
        });
    }
});


$("#category-content .city-select").change(function() {
    var selectedCityId = $(this).val();

    if (selectedCityId == "all") {
        $.get("/category/"+selectedCategoryId+"/getContent?region="+$("#category-content .region-select").val(),
            function (category) {
                ShowCategory(category, true);
            }
        );
    } else {
        $.get("/category/" + selectedCategoryId + "/getContent?city=" + selectedCityId, function (category) {
            ShowCategory(category, true);
        });
    }
});


function SetRegionsSelectByCountryIdCategory(country_id) {
    $.get('/geo/getRegionsByCountryId/'+country_id, function(regions){
        var options = "<option selected value='all'>Все регионы</option>";

        for (var i = 0; i < regions.length; i++) {
            options += '<option value="'+regions[i].id+'">'+regions[i].name+'</option>';
        }

        $("#category-content .region-select").html(options);
    });
}

function SetCitiesSelectByRegionIdCategory(region_id) {
    $.get('/geo/getCitiesByRegionId/'+region_id, function(cities){
        var options = "<option selected value='all'>Все города</option>";

        for (var i = 0; i < cities.length; i++) {
            options += '<option value="'+cities[i].id+'">'+cities[i].name+'</option>';
        }

        $("#category-content .city-select").html(options);
    });
}

function MoreQuestions() {
    $.get("/category/4/getContent?page=2", function (category) {
        category = JSON.parse(category);

        var questionsTemplate = _.template(document.getElementById('category-questions-template').innerHTML);
        var questionsResult = questionsTemplate({category: category});

        $("#category-questions").append(questionsResult);
    });
}

function GetContacts(initiator) {
    var answer_id = $(initiator).attr("data-answer-id");

    $.get("/answer/"+answer_id+"/getContacts", function (contacts) {
        contacts = JSON.parse(contacts);
        var haveContacts = contacts.email || contacts.phone;
        var contactsText = "";

        if (haveContacts)
            contactsText =
                (contacts.email ? ("E-mail: "+ contacts.email+(contacts.phone?"<br>":"")) : '') +
                (contacts.phone ? ("Телефон: "+ contacts.phone+"<br>") : '');
        else
            contactsText = 'Контакты не предоставлены';

        $(initiator).after(contactsText);
        $(initiator).remove();
    });
}

$(".modal").on("hidden.bs.modal", function () {
    grecaptcha.reset(new_question_recaptcha);
    grecaptcha.reset(new_answer_recaptcha);

    $("#new-question-text").val("");
    $("#answer-text").val("");
    $("#answer-email").val("");
    $("#answer-phone").val("");
});
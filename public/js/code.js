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
    $needCities = $(this).find("option[value='"+$(this).val()+"']").attr("data-need-cities");

    var city_select = $("#new-question-modal .city-select");

    if ($needCities) {
        city_select.removeClass('hidden');
        city_select.children()[0].removeAttribute('selected');
        city_select.removeAttr('disabled');
    }
    else {
        city_select.addClass('hidden');
        city_select.attr('disabled', 'disabled');
    }
});

$(".category-tab").click(function(){
    selectedCategoryId = $(this).attr("data-category-id");

    $.get("/category/"+selectedCategoryId+"/getContent", function (category) {
        ShowCategory(category);
    })
});

function CategoryCityChanged (caller){
    var selectedCityId = $(caller).val();

    if (selectedCityId == "all") {
        $.get("/category/"+selectedCategoryId+"/getContent", function (category) {
            ShowCategory(category);
        })
    }

    $.get("/category/"+selectedCategoryId+"/getContent?city="+selectedCityId, function (category) {
        ShowCategory(category);
    })
}

$(".captcha_image").click(function () {
    var randomLetter = String.fromCharCode(Math.floor(Math.random() * (122 - 97)) + 97);
    $(this).attr("src", $(this).attr("src")+randomLetter);
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

function ShowCategory(category) {
    category = JSON.parse(category);
    console.log(category);

    var citiesTemplate = _.template(document.getElementById('category-cities-template').innerHTML);
    var citiesResult = citiesTemplate({ category: category });

    var questionsTemplate = _.template(document.getElementById('category-questions-template').innerHTML);
    var questionsResult = questionsTemplate({ category: category });

    $("#category-questions").html(citiesResult+questionsResult);
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
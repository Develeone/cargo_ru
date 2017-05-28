$("#new-answer").submit(function (e) {
    e.preventDefault();

    $.post('/answer/new', $(this).serialize(), function (question_id) {
        LoadQuestionModal(question_id);

        var answers_counter = $(".question[data-question-id='"+question_id+"'] .answers-count");
        var question_solved_checkbox = $(".question[data-question-id='"+question_id+"'] .question-solved-checkbox");

        var answers_count = parseInt(answers_counter.html());
        answers_counter.html(++answers_count);

        if (answers_count >= 10)
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

$(".questions-by-city-select").change(function(){
    var selected_city_id = $(this).val();

    var parent_container = $(this).parent();

    if (selected_city_id == "all")
        $(parent_container).find(".question").show();
    else {
        $(parent_container).find(".question").hide();
        $(parent_container).find(".question[data-city-id='" + selected_city_id + "']").show();
    }

    var questions_of_date = $(parent_container).find(".questions-of-date");
    for (var i = 0; i < questions_of_date.length; i++) {
        var hidden = true;

        var questions = $(questions_of_date[i]).find(".question");

        for (var j = 0; j < questions.length; j++) {
            if ($(questions[j]).css("display") != 'none')
                hidden = false;
        }

        if (hidden)
            $(questions_of_date[i]).hide();
        else
            $(questions_of_date[i]).show();
    }
});

function LoadQuestionModal (questionId) {
    $.get('/question/'+questionId, function (question) {
        // Set question text
        $("#question-modal #question-text").html(question.text);

        // Set answers
        var answersHtml = "";
        for (var i = 0; i < question.answers.length; i++)
            answersHtml += "<li>" + question.answers[i].text + "</li>";

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
        if (!auth_id || question.owner == auth_id || isUserAnswerExists || question.answers.length >= 10) {
            newAnswerForm.addClass('hidden');

            if (!auth_id)
                messageBlock.html("Вы должны быть зарегистрированы для того чтобы отвечать на вопросы");
            else if (question.answers.length >= 10)
                messageBlock.html("Вопрос закрыт, на него больше нельзя отвечать");
            else if (isUserAnswerExists)
                messageBlock.html("Вы уже ответили на этот вопрос");
            else if (question.owner == auth_id)
                messageBlock.html("Вы не можете отвечать на свой вопрос");
        }
        else {
            newAnswerForm.removeClass('hidden');
            messageBlock.html("");
        }

        // Set the hidden "question_id" input field
        $("#question-modal #question-id").val(question.id);
    })
}
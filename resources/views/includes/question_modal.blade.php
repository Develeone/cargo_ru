<div id="question-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="question-text">
                    <!-- QUESTION TEXT -->
                </h4>
            </div>
            <div class="modal-body">
                <div id="answers-container">
                    <!-- QUESTION ANSWERS -->
                </div>

                <form id="new-answer" class="hidden">
                    <H4>Ответить на вопрос:</H4>
                    {{ csrf_field() }}
                    <input type="hidden" name="question_id" id="question-id" value="">
                    <textarea id="answer-text" name="text" placeholder="Введите ваш ответ" class="form-control top-buffer"></textarea>
                    <input type="text"   name="email"   placeholder="E-mail"    class="form-control top-buffer" id="answer-email">
                    <input type="text"   name="phone"   placeholder="Телефон"   class="form-control top-buffer" id="answer-phone">

                    <br />

                    <div id="new-answer-recaptcha"></div>

                    <input type="submit" id="submit-answer-button" value="Отправить" class="form-control btn-success top-buffer">
                </form>

                <div class="alert alert-info message top-buffer"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
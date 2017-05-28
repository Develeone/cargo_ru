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
                    {{ csrf_field() }}
                    <input type="hidden" name="question_id" id="question-id" value="">
                    <input type="text"   name="text" placeholder="Введите ваш ответ">
                    <input type="submit" id="submit-answer-button" value="Отправить">
                </form>

                <div class="message">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>
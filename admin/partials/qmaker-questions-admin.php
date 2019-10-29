<?php 
/**
 * Interfaz para agregar preguntas y sus respectivas respuestas
 * 
 */

$qmaker_quiz = new Qmaker_Quiz();
$current_quiz = $qmaker_quiz->get_quiz($_GET['idQuiz']);
$quiz_detail = $qmaker_quiz->get_quiz_detail($_GET['idQuiz']);

// print_r($quiz_detail );

// echo "Agrega preguntas!";
?>

<div class="container">
    <div class="row mt-3">
        <div class="col-10">
            <h2 class="text-center">Agregar preguntas a: <?php echo $current_quiz->nombre_quiz ?></h2>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-md-12">
            <h3 class="text-center">Preguntas (<?php echo count($quiz_detail); ?>)</h3>

            <!-- INICIO wrapper pregunta -->
            <div class="wrapper_question">
                <div id="question_1" class="border border-primary p-3">
                    <div class="form-group">
                        <label class="counter_question font-weight-bold" for="inputName">Pregunta <?php echo count($quiz_detail)+1;  ?>:</label>
                        <input type="text" class="form-control question_text" id="inputName" placeholder="Nombre del Quiz">
                        <div class="wrapper_anws">
                            <div class="form-row border border-secondary mx-0 mt-2 py-2 px-4 item_answer">
                                <div class="col-md-2 custom-checkbox d-flex align-items-center is_correct_response">
                                    <input type="checkbox" class="custom-control-input response_iscorrect" id="customCheck_1">
                                    <label class="custom-control-label ml-3" for="customCheck_1">Correcta</label>
                                </div>
                                <div class="col-md-8 text_response">
                                    <label for="inputName_1">Respuesta:</label>
                                    <input type="text" class="form-control response_text" id="inputName_1" placeholder="Nombre del Quiz">
                                </div>
                                <div class="col-md-2 d-flex align-items-center pt-2">
                                    <button type="button" class="btn btn-outline-danger delete-answer-btn">Quitar</button>
                                </div>
                            </div>
                        </div><!--END wrapper_anws-->
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" class="btn btn-info btn-sm addresponse-btn mr-2">Agregar Respuesta</button>
                    </div>
                </div> <!--END question-->

            </div>
            <!-- FIN wrapper pregunta -->
           
            <div class="form-group d-flex justify-content-end mt-3">
                <input type="hidden" class="quiz_id" value="<?php echo$current_quiz->id; ?>">
                <button type="button" class="btn btn-primary btn-lg save-question-btn">Guardar Pregunta</button>
            </div>
        </div>
    </div>
</div>
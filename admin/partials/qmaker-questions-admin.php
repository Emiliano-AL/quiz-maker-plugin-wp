<?php 
/**
 * Interfaz para agregar preguntas y sus respectivas respuestas
 * 
 */

$qmaker_quiz = new Qmaker_Quiz();
$current_quiz = $qmaker_quiz->get_quiz($_GET['idQuiz']);

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
            <h3 class="text-center">Preguntas</h3>
            <!-- <div class="form-group d-flex justify-content-end">
                <button type="button" class="btn btn-success">Agregar pregunta</button>
            </div> -->

            <!-- INICIO wrapper pregunta -->
            <div class="wrapper_question">
                <div id="question_1" class="border border-primary p-3">
                    <div class="form-group">
                        <label for="inputName">Pregunta 1:</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Nombre del Quiz">
                        <div class="wrapper_anws">
                            <div class="form-row border border-secondary mx-3 mt-2 py-2 px-4">
                                <div class="col-md-2 custom-checkbox d-flex align-items-center">
                                    <input type="checkbox" class="custom-control-input" id="customCheck_1">
                                    <label class="custom-control-label ml-3" for="customCheck_1">Correcta</label>
                                </div>
                                <div class="col-md-8">
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
                <button type="button" class="btn btn-primary btn-lg save-question-btn">Guardar Pregunta</button>
            </div>
        </div>
    </div>
</div>
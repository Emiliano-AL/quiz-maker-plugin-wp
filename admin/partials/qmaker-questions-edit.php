<?php 
/**
 * Provide a admin area view for the plugin
 *
 * Archivo principal html
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/admin/partials
 */
?>
<div class="container">
<?php 
 $qmaker_question = new Qmaker_Question();
 $questions = $qmaker_question->get_questions_by_id_quiz($_GET['idQuiz']);

 $qmaker_quiz = new Qmaker_Quiz();
 $current_quiz = $qmaker_quiz->get_quiz($_GET['idQuiz']);

 $qmaker_answer = new Qmaker_Answers();
 ?>
    <div class="row mt-3 mb-2">
        <div class="col-8">
            <h2>Editar Quiz: <?php echo $current_quiz->nombre_quiz ?></h2>
        </div>
        <div class="col-4 d-flex justify-content-end pr-0">
            <button type="button" onclick="saveChangesQuestions(<?php echo $current_quiz->id ?>)" class="btn btn-primary">Guardar cambios</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 wrapper_quiz border border-success p-3 my-2">
            <div class="form-group">
                <label class="font-weight-bold" for="inputName">Nombre del Quiz</label>
                <input type="text" class="form-control name_quiz" id="inputName" placeholder="Nombre del Quiz" value="<?php echo $current_quiz->nombre_quiz  ?>">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" for="inputdescription">Descripción general</label>
                <textarea name="inputdescription" id="inputdescription" cols="30" rows="5" class="form-control description_quiz"><?php echo $current_quiz->descripcion ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-12 wrap_main_questions px-0">
        <?php foreach($questions as $q):?>
            <!-- INICIO wrapper pregunta -->
            <div class="wrapper_question wrapp_manager_question_<?php echo $q->id ?> mb-2">
            <?php //print_r($q); ?>
                <div id="question_<?php echo $q->id; ?>" class="border border-primary px-4 py-3">
                    <div class="form-group">
                        <?php $answers = $qmaker_answer->get_answers_by_id_quesion($q->id); ?>
                        
                        <label class="counter_question font-weight-bold" for="inputName">Pregunta <?php echo $q->numero_pregunta  ?>:</label>
                        <input type="text" class="form-control question_text" id="inputName" placeholder="Nombre del Quiz" value="<?php echo $q->nombre_pregunta; ?>">
                        <input type="hidden" class="question_number" value="<?php echo $q->numero_pregunta ?>">
                        <?php $i = 1; ?>
                        <div class="wrapper_anws_<?php echo $q->id; ?>">
                            <?php foreach($answers as $ans): ?>
                            <?php $ans_id = $q->id.'_'.$ans->id ?>
                            <div class="form-row border border-secondary mx-0 mt-2 py-2 px-4 item_answer">
                                <div class="col-md-2 custom-checkbox d-flex align-items-center is_correct_response">
                                    <input type="checkbox"  <?php checked( 1, $ans->es_correcta);?>  class="custom-control-input response_iscorrect" id="customCheck_<?php echo $ans_id; ?>">
                                    <label class="custom-control-label ml-3" for="customCheck_<?php echo $ans_id; ?>">Correcta</label>
                                </div>
                                <div class="col-md-8 text_response">
                                    <label for="inputName_<?php echo $ans_id; ?>">Respuesta: <?php echo $ans->numero_respuesta; ?></label>
                                    <input type="text" class="form-control response_text" id="inputName_<?php echo $ans_id; ?>" placeholder="Nombre del Quiz" value="<?php echo $ans->nombre_respuesta; ?>">
                                </div>
                                <div class="col-md-2 d-flex align-items-center pt-2">
                                    <button type="button" class="btn btn-outline-danger delete-answer-btn">Quitar</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div><!--END wrapper_anws-->
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="button" onclick="addItemQuestion(<?php echo $q->id; ?>)" class="btn btn-info btn-sm addresponse-btn-edit mr-2">Agregar Respuesta</button>
                        <button type="button" onclick="deleteQuestion(<?php echo $q->id;?>)" class="btn btn-danger btn-sm">Quitar pregunta</button>
                    </div>
                </div> <!--END question-->
            </div>
            <!-- FIN wrapper pregunta -->
        <?php endforeach; ?>
      </div>
    </div>

    <div class="row  mt-3 mb-2">
        <div class="col-4 offset-md-8 d-flex justify-content-end pr-0">
            <button type="button" onclick="addQuestionWrap()" class="btn btn-warning mr-2">Agregar pregunta</button>
            <button type="button" onclick="saveChangesQuestions(<?php echo $current_quiz->id ?>)"  class="btn btn-primary">Guardar cambios</button>
        </div>
    </div>
</div>
<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://habitatweb.mx/
 * @since      1.0.0
 *
 * @package    Qmaker
 * @subpackage Qmaker/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
extract($args, EXTR_OVERWRITE);

if($id != ''):
    $public_quiz = new Qmaker_Public_Quizz();
    $quiz = $public_quiz->get_quiz($id);
    $questions = $public_quiz->get_questions_by_id_quiz($id);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h4><?php echo $quiz->nombre_quiz ?></h4>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                <!-- <div class="card-body"> -->
                    <h5 class="card-title text-center">Actividad 1/3</h5>
                </div>
                <?php foreach($questions as $q): ?>
                    <h4 class="text-center pb-0 mt-3" ><?php echo $q->nombre_pregunta; ?></h4>
                    <ul class="list-group list-group-flush text-center pb-4 pl-4 pr-4 question_<?php echo $q->id; ?>">
                        <?php $answers = $public_quiz->get_answers_by_id_quesion($q->id); ?>
                        <?php foreach($answers as $a):?>
                        <li class="list-group-item-anws">
                            <label class="item-option" for="answer_<?php echo $a->id; ?>">
                                <input type="radio" value="<?php echo $a->es_correcta; ?>" name="option_ans_<?php echo $q->id; ?>" id="answer_<?php echo $a->id; ?>"> 
                                <span><?php echo $a->nombre_respuesta; ?></span>
                            </label>
                        </li>
                        <?php endforeach; ?>
                        <!-- <li class="list-group-item-anws">
                            <label class="item-option" for="accessible-and-pretty">
                                <input type="radio" value="pretty"  name="quality" id="accessible-and-pretty" checked> 
                                <span>accessible and pretty</span>
                            </label>
                        </li>
                        <li class="list-group-item-anws">
                            <label class="item-option" for="accessible">
                                <input type="radio" value="accessible" name="quality" id="accessible"> 
                                <span>hola</span>
                            </label>
                        </li> -->
                    </ul>
                    <div class="card-footer">
                        <table class="w-100">
                            <tr>
                                <th> 
                                    <button type="button" onclick="prevQuestion()" class="btn btn-outline-info btn-sm">Anterior</button>
                                </th>
                                <th class="text-center"> 
                                    <button type="button" data-question="<?php echo $q->id; ?>" class="btn btn-primary btn-sm btn-check-anws">Revisar</button>
                                </th>
                                <th class="text-right"> 
                                    <button type="button" onclick="nextQuestion()" class="btn btn-outline-info btn-sm">Siguiente</button>
                                </th>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
<?php else: ?>

<h2>hiu</h2>

<?php endif; ?>
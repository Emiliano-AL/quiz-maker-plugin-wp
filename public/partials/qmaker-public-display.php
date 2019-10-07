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
            <?php 
                $ttlQuestions = count($questions);
                $qnmbr = 1;
            ?>
            <?php foreach($questions as $q): ?>
                <div class="card <?php echo $qnmbr > 1 ? 'invisible': ''?>" 
                    id="card-question_<?php echo $qnmbr; ?>" 
                    data-question="<?php echo $q->id; ?>" >
                    <div class="card-header">
                        <h5 class="card-title text-center">
                            Actividad <?php echo  $qnmbr; ?>/<?php echo $ttlQuestions; ?>
                        </h5>
                    </div>
                    <h4 class="text-center pb-0 mt-3 question_title" ><?php echo $q->nombre_pregunta; ?></h4>
                    <ul class="list-group list-group-flush text-center pb-4 pl-4 pr-4 question_wrap_<?php echo $q->id; ?>">
                        <?php $answers = $public_quiz->get_answers_by_id_quesion($q->id); ?>
                        <?php foreach($answers as $a):?>
                        <li class="list-group-item-anws question_<?php echo $q->id; ?>">
                            <label 
                                class="item-option" 
                                data-question="<?php echo $q->id; ?>" 
                                for="answer_<?php echo $a->id; ?>">
                                <input type="radio" 
                                        class="ans_item"
                                        value="<?php echo $a->es_correcta; ?>" 
                                        name="option_ans_<?php echo $q->id; ?>" 
                                        id="answer_<?php echo $a->id; ?>"> 
                                <span><?php echo $a->nombre_respuesta; ?></span>
                            </label>
                            <?php if ($a->es_correcta == 1):?>
                            <i class="img-ctrls-lessMore position-verifcation verification d-none"></i>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="card-footer">
                        <table class="w-100">
                            <tr>
                                <th class="w-33"> 
                                    <?php if($qnmbr > 1):?>
                                    <button 
                                        type="button" 
                                        id="btn-prev_<?php echo $q->id; ?>"
                                        data-question="<?php echo $q->id; ?>" 
                                        data-number-question="<?php echo $qnmbr; ?>"
                                        data-total-questions="<?php echo $ttlQuestions; ?>"
                                        class="btn btn-outline-info btn-directions btn-prev-question btn-sm">
                                            <i class="img-ctrls-lessMore arrow-left mr-2"></i>Anterior
                                    </button>
                                    <?php endif; ?>
                                </th>
                                <th class="w-33 text-center"> 
                                    <button 
                                        type="button" 
                                        id="btn-check_<?php echo $q->id; ?>"
                                        data-question="<?php echo $q->id; ?>" 
                                        class="btn btn-primary btn-sm btn-check-anws d-none">Revisar</button>
                                </th>
                                <th class="w-33 text-right"> 
                                    <?php if($ttlQuestions == $qnmbr): ?>
                                    <!-- pintar boton de ver resultados -->
                                    <button 
                                        type="button" 
                                        id="btn-show-result_<?php echo $q->id; ?>"
                                        data-question="<?php echo $q->id; ?>" 
                                        data-number-question="<?php echo $qnmbr; ?>"
                                        data-total-questions="<?php echo $ttlQuestions; ?>"
                                        class="btn btn-outline-info btn-directions btn-show-results btn-sm">
                                        Ver Resultados</i>
                                    </button>
                                    <?php else: ?>
                                    <button 
                                        type="button" 
                                        id="btn-next_<?php echo $q->id; ?>"
                                        data-question="<?php echo $q->id; ?>" 
                                        data-number-question="<?php echo $qnmbr; ?>"
                                        data-total-questions="<?php echo $ttlQuestions; ?>"
                                        class="btn btn-outline-info btn-directions btn-next-ctrl_<?php echo $qnmbr;?> btn-next-question btn-sm d-none">
                                        Siguiente<i class="img-ctrls-lessMore arrow-right ml-2"></i>
                                    </button>
                                    <?php endif; ?>
                                </th>
                            </tr>
                        </table>
                    </div>
                    <?php $qnmbr ++; ?>
                </div><!--end Card-->
            <?php endforeach; ?>
            <input type="hidden" class="correct-answers" value="0">
            <input type="hidden" class="incorrect-answers" value="0">
            <div class="card card-results invisible">
                <div class="card-body">
                    <h5 class="card-title">Resultados: </h5>
                    <p class="card-text show-results-text"> </p>
                    <div class="d-flex justify-content-center">
                        <button 
                            type="button" 
                            class="btn btn-primary btn-reset-quiz">Reiniciar Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php else: ?>

<h2>Este Quiz no tienen preguntas.</h2>

<?php endif; ?>
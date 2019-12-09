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
<div class="container p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="qmaker-title-quiz"><?php echo $quiz->nombre_quiz ?></h4>
        </div>
        <div class="col-12">
            <?php 
                $ttlQuestions = count($questions);
                $qnmbr = 1;
            ?>
            <?php foreach($questions as $q): ?>
                <div class="card <?php echo $qnmbr > 1 ? 'invisible-qm': ''?>" 
                    id="card-question_<?php echo $qnmbr; ?>" 
                    data-question="<?php echo $q->id; ?>" >
                    <div class="card-header">
                        <h5 class="card-title text-center">
                            Actividad <?php echo  $qnmbr; ?>/<?php echo $ttlQuestions; ?>
                        </h5>
                    </div>
                    <?php 
                        $options = get_option( 'qmaker_options' );
                        $activeRandom = $options[ 'qmaker_random_responses' ] == 'on' ? 1 : 0;
                        $isPreview = isset($_GET['isPreview']) ? $_GET['isPreview'] : 0;
                        if( $activeRandom == 1)
                            $randomOn = 1;
                        else
                            $randomOn = 0;
                        //En preview SIEMPRE se apaga el random
                        if(intval($isPreview) == 1)
                            $randomOn = 0;
                    ?>
                    <h4 class="text-center pb-0 mt-3 question_title" ><?php echo $q->nombre_pregunta . $isPreview; ?></h4>
                    <ul class="list-group list-group-flush text-center pb-4 pl-4 pr-4 question_wrap_<?php echo $qnmbr; ?>">
                        <?php $answers = $public_quiz->get_answers_by_id_quesion($q->id, $randomOn); ?>
                        <?php foreach($answers as $a):?>
                        <li class="list-group-item-anws li-option question_<?php echo $q->id; ?>">
                            <label 
                                class="item-option mr-qm-1 <?php echo $a->es_correcta == 1 ? 'qm-answers-correct' : ''; ?>" 
                                data-question="<?php echo $q->id; ?>" 
                                for="answer_<?php echo $a->id; ?>">
                                <input type="radio" 
                                        class="ans_item"
                                        value="<?php echo $a->es_correcta; ?>" 
                                        name="option_ans_<?php echo $q->id; ?>" 
                                        id="answer_<?php echo $a->id; ?>"> 
                                <span class="qm-option-answ"><?php echo $a->nombre_respuesta; ?></span>
                            </label>
                            <?php if ($a->es_correcta == 1):?>
                            <i class="img-ctrls-lessMore-qm position-verifcation verification-qm d-none"></i>
                            <?php else: ?>
                            <i class="img-ctrls-lessMore-qm position-verifcation wrong-qm d-none"></i>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="msg-alert_<?php echo $q->id;?> alert d-none mx-5 px-4" role="alert"></div>
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
                                            <i class="img-ctrls-lessMore-qm arrow-left-qm mr-2"></i>Anterior
                                    </button>
                                    <?php endif; ?>
                                </th>
                                <th class="w-33 text-center"> 
                                    <button 
                                        type="button" 
                                        id="btn-check_<?php echo $q->id; ?>"
                                        data-question="<?php echo $q->id; ?>" 
                                        data-last-question="<?php echo $ttlQuestions == $qnmbr ? 1 : 0; ?>" 
                                        data-total-questions="<?php echo $ttlQuestions; ?>" 
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
                                        class="btn btn-primary btn-directions btn-directions-show-results btn-show-results btn-sm d-none">
                                        Ver Resultados</i>
                                    </button>
                                    <?php else: ?>
                                    <!-- btn-outline-info -->
                                    <button 
                                        type="button" 
                                        id="btn-next_<?php echo $q->id; ?>"
                                        data-question="<?php echo $q->id; ?>" 
                                        data-number-question="<?php echo $qnmbr; ?>"
                                        data-total-questions="<?php echo $ttlQuestions; ?>" 
                                        class="btn btn-primary btn-directions btn-directions-next btn-next-ctrl_<?php echo $qnmbr;?> btn-next-question btn-sm d-none">
                                        Siguiente<i class="img-ctrls-lessMore-qm arrow-right-qm ml-2"></i>
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
            <input type="hidden" class="ispreview" value="<?php echo $isPreview ?>">
            <input type="hidden" class="random-answers" value="<?php echo $activeRandom; ?>">
            
            <div class="card card-results invisible-qm">
                <div class="card-body">
                    <h5 class="card-title">Resultados: </h5>
                    <p class="card-text show-results-text"> </p>
                    <div class="alert alert-msg-qm alert-primary d-none" role="alert">
                        ¡Excelente esfuerzo!
                    </div>
                    <div class="d-flex justify-content-center">
                        <button 
                            type="button" 
                            data-total-questions="<?php echo $ttlQuestions; ?>"
                            class="btn btn-outline-primary btn-reset-quiz">Reiniciar Quiz
                        </button>
                    </div>

                    <?php if( qmaker_get_option( 'quiz_banner_link' ) && qmaker_get_option( 'quiz_banner_image' ) ): ?>
                        <a href="<?php echo qmaker_get_option( 'quiz_banner_link' ) ?>" class="quiz-banner mt-4 d-block" target="_blank">
                            <img src="<?php echo wp_get_attachment_url( qmaker_get_option( 'quiz_banner_image' ) ) ?>" alt="" class="d-block w-100">
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php else: ?>

<h2>Este Quiz no tienen preguntas.</h2>

<?php endif; ?>
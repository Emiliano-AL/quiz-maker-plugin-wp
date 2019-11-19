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
  $qmaker_quiz = new Qmaker_Quiz();
  if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['idQuiz'])){
    //TODO: Preguntar antes de hacer el borrado
    //Elimnar el quiz
    $qmaker_quiz->delete_quiz($_GET['idQuiz']);
  ?>
  <script>
    var homeplugin = "?page=qmaker";
    location.href = homeplugin;
  </script>
  <?php
  }
  ?>
    <div class="row mt-3">
        <div class="col-10">
            <h2 class="text-center"><?php echo esc_html(get_admin_page_title()); ?></h2>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addQuizmodal">Agregar quiz</button>
        </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h2>Listado quizzes</h2>
        <form method="post">
          <?php
          $this->qmaker_quiz->prepare_items();
          $this->qmaker_quiz->display(); 
          ?>
        </form>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addQuizmodal" tabindex="-1" role="dialog" aria-labelledby="addQuizmodalLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuizmodalLbl">Agregar quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
                <label for="inputName">Nombre del quiz</label>
                <input type="text" class="form-control" id="inputName" placeholder="Nombre del Quiz" required>
            </div>
           
            <button type="button" id="create-quiz" class="btn btn-primary add-quiz">Agregar</button>
        </form>
      </div>
    </div>
  </div>
</div>
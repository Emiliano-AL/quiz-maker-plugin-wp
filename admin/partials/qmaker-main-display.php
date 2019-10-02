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
    <div class="row mt-3">
        <div class="col-10">
            <h2 class="text-center"><?php echo esc_html(get_admin_page_title()); ?></h2>
        </div>
        <div class="col-2">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addQuizmodal">Agregar Quiz</button>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addQuizmodal" tabindex="-1" role="dialog" aria-labelledby="addQuizmodalLbl" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuizmodalLbl">Agregar Quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                <label for="inputPassword4">Password</label>
                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>
            <div class="form-group">
                <label for="inputAddress2">Address 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" id="inputCity">
                </div>
                <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <select id="inputState" class="form-control">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
                </div>
                <div class="form-group col-md-2">
                <label for="inputZip">Zip</label>
                <input type="text" class="form-control" id="inputZip">
                </div>
            </div>
           
            <button type="button" id="create-quiz" class="btn btn-primary add-quiz">Agregar</button>
        </form>
      </div>
    </div>
  </div>
</div>
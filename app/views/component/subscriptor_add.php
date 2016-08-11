<?php use App\Helpers\Url; ?>
<subscriptor-add>
<div id={id} class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <form method="post" action="<?php echo Url::getBase('subscriptor/add'); ?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nuevo suscriptor</h4>
            </div>
            <div class="modal-body">
              <div class="alert-container"></div>
              <div class="form-group">
                  <label>Email</label>
                  <input class="form-control" type="email" name="email" required maxlength="100" />
                  <span data-key="email" class="form-validation-failed"></span>
              </div>
              <div class="form-group">
                  <label>Nombre</label>
                  <input class="form-control" type="text" name="name" required maxlength="50" />
                  <span data-key="name" class="form-validation-failed"></span>
              </div>
              <div class="form-group">
                  <label>Grupo</label>
                  <input class="form-control" type="text" name="relation" required maxlength="50" />
                  <span data-key="relation" class="form-validation-failed"></span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" data-ajax="true" data-reset="true">Guardar</button>
            </div>
          </div>
        </form>
    </div>
</div>
<script>
  var self = this;

  self.id = 'add-subscriptor-' + guid();

  this.on('mount', function(){
    $("#" + self.id).modal();

    $("#" + self.id).on('hidden.bs.modal', function () {
        opts.grid.refrescar();
    })
  })
</script>
</subscriptor-add>

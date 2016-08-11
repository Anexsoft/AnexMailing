<?php use App\Helpers\Url; ?>
<subscriptor-edit>
<div id={modal_id} class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?php echo Url::getBase('subscriptor/edit'); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar nuevo suscriptor</h4>
                </div>
                <div class="modal-body">
                    <div if={!ready}>Cargando componente ..</div>
                    <div if={ready}>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#edit" aria-controls="edit" role="tab" data-toggle="tab">Información</a>
                            </li>
                            <li role="presentation">
                                <a href="#audit" aria-controls="audit" role="tab" data-toggle="tab">Auditoría</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="edit">
                                <input type="hidden" name="id" value="{model.id}" />
                                <div class="alert-container"></div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="email" name="email" required maxlength="100" value="{model.email}" />
                                    <span data-key="email" class="form-validation-failed"></span>
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" type="text" name="name" required maxlength="50" value="{model.name}" />
                                    <span data-key="name" class="form-validation-failed"></span>
                                </div>
                                <div class="form-group">
                                    <label>Grupo</label>
                                    <input class="form-control" type="text" name="relation" required maxlength="50" value="{model.relation}" />
                                    <span data-key="relation" class="form-validation-failed"></span>
                                </div>
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="inactive">
                                        <option value="0">Activo</option>
                                        <option value="1">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="audit">
                                <dl>
                                  <dt>Creado</dt>
                                  <dd class="form-group">{model.added_at}</dd>
                                  <dt>Actualizado</dt>
                                  <dd class="form-group">{model.updated_at}</dd>
                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" if={ready}>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" data-ajax="true">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var self = this;

    self.modal_id = 'edit-subscriptor-' + guid();
    self.ready = false;

    this.on('mount', function() {
        $("#" + self.modal_id).modal();

        $.post(base_url('subscriptor/get'), {
            id: self.opts.id
        }, function(r) {
            self.inactive.value = r.inactive;
            r.added_at = moment(r.added_at).calendar().ucwords();
            r.updated_at = moment(r.updated_at).calendar().ucwords();
            
            self.model = r;
            self.ready = true;
            
            self.update();
        }, 'json')

        $("#" + self.modal_id).on('hidden.bs.modal', function() {
            opts.grid.refrescar();
        })
    })
</script>
</subscriptor-edit>
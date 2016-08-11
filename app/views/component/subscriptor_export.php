<?php use App\Helpers\Url; ?>
<subscriptor-export>
<div id={id} class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Exportar suscriptores</h4>
            </div>
            <div class="modal-body">
              <div if={!ready}>Cargando componente ..</div>
              <div if={ready} >
                <div class="alert-container"></div>
                <div class="form-group">
                    <label>Tipo de suscriptor</label>
                    <select name="inactive" class="form-control">
                      <option value="0">Suscriptores activos</option>
                      <option value="1">Suscriptores dados de baja</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Grupos</label>
                    <select name="relation" class="form-control">
                      <option each={groups} value="{valor}">{contenido}</option>
                    </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onclick={export}>Exportar</button>
            </div>
        </div>
    </div>
</div>
<script>
  var self = this;

  self.id = 'export-subscriptor-' + guid();
  self.ready = false;

  this.on('mount', function(){
    $("#" + self.id).modal();

    getSubscriptorType();
  })

  export(){
    var urlToExport = base_url(
        'subscriptor/export&inactive={0}&relation={1}'.format(
            self.inactive.value,
            self.relation.value
        )
    );
    
    window.open(urlToExport);
  }

  function getSubscriptorType() {
    $.post(base_url('subscriptor/groups'), function(r){
      var data = [];

      data.push({valor: 'all',contenido: 'Todos'});
      data.push({valor: '',contenido: 'Sin agrupar'});

      r.forEach(function(x){
        data.push({
          valor: x.relation,
          contenido: x.relation
        });
      });

      self.groups = data;
      self.ready = true;
      self.update();
    })
  }
</script>
</subscriptor-export>

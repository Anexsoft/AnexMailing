<?php use Carbon\Carbon,
          App\Helpers\Url; ?>

<h1 class="page-header">
    Perfil del usuario
</h1>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Información</a></li>
    <li role="presentation"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Credenciales de acceso</a></li>
    <li role="presentation"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">Información</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="profile">
        <form method="post" action="<?php echo Url::getBase('user/save'); ?>">
            <div class="alert-container"></div>
            <input type="hidden" name="id" value="<?php echo $model->id; ?>" />

            <div class="form-group">
                <label>Nickname</label>
                <input required type="text" name="nickname" class="form-control" placeholder="Ingrese su nickname" value="<?php echo $model->nickname; ?>" autocomplete="off">
                <span data-key="nickname" class="form-validation-failed"></span>
            </div>

            <div class="form-group">
                <label>Nombre</label>
                <input required type="text" name="name" class="form-control" placeholder="Ingrese su nombre" value="<?php echo $model->name; ?>" autocomplete="off">
                <span data-key="name" class="form-validation-failed"></span>
            </div>

            <div class="form-group">
                <button data-ajax="true" type="submit" class="btn btn-default">Guardar</button>
            </div>
        </form>
    </div>
    <div role="tabpanel" class="tab-pane" id="password">
        <form method="post" action="<?php echo Url::getBase('user/credentials'); ?>">
            <div class="alert-container"></div>
            <input type="hidden" name="id" value="<?php echo $model->id; ?>" />

            <div class="form-group">
                <label>Email</label>
                <input required type="email" name="email" class="form-control" placeholder="Ingrese su email" value="<?php echo $model->email; ?>" autocomplete="off">
                <span data-key="email" class="form-validation-failed"></span>
            </div>

            <div class="form-group">
                <label>Cambiar password</label>
                <input required type="password" name="password" class="form-control" placeholder="Ingrese su nuevo password" autocomplete="off">
                <span data-key="password" class="form-validation-failed"></span>
                <span class="block">Ignore este campo si no quiere actualizar su contraseña actual</span>
            </div>

            <div class="form-group">
                <button data-ajax="true" data-success="cleanCredential" type="submit" class="btn btn-default">Guardar</button>
            </div>
        </form>
    </div>
    <div role="tabpanel" class="tab-pane" id="information">
        <dl>
          <dt>Último acceso</dt>
          <dd class="form-group"><?php echo ucwords(Carbon::parse($model->last_login)->diffForHumans()); ?></dd>
          <dt>Creado</dt>
          <dd class="form-group"><?php echo ucwords(Carbon::parse($model->created_at)->diffForHumans()); ?></dd>
          <dt>Actualizado</dt>
          <dd class="form-group"><?php echo ucwords(Carbon::parse($model->updated_at)->diffForHumans()); ?></dd>
          <dt>Estado actual</dt>
          <dd class="form-group"><?php echo $model->is_active === '1' ? 'Habiltiado' : 'Inhabiltiado'; ?></dd>
        </dl>
    </div>
</div>

<script>
function cleanCredential(){
  $("input[name=password]").val('').blur();
}
</script>

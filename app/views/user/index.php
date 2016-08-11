<?php use Carbon\Carbon,
          App\Helpers\Url; ?>

<h1 class="page-header">
    Perfil del usuario
</h1>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Información</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="information">
        <dl>
          <dt>Nombre</dt>
          <dd class="form-group"><?php echo $model->name; ?></dd>
          <dt>Email</dt>
          <dd class="form-group"><?php echo $model->email; ?></dd>
          <dt>Último acceso</dt>
          <dd class="form-group"><?php echo ucwords(Carbon::parse($model->last_login)->diffForHumans()); ?></dd>
        </dl>
    </div>
</div>
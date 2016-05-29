<?php use App\Helpers\Url,
          Core\Router; ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Bienvenido al administrador</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo Url::getBase('admin/auth/signin'); ?>">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Contraseña" name="password" type="password" value="" />
                            </div>
                            <button data-ajax="true" type="submit" class="btn btn-lg btn-success btn-block">Ingresar</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
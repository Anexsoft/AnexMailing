<?php use App\Helpers\Url,
          Core\Router; ?>

<div id="login" class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1 class="page-header">
                <?php echo $config->productName; ?> <small><?php echo $config->productVersion; ?></small>
            </h1>
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Bienvenido al administrador</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo Url::getBase('auth/signin'); ?>">
                        <div class="alert-container"></div>
                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="" />
                            <span data-key="email" class="form-validation-failed"></span>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Contraseña" name="password" type="password" value="" />
                            <span data-key="password" class="form-validation-failed"></span>
                        </div>
                        <button data-ajax="true" type="submit" class="btn btn-lg btn-success btn-block">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
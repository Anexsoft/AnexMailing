<?php use App\Helpers\Url; ?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Página de ejemplo</title>

    <link href="<?php echo Url::getAsset('bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Url::getAsset('bower_components/bootstrap/dist/css/theme.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Url::getAsset('bower_components/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    
    <style>
        body{background:#fafaf7;}
    </style>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
            
                <h1 class="page-header text-center">Página de ejemplo</h1>
                
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        
                        <div class="alert alert-info text-justify">
                            Examina el <strong>código de fuente</strong> de esta página para revisar el script, se encuentra al final de la página.
                        </div>
                        
                        <div id="subscription-container">
                            <p class="text-justify">Bienvenido a nuestro sitio web, si quieres estar al tanto de nosotros no olvides suscribirte a nuestro mailing para enviarte ofertas increíbles.</p>
                            
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input id="email" type="text" class="form-control" placeholder="Ingrese su correo" />
                                </div>
                                <span id="val-email" class="label label-danger validation-message"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="name" type="text" class="form-control" placeholder="Ingrese su nombre" />
                                </div>
                                <span id="val-name" class="label label-danger validation-message" data-key="name"></span>
                            </div>
                            <button id="submit" class="btn btn-primary btn-lg btn-block">Suscribirme</button>
                            
                            <a id="verifyIfSuscribed" href="#" class="btn btn-block btn-link">
                                Click para validar si el usuario ya se ha suscrito previamente
                            </a>
                        </div>
                    </div>
                </div>

                <hr />
                
                <div id="credit" class="text-center">
                    Desarrollado por <a target="_blank" href="http://anexsoft.com">Anexsoft</a>, <?php echo date('Y'); ?>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script src="<?php echo Url::getAsset('bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo Url::getBase('frontend'); ?>"></script>
    
    <script>
        $(document).ready(function(){
            var am = new AnexMailing({
                email: 'email',
                name: 'name',
                done: function(type, r){
                    // Limpiamos cualquier mensaje de validación previo
                    $('.validation-message').html('');
                    
                    // Si el request fue éxitoso
                    if(type === 'success') {
                        subscribed();
                    }
                    
                    // Si ocurrió un error de validación
                    if(type === 'validation') {
                        if(r.errors !== null) {
                            for(var k in r.errors) {
                                $('#val-' + k).text(r.errors[k][0]);
                            }
                        }
                    }
                    
                    // Si ocurrió cualquier error no controlado
                    if(type === 'error') {
                        
                    }
                }
            });
            
            $("#submit").click(function(){
                am.send();
            })
            
            $("#verifyIfSuscribed").click(function(){
                if(am.isSuscribed()) {
                    subscribed();
                } else {
                    alert('No se ha dectado una suscripción previa ..');
                }
            })
            
            function subscribed(){
                $("#subscription-container").html('¡Gracias, lo mantendremos al tanto de nuestras novedades!')
                                            .addClass('alert alert-success');
            }
        })
    </script>
</body>
</html>

<?php use App\Helpers\Url; ?>
<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Página de ejemplo usando un Modal</title>
    <link href="<?php echo Url::getAsset('bower_components/remodal/dist/remodal.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Url::getAsset('bower_components/remodal/dist/remodal-default-theme.css'); ?>" rel="stylesheet" type="text/css" />

    <style>
        #subscription-container{text-align:justify;}
        .form-group{margin-bottom:15px;}
        .form-group input{border:1px solid #ddd;padding:10px;display:block;width:90%;}
        .form-group input:hover{border:1px solid #222;}
        .btn{border:1px solid #ddd;padding:10px;background:#eee;display:block;width:100%;}
        a.btn{border:none;background:none;text-align:center;}
        button.btn{padding:10px;font-size:16px;}
        button.btn:hover{background:#0c516c;color:#eee;border:1px solid #2b2e38;}
        .validation-failed{color:#9c0900;font-size:14px;margin-top:4px;display:block;}
    </style>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-lg-12">

                <div id="am-modal" class="remodal">
                    <div id="subscription-container">
                        <h1>Suscríbete a nuestro boletín</h1>
                        <p>Me siento en el deber de contarte más sobre mi <strong>estrategia de 60 segundos</strong>, déjame decirte como comencé a generar mejores ingresos que me han mejorado calidad de vida.</p>

                        <div class="well">
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input id="email" type="email" class="form-control" placeholder="Ingrese su correo" />
                                <span id="val-email" class="validation-failed"></span>
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input id="name" type="text" class="form-control" placeholder="Ingrese su primer nombre" />
                                <span id="val-name" class="validation-failed"></span>
                            </div>
                        </div>

                        <button id="submit" class="btn">Suscribirme</button>

                        <a id="cancelSubscription" href="#" class="btn btn-block btn-link" data-remodal-action="close" class="remodal-close">
                            Si quiere ignorar esta oportunidad haga click aquí
                        </a>
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
    <script src="<?php echo Url::getAsset('bower_components/remodal/dist/remodal.min.js'); ?>"></script>
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

            setTimeout(function(){
                var rm = $('#am-modal').remodal();
                rm.open();
            }, 20000)

            $("#submit").click(function(){
                am.send();
            })

            function subscribed(){
                $("#subscription-container").html('¡Gracias, lo mantendremos al tanto de nuestras novedades!')
                                            .addClass('alert alert-success');

                setTimeout(function(){
                    rm.close();
                }, 3000);
            }
        })
    </script>
</body>
</html>

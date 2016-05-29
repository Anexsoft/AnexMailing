<?php use App\Helpers\Url; ?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8" />
    <title>Página no encontrada - 404</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Open+Sans);
        * {margin:0;padding:0;}
        body{background:#eee;color:#444;text-align:center;font-size:14px;padding:20px;padding-top:10%;font-family:Open Sans;}
        h1{font-size:3em;color:#888;margin-bottom:10px;}
        h2{font-size:4em;color:#666;margin-bottom:10px;text-shadow:1px 1px 30px #ddd;}
        .hgroup{margin-bottom:40px;}
        p{margin-bottom:15px;font-size:1.2em;color:#666;}
        a{color:#73880A;}
        a:hover{color:#6BBA70;}
    </style>
</head>
<body>
    <div id="container">
        <div class="hgroup">
            <h1>Upss .. ¡página no encontrada!</h1>
            <h2>Error 404</h2>
        </div>
        <p>Por alguna razón parece que la página que intenta acceder no existe en nuestro servidor.</p>
        <p>Volver <a href="javascript:history.go(-1)">atrás</a> o al <a href="<?php echo Url::getBase(); ?>">Inicio</a></p>
    </div>
</body>
</html>
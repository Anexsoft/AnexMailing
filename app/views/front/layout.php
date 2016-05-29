<?php use App\Helpers\Url,
          Core\Router; ?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
    <title>My Web Site</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?php echo Url::getAsset('css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo Url::getAsset('css/bootstrap-theme.min.css'); ?>" />
    <?php $this->section('css'); ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <?php $this->render(); ?>
            </div>
        </div>
    </div>
    
    <script src="<?php echo Url::getAsset('js/jquery-2.2.4.min.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('js/bootstrap.min.js'); ?>"></script>
    
    <?php $this->section('scripts'); ?>
</body>
</html>
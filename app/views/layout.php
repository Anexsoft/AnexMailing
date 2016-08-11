<?php use App\Helpers\Url,
          Core\Router,
          Core\Auth;

$productName = Config::get()->productName . ' ' . Config::get()->productVersion;
$currentRoute = !empty($_GET['route']) ? $_GET['route'] : '';
$user = null;

if(strtolower(Router::$controller) !== 'auth' && strtolower(Router::$controller) !== 'test') {
    $user = Auth::user();
}
?>

<!DOCTYPE html>
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $productName; ?></title>

    <link href="<?php echo Url::getAsset('bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo Url::getAsset('bower_components/bootstrap/dist/css/theme.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo Url::getAsset('css/style.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Custom Fonts -->
    <link href="<?php echo Url::getAsset('bower_components/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
</head>

<body>

    <?php if(strtolower(Router::$controller) !== 'auth' && strtolower(Router::$controller) !== 'test') { ?>
    
    <nav id="menu" class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Url::getBase(''); ?>">
                    <?php echo $productName; ?>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="<?php echo strpos($currentRoute, 'home') !== false || $currentRoute === '' ? 'active' : ''; ?>">
                        <a href="<?php echo Url::getBase(''); ?>"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
                    </li>
                    <li class="<?php echo strpos($currentRoute, 'subscriptor') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo Url::getBase('subscriptor'); ?>"><i class="fa fa-envelope fa-fw"></i> Suscriptores</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?php echo strpos($currentRoute, 'user') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo Url::getBase('user'); ?>">
                            <i class="fa fa-user fa-fw"></i> <?php echo $user->nickname; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Url::getBase('auth/logout'); ?>">
                            <i class="fa fa-sign-out fa-fw"></i> Desconectarse
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <?php echo $this->render(); ?>

                <div id="credit">
                    Desarrollado por <a target="_blank" href="http://anexsoft.com">Anexsoft</a>, <?php echo date('Y'); ?>
                    <span><?php echo $productName; ?></span>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php } else { ?>
        <?php echo $this->render(); ?>
    <?php } ?>

    <script src="<?php echo Url::getAsset('bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('bower_components/riot/riot.min.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('bower_components/riot/riot+compiler.min.js'); ?>"></script>

    <!-- Moment JS -->
    <script src="<?php echo Url::getAsset('bower_components/moment/min/moment.min.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('bower_components/moment/locale/es.js'); ?>"></script>
    
    <!-- Hightcharts -->
    <script src="<?php echo Url::getAsset('bower_components/highcharts/highcharts.js'); ?>"></script>
    
    <!-- App Logic -->
    <script src="<?php echo Url::getAsset('js/ini.js'); ?>"></script>
    <script src="<?php echo Url::getAsset('js/jquery.form.js'); ?>"></script>
    
    <!-- AnexGRID -->
    <script src="<?php echo Url::getAsset('js/jquery.anexgrid.min.js'); ?>"></script>

    <?php echo $this->section('scripts'); ?>

    <script>function base_url(url) { return '<?php echo _BASE_HTTP_; ?>' + url; } function redirect(href) { window.location.href = (href.substring(0, 4) != 'http') ? '<?php echo _BASE_HTTP_; ?>' + href : href; }</script>
    <script>
      var trustedDomains = <?php print_r(json_encode(Config::get()->trustedDomain)); ?>;
    </script>
</body>

</html>

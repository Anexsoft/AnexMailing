<?php use App\Helpers\Url,
          Core\Router; ?>

<div id="test" class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="page-header">Requerimientos necesarios</h1>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td colspan="2">
Desactive el <b>TEST</b> en un ambiente de producción para evitar exponer la seguridad de su sistema a usuarios ajenos. Este apartado se dejará de visualizar automáticamente si su entorno de trabajo es <b>PROD</b>.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>Entorno de trabajo</b>
                        </td>
                        <td class="text-right">
                            <?php echo $config->environment; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>PHP Version 5.5+</b>
                        </td>
                        <td class="text-right">
                            <?php echo (int)str_replace('.', '', phpversion()) > 5500 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>PDO</b></td>
                        <td class="text-right">
                            <?php echo class_exists('PDO') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Apache Mod Rewrite</b></td>
                        <td class="text-right">
                            <?php echo in_array('mod_rewrite', apache_get_modules()) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Limite de memoria actual</b>: <?php echo ini_get('memory_limit'); ?></td>
                        <td class="text-right">
                            <?php echo ini_get('memory_limit') == -1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-question"></i>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>Nota</b>: se recomiendan trabajar con un limite de memoria alto o igual (-1) ya que, cuando se tiene una lista de suscriptores grandes esto evita que el servidor colapse al momento de generar el archivo de exportación. <em>Actualmente se han hecho pruebas con 200 mil suscriptores</em>.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
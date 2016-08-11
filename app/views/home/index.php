<?php use App\Helpers\Url; ?>
<h1 class="page-header">Inicio</h1>

<landing></landing>
<landing-chart></landing-chart>

<?php $this->setSection('scripts', function(){ ?>
<script src="<?php echo Url::getBase('component/&c=landing'); ?>" type="riot/tag"></script>
<script src="<?php echo Url::getBase('component/&c=landing_chart'); ?>" type="riot/tag"></script>
<script>
    $(document).ready(function(){
        riot.mount('landing');
        riot.mount('landing-chart');
    })
</script>
<?php }) ?>
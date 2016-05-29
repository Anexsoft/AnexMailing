<h1 class="jumbotron">Home</h1>
<p>¡Bienvenidos al landing page!</p>

<?php $this->setSection('scripts', function() { ?> 
<script>
    $(document).ready(function(){
        console.log('Hello world');
    })
</script>
<?php }); ?>
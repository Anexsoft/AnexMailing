<?php use App\Helpers\Url; ?>
<landing>
    <div class="row">
        <div class="col-sm-4">
            <div class="well text-center landing-chart">
                <span class="legend">Suscritos hoy</span>
                <div class="clear"></div>
                <span class="badge">{model.today.format()}</span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="well text-center landing-chart">
                <span class="legend">Posiblemente falsos</span>
                <div class="clear"></div>
                <span class="badge">{model.fake.format()}</span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="well text-center landing-chart">
                <span class="legend">Dados de baja</span>
                <div class="clear"></div>
                <span class="badge">{model.unsubscribe.format()}</span>
            </div>
        </div>
    </div>
    <script>
        var self = this;

        this.on('mount', function() {
            $.post(base_url('home/landing'), function(r) {
                r.today = parseInt(r.today);
                r.fake = parseInt(r.fake);
                r.unsubscribe = parseInt(r.unsubscribe);
                
                self.model = r;
                self.update();
            }, 'json')
        })
    </script>
</landing>
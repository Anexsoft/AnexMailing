<?php use App\Helpers\Url; ?>
<landing-chart>
<div id="chart" class="well"></div>
<script>
    var self = this;

    this.on('mount', function(r) {
        $.post(base_url('home/chart'), function(r) {
            var data = [];

            for(var y in r) {
                var fila = {
                    name: y,
                    data: []
                };

                for(var i = 1; i <= 12; i++){
                    fila.data.push(0.00);
                }

                r[y].forEach(function(x){
                    fila.data[x.month - 1] = parseFloat(x.total);
                });

                data.push(fila);
            }

            $('#chart').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Suscriptores por mes'
                },
                xAxis: {
                    categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre']
                },
                yAxis: {
                    title: {
                        text: 'Suscriptores'
                    }
                },
                plotOptions: {
                    column: {
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || '#222',
                            style: {
                                textShadow: '0 0 3px #ddd'
                            },
                            format: '{point.y}'
                        }
                    }
                },
                series: data
            });
        }, 'json');
    })
</script>
</landing-chart>
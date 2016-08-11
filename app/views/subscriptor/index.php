<?php use App\Helpers\Url; ?>
    <h1 class="page-header">
    <div class="dropdown pull-right">
        <button id="dLabel" class="btn btn-primary" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-wrench"></i> Acciones a realizar
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a id="add-subscriptor" href="#">Agregar nuevo suscriptor</a></li>
            <li><a id="remove-subscriptor" href="#">Dar de baja a suscriptores</a></li>
            <li><a id="export-subscriptor" href="#">Exportar suscriptores</a></li>
        </ul>
    </div>
    Suscriptores
</h1>

<div id="list"></div>
<subscriptor-add></subscriptor-add>
<subscriptor-edit></subscriptor-edit>
<subscriptor-export></subscriptor-export>

<?php $this->setSection('scripts', function(){ ?>
<script src="<?php echo Url::getBase('component/&c=subscriptor_add'); ?>" type="riot/tag"></script>
<script src="<?php echo Url::getBase('component/&c=subscriptor_export'); ?>" type="riot/tag"></script>
<script src="<?php echo Url::getBase('component/&c=subscriptor_edit'); ?>" type="riot/tag"></script>
<script>
    $(document).ready(function() {
        $("#add-subscriptor").click(function() {
            riot.mount('subscriptor-add', {
                grid: grid
            });

            return false;
        })

        $("#export-subscriptor").click(function() {
            riot.mount('subscriptor-export', {
                grid: grid
            });

            return false;
        })

        $("#remove-subscriptor").click(function() {
            var ids = [];

            grid.tabla().find('tbody .cbk-id:checked').each(function() {
                ids.push($(this).val());
            })

            unsubscribe(grid, ids);
        })

        $("#list").on('click', '.btn-unsubscribe', function() {
            unsubscribe(grid, [$(this).val()]);
        })
        
        $("#list").on('click', '.btn-edit', function() {
            riot.mount('subscriptor-edit', {
                id: $(this).val(),
                grid: grid
            })
        })

        var grid = subscriptorGrid();
    })

    function unsubscribe(grid, ids) {
        ids || [];

        if (ids.length === 0) {
            alert('Debe seleccionar por lo menos un suscriptor para dar de baja');
        } else {
            if (confirm('¿Está seguro de realizar esta acción?')) {
                $.post(base_url('subscriptor/unsubscribe'), {
                    ids: ids
                }, function(r) {
                    if (!r.response) alert('Ocurrio un error inesperado');
                    else grid.refrescar();
                }, 'json');
            }
        }

        return false;
    }

    function subscriptorGrid() {
        function getEmailFilter() {
            var data = [];

            data.push({
                valor: '',
                contenido: 'Todos'
            });

            trustedDomains.forEach(function(x) {
                data.push({
                    valor: x,
                    contenido: x.ucwords()
                });
            });

            data.push({
                valor: 'falsos',
                contenido: 'Posiblemente falsos'
            });
            data.push({
                valor: 'Eliminados',
                contenido: 'Dados de baja'
            });

            return data;
        }

        function getGroupFilter(callback) {
            $.post(base_url('subscriptor/groups'), function(r) {
                var data = [];
                data.push({
                    valor: '',
                    contenido: 'Todos'
                });
                data.push({
                    valor: 'no-group',
                    contenido: 'Sin agrupar'
                });

                r.forEach(function(x) {
                    data.push({
                        valor: x.relation,
                        contenido: x.relation
                    });
                });

                callback(data);
            })
        }

        var grid = $("#list").anexGrid({
            class: 'table-striped table-bordered table-hover table-condensed',
            columnas: [{
                leyenda: '',
                style: 'width:40px'
            }, {
                leyenda: 'Correo',
                columna: 'email',
                ordenable: true,
                style: 'width:260px',
                filtro: function() {
                    return anexGrid_select({
                        data: getEmailFilter()
                    });
                }
            }, {
                leyenda: 'Nombre',
                columna: 'name',
                ordenable: true,
                filtro: true
            }, {
                leyenda: 'Grupos',
                columna: 'relation',
                ordenable: true,
                filtro: true,
                style: 'width:200px',
                filtro: function() {
                    var select = anexGrid_select({
                        data: []
                    });

                    getGroupFilter(function(data) {
                        data.forEach(function(x) {
                            $(select).append('<option value="{0}">{1}</option>'.format(x.valor, x.contenido));
                        })
                    });

                    return select;
                }
            }, {
                leyenda: 'Registrado',
                columna: 'added_at',
                ordenable: true,
                style: 'width:260px;'
            }, {
                style: 'width:40px;'
            }, {
                style: 'width:40px;'
            }, ],
            modelo: [{
                propiedad: 'id',
                class: 'text-center',
                formato: function(tr, obj, valor) {
                    if (obj.inactive == 1) return '';
                    
                    return '<input type="checkbox" value="{0}" class="cbk-id" />'.format(valor);
                }
            }, {
                propiedad: 'email',
                formato(tr, obj, value) {
                    return '<a href="mailto:{0}">{1}</a>'.format(obj.email, obj.email);
                }
            }, {
                propiedad: 'name'
            }, {
                propiedad: 'relation'
            }, {
                propiedad: 'added_at',
                class: 'text-right',
                formato: function(tr, obj, valor) {
                    return moment(valor).calendar().ucwords();
                }
            }, {
                formato: function(tr, obj, valor) {
                    return anexGrid_boton({
                        class: 'btn-edit btn-success btn-xs btn-block',
                        value: obj.id,
                        contenido: '<i class="fa fa-edit"></i>'
                    })
                }
            }, {
                formato: function(tr, obj, valor) {
                    if (obj.inactive == 1) return '';

                    return anexGrid_boton({
                        class: 'btn-unsubscribe btn-danger btn-xs btn-block',
                        value: obj.id,
                        contenido: '<i class="fa fa-trash"></i>'
                    })
                }
            }, ],
            url: 'subscriptor/getAll',
            limite: [20, 60, 100],
            columna: 'id',
            paginable: true,
            filtrable: true,
            columna_orden: 'DESC'
        });

        return grid;
    }
</script>
<?php }) ?>
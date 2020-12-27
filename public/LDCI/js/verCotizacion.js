var tblCotizaciones = null;


    $(document).ready(function () {

        showLoad(true);
        listarCotizaciones();

    });

    /** Funcion que lista las cotizaciones hechas */
    function listarCotizaciones() {

        var _token= $('input[name=_token]').val();

        tblCotizaciones = setDataTable("#tblCotizaciones", {
            ajax: {
                type: 'POST',
                url: '/cotizaciones/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs:[
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        $estado =json[5];
                        if ($estado==1)
                            return '<span class="label info">Nueva</span>';
                        else
                            return '<span class="label info">Revisada</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i title="Asignar vendedor" class=" btn btn-info fa fa-user" onclick="">Asignar</i>'+
                                     '<i title="Imprimir" class=" btn btn-success fa  fa-file-pdf-o" onclick="">PDF</i>'
                }
            ]
        });

        /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
        $('#tblCotizaciones').DataTable().on("draw", function(){
            showLoad(false);
        })

    }

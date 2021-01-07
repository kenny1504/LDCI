var tblCotizaciones = null;

$(document).ready(function () {

    var _token= $('input[name=_token]').val();
    showLoad(true);
    /** recupera tipos de transporte*/
    $.ajax({
        type: 'POST',
        url: '/transporte/getAll', //llamada a la ruta
        data: {
            _token:_token
        },
        success: function (data) {

            $('#cmb_transporte').empty();

            var datos = '<option selected disabled value ="">Seleccione</option>';
            data.forEach(element => {
                datos += '<option  value="' + element.id_tipo_transporte + '">' + element.nombre + '</option>';
            });

            $('#cmb_transporte').append(datos);
            showLoad(false);
        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }

    });

});

    /** Funcion que lista las cotizaciones hechas */
    function listarCotizaciones() {

        /** Limpia datatable para evitar error " Cannot reinitialise DataTable"  */
        table = $('#tblCotizaciones').DataTable().destroy();
        var _token= $('input[name=_token]').val();

        tblCotizaciones = setDataTable("#tblCotizaciones", {
            ajax: {
                type: 'POST',
                url: '/factura/cotizaciones', //llamada a la ruta
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
                        if ($estado==4)
                            return '<span class="label primary">Tramite</span>';
                        if ($estado==5)
                            return '<span class="label default">Impresa</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<button class="btn btn-info" title="Selecciona el registro" onclick="selectCotizacion(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
                }
            ]
        });

    }

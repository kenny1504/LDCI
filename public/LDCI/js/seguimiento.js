var tblCotizaciones = null;
var id_cotizacion=null;


$(document).ready(function () {

    showLoad(true);
    var _token= $('input[name=_token]').val();

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
        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }

    });

    /** recupera tipos de mercancias*/
    $.ajax({
        type: 'POST',
        url: '/mercancia/getAll', //llamada a la ruta
        data: {
            _token:_token
        },
        success: function (data) {

            $('#cmb_tipo_mercancia').empty();

            var datos = '<option selected disabled value ="">Seleccione</option>';
            data.forEach(element => {
                datos += '<option  value="' + element.id_tipo_mercancia + '">' + element.nombre + '</option>';
            });

            $('#cmb_tipo_mercancia').append(datos);
            showLoad(false);
        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }

    });

    /** recupera modo transporte*/
    $.ajax({
        type: 'POST',
        url: '/modoTransporte/getAll', //llamada a la ruta
        data: {
            _token:_token
        },
        success: function (data) {

            $('#cmb_modo_transporte').empty();

            var datos = '<option selected disabled value ="">Seleccione</option>';
            data.forEach(element => {
                datos += '<option  value="' + element.id_tipo_modo_transporte + '">' + element.nombre + '</option>';
            });

            $('#cmb_modo_transporte').append(datos);
        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }

    });

    /** recupera servicios*/
    $.ajax({
        type: 'POST',
        url: '/servicios/getAll', //llamada a la ruta
        data: {
            _token:_token
        },
        success: function (data) {

            $('#cmb_servicio').empty();

            var datos = '<option selected disabled value ="">Seleccione</option>';
            data.forEach(element => {
                datos += '<option  value="' + element.id_producto + '">' + element.nombre + '</option>';
            });

            $('#cmb_servicio').append(datos);
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
                url: '/cotizaciones/getAll', //llamada a la ruta
                data: {
                    _token:_token,
                    estado:0
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
                        if ($estado==-1)
                            return '<span class="label danger">Rechazada</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<button class="btn btn-info" onclick="selectCliente(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
                }
            ]
        });

    }

    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFilaC").on("click", "#btnAdicionarFilaC", function () {

        $("#tblDetalleCarga tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleCarga tbody").find("input, select,textarea,label,div,span").val("");

    });

    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFilaS").on("click", "#btnAdicionarFilaS", function () {

        $("#tblDetalleServicios tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleServicios tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleCarga").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblDetalleCarga tr").length;
        if (numeroFilas > 2) {
            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleServicios").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblDetalleServicios tr").length;
        if (numeroFilas > 2) {
            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

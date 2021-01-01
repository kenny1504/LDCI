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
                    defaultContent: '<button class="btn btn-info" onclick="selectCotizacion(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
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

    /** funcion para cargar datos de cotizacion */
    function selectCotizacion(datos)
    {

        showLoad(true);
        limpiartablas()
        var _token= $('input[name=_token]').val();
        var dt = tblCotizaciones.row($(datos).parents('tr')).data();
        id_cotizacion=dt[0];

        /** Recupera encabezado*/
        $.ajax({
            type: 'POST',
            url: '/getEncabezado/cotizacion', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (data) {

                $('#cmb_estado').val(data[0].estado);

                if(data[0].estado==-1)
                {
                    $("#tblDetalleServicios ").find("input,button,textarea,select").attr("disabled", "disabled");
                    $("#tblDetalleCarga ").find("input,button,textarea,select").attr("disabled", "disabled");
                    $("#btnGuardar ").attr("disabled", "disabled");
                }
                else
                {
                    $("#tblDetalleServicios ").find("input,button,textarea,select").removeAttr("disabled", "disabled");
                    $("#tblDetalleCarga ").find("input,button,textarea,select").removeAttr("disabled", "disabled");
                    $("#btnGuardar ").removeAttr("disabled", "disabled");
                }

                $('#id_cotizacion').val(id_cotizacion);
                $('#txt_usuario').val(data[0].grabacion);
                $('#txt_vendedor').val(data[0].vendedor);
                $('#txt_fecha').val(data[0].fecha);
                $('#txt_destino').val(data[0].destino);
                $('#txt_origen').val(data[0].origen);
                $('#cmb_transporte').val(data[0].id_tipo_transporte);
                $('#txt_nota_adicional').val(data[0].nota);

            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** Recupera Detalle de carga*/
        $.ajax({
            type: 'POST',
            url: '/getDetalleCarga/cotizacion', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (response) {
                response.forEach(cargarDetalleCarga);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** Recupera Detalle servicio*/
        $.ajax({
            type: 'POST',
            url: '/getDetalleServicio/cotizacion', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (response) {
                response.forEach(cargarDetalleServicio);
                showLoad(false);
            },
            error: function (err) {
                showLoad(false);
                alertError(err.responseText);
            }

        });

    }

    function cargarDetalleCarga(item, index) {

        if (0 == index) {


            $("#txtCantidad").val(item['cantidad']);
            var estado =   document.getElementById('ckEstado');
            /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
            if (item['nuevo']==true)
            {
                if (estado.checked == false)
                    $('#ckEstado').click();
            }
            else
            {
                if (estado.checked == true)
                    $('#ckEstado').click();
            }


            $("#cmb_tipo_mercancia").val(item['id_tipo_mercancia']);
            $("#cmb_modo_transporte").val(item['id_tipo_modo_transporte']);
            $("#txt_observacion").val(item['descripcion']);


        } else {
            adicionarFilaCarga();
            $("#tblDetalleCarga tbody tr:eq(" + index + ")").find("input,select,textarea").each(function () {

                if ($(this).attr("id") == "txtCantidad") {
                    $(this).val(item['cantidad']);
                }
                if ($(this).attr("id") == "ckEstado") {

                    /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
                    if (item['nuevo']==true)
                    {
                            $(this).click();
                    }

                }
                if ($(this).attr("id") == "cmb_tipo_mercancia") {
                    $(this).val(item['id_tipo_mercancia']);
                }
                if ($(this).attr("id") == "cmb_modo_transporte") {
                    $(this).val(item['id_tipo_modo_transporte']);
                }
                if ($(this).attr("id") == "txt_observacion") {
                    $(this).val(item['descripcion']);
                }

            });
        }
    }

    /**Metodo para añadir fila a tabla Detalle Carga */
    function adicionarFilaCarga() {
        $("#tblDetalleCarga tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleCarga tbody").find("input, select,textarea,label,div,span").val("");
    }

    function cargarDetalleServicio(item, index) {

        if (0 == index) {

            $("#cmb_servicio").val(item['id_producto']);

        } else {
            adicionarFilaServicio();
            $("#tblDetalleServicios tbody tr:eq(" + index + ")").find("select").each(function () {

                if ($(this).attr("id") == "cmb_servicio") {
                    $(this).val(item['id_producto']);
                }

            });
        }
    }

    /**Metodo para añadir fila a tabla Detalle servicio*/
    function adicionarFilaServicio() {
        $("#tblDetalleServicios tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleServicios tbody").find("input, select,textarea").val("");
    }

    function limpiartablas()
    {
        $("#txtCantidad,#cmb_tipo_mercancia,#cmb_modo_transporte,#txt_observacion,#cmb_servicio").val("");
        /** Elimina todas las filas de tabla dinamica menos la primera */
        $('#tblDetalleServicios tr').closest('.otrasFilas').remove();
        $('#tblDetalleCarga tr').closest('.otrasFilas').remove();

    }

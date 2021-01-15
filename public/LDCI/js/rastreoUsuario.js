    $(document).ready(function () {

        showLoad(true);
        /** Detiene , para mostrar alertSucess  */
        setTimeout(function () {
            $(document).keydown();
            showLoad(false);
        }, 200);

        if($('#id_flete').val()=='')
        {
            $('.ocular').attr("hidden",true);
        }
    });

    //Funcion para listar cotizaciones estado tramite
    function listarCotizaciones()
    {
        var _token= $('input[name=_token]').val();
        $("#tblCotizaciones").DataTable().destroy();

        tblCotizaciones = setDataTable("#tblCotizaciones", {
            ajax: {
                type: 'POST',
                url: '/rastreo/getAllCotizaciones', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [{
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info" title="Seleccione Cotizacion" onclick="selectCotizacion(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }]
        });
    }

    //** Funcion para seleccionar y mostrar detalle de seguimiento */
    function selectCotizacion(datos)
    {
        showLoad(true);
        limpiartablas()
        var _token= $('input[name=_token]').val();
        var c = tblCotizaciones.row($(datos).parents('tr')).data();
        id_flete=c[0];
        $('#id_flete').val(id_flete);
        $('#txt_cliente').val(c[1]);
        $('#txt_transporte').val(c[2]);
        $('#txt_destino').val(c[3]);
        $('#txt_origen').val(c[4]);
        showLoad(false);
        if($('#id_flete').val()!='')
        {
            $('.ocular').removeAttr('hidden');
            $('#btnGuardarRastreo').removeAttr('disabled');
        }

        /** Recuperar fecha en formato para asignarla en input fecha */
        $.ajax({
            type: 'POST',
            url: '/getFecha/rastreo', //llamada a la ruta
            data: {
                _token:_token,
                id_flete:id_flete,
            },
            success: function (response) {
                $('#fecha_llegada').val(response[0].fecha);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });

        /** Recupera informacion de rastreo*/
        $.ajax({
            type: 'POST',
            url: '/getDetalle/rastreo', //llamada a la ruta
            data: {
                _token:_token,
                id_flete:id_flete,
            },
            success: function (response) {
                    response.forEach(cargarDetalleRastreo);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });

        /** Recupera todas las imagenes de un rastreo*/
        $.ajax({
            type: 'POST',
            url: '/rastreo/getRastreoImagenes', //llamada a la ruta
            data: {
                _token:$('input[name=_token]').val(),
                id_flete:id_flete
            },
            success: function (data) {
                var html='';
                data.forEach(element =>{
                    html+=
                            "<div class=\"col-md-7 ventanas\"> <div class=\"box box-success\"> <div class=\"box-body\"> <div  class=\"col-md-12\"> <img class=\"zoom_mouse\" style='width: 100% !important' src="+element.url+"/"+element.imagen+" data-zoom-image="+element.url+"/"+element.imagen+"> </div> </div> </div> </div> <br>"

                        });
                showLoad(false);
                $('#imagenes').append(html);
                $(".zoom_mouse").elevateZoom({scrollZoom : true,zoomWindowPosition: 2});
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });
    }

    /** Funcion para cargar el detalle de rastreo */
    function cargarDetalleRastreo(item, index)
    {
        if (0 == index) {
            $("#id_detalle").val(item['id_detalle_seguimiento']);
            $("#fecha_evento").val(item['fecha_evento']);
            $("#txt_evento").val(item['evento']);
            $("#txt_descripcion_evento").val(item['descripcion']);

        } else {
            adicionarFila();
            $("#tblRastreo tbody tr:eq(" + index + ")").find("input,select,textarea").each(function () {

                if ($(this).attr("id") == "id_detalle") {
                    $(this).val(item['id_detalle_seguimiento']);
                }
                if ($(this).attr("id") == "fecha_evento") {
                    $(this).val(item['fecha_evento']);
                }
                if ($(this).attr("id") == "txt_evento") {
                    $(this).val(item['evento']);
                }
                if ($(this).attr("id") == "txt_descripcion_evento") {
                    $(this).val(item['descripcion']);
                }
            });
        }
    }

    //funcion para agregar una fila al mostrar el detalle de rastreo
    function adicionarFila()
    {
        $("#tblRastreo tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblRastreo tbody").find("input, select,textarea,label,div,span").val("");
    }

    /** Funcion para limpiar tablas */
    function limpiartablas()
    {
        /** Limpia todos los inputs*/
        $('input[type="text"]').val('');
        /** Elimina todas las filas de tabla dinamica menos la primera */
        $('#tblRastreo tr').closest('.otrasFilas').remove();
        $('#imagenes').closest('.ventana').remove();
    }

var img=null;
    $(document).ready(function () {

        showLoad(true);
        /** Detiene , para mostrar alertSucess  */
        setTimeout(function () {
            $(document).keydown();
            showLoad(false);
        }, 200);

        if($('#id_flete').val()=='')
        {
            $('#btnGuardarRastreo').attr('disabled', true);
            $('.ocular').attr("hidden",true);
        }

        /** Configuraciones para subir imagen */
        /** Funcion que permite actualizar o agregar un nuevo registro */
        Dropzone.discover(
            Dropzone.options.imageUpload = {
                autoProcessQueue: false,//Para evitar que guarde en el servidor
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5, //archivos permitidos
                addRemoveLinks: true, //Botton eliminar
                acceptedFiles:'.jpeg,.jpg,.png,.gif',
                init: function() {

                var myDropzone = this;

                document.getElementById('btnGuardarRastreo').addEventListener("click", function(e) {

                    /** Se recuperan datos de tabla detalle de rastreo para validar*/
                    var TABLA = $("#tblRastreo tbody > tr");
                    var estado=true;
                        //obtener detalle de rastreo
                        TABLA.each(function (e) {
                            let Fecha = $(this).find("input[id*='fecha_evento']").val();
                            let Evento = $(this).find("select[id*='txt_evento']").val();
                            let Descripcion = $(this).find("textarea[id*='txt_descripcion_evento']").val();

                            if (Fecha !== "" && Evento != "" && Evento!=null && Descripcion !== "") {
                                estado=true;
                            }
                            else
                                estado=false;
                            });

                    if (estado==true && myDropzone.files.length!=0)
                    {
                        alertConfirm("¿Está seguro que desea guardar?", function (ev) {
                            showLoad(true);
                            e.preventDefault();
                            e.stopPropagation();
                            myDropzone.processQueue();
                        });
                    }
                    else if(estado==true && myDropzone.files.length==0)
                    {
                        guardarrastreo();
                    }
                    else
                        alertError("Favor completar campos y/o añadir imagenes");
                    });

                    /** Recupera respuesta si es exitosa*/
                    this.on("successmultiple", function(files, response) {
                        showLoad(false);
                        alertSuccess(response.mensaje);
                        this.removeAllFiles();//elimina imagenes en dropzone
                        $('#btnlimpiar').click();
                    });

                    /** Recupera respuesta si es fallida*/
                    this.on("errormultiple", function(files, response) {
                        alertError(response.mensaje);
                        showLoad(false);
                    });

                    /**Valida que no sea mas de 5 archivos */
                    this.on("maxfilesexceeded", function(file){
                        alertError("Excedio el limite de imagenes, imagenes permitidas 5")
                    });

                },
                maxfilesexceeded: function (files) {
                    this.removeFile(files); //Remueve el archivo (Imagen) si execede el limite permitido
                },
            }
        ); //Rastrea el documento
    });

   /** Funcion para agregar fila */
    $(document).off("click", "#btnAgregarFila").on("click", "#btnAgregarFila", function () {

        $("#tblRastreo tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblRastreo tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblRastreo").on('click', '.eliminarFila', function () {

        let fila = $(this).closest('tr');
        let id_detalle= $(fila).find("#id_detalle").val();
        var numeroFilas = $("#tblRastreo tr").length;
        if(id_detalle!="" && numeroFilas > 2){
            var _token = $('input[name=_token]').val();
            alertConfirm("¿Está seguro que desea eliminar el evento?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/rastreoEvento/anular', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_detalle:id_detalle
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            fila.remove();
                            $('#tblRastreo').find("tbody tr").eq(0).addClass("fila-base").removeClass("otrasFilas");
                            alertSuccess(data.mensaje);
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            });

        } else if (id_detalle == "" && numeroFilas > 2) {
            $(this).closest('tr').remove();
        } else if(id_detalle != "" && numeroFilas == 2)
        {
            var _token = $('input[name=_token]').val();
            alertConfirm("¿Está seguro que desea eliminar el evento?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/rastreoEvento/anular', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_detalle:id_detalle
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            $("#id_detalle,#fecha_evento,#txt_evento,#txt_descripcion_evento").val("");
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            });
        }else {
            alertError("¡Esta fila no puede ser eliminada!");
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
        limpiartablas();
        var _token= $('input[name=_token]').val();
        var c = tblCotizaciones.row($(datos).parents('tr')).data();
        id_cotizacion=c[0];
        $('#id_cotizacion').val(id_cotizacion);
        $('#txt_cliente').val(c[1]);
        $('#txt_transporte').val(c[2]);
        $('#txt_destino').val(c[3]);
        $('#txt_origen').val(c[4]);

        if($('#id_cotizacion').val()!='')
        {
            $('.ocular').removeAttr('hidden');
            $('#btnGuardarRastreo').removeAttr('disabled');
        }

        /** Recuperar fecha e id_flete en formato para asignarla en input fecha */
        $.ajax({
            type: 'POST',
            url: '/getInfo/rastreo', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (response) {
                $('#fecha_llegada').val(response[0].fecha);
                $('#id_flete').val(response[0].id_flete);
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
                id_cotizacion:id_cotizacion,
            },
            success: function (response) {
                    response.forEach(cargarDetalleRastreo);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });


        /** Carga imagenes del producto seleccionado */
        $.ajax({
            type: 'POST',
            url: '/rastreo/fotos', //llamada a la ruta
            data: {
                _token:$('input[name=_token]').val(),
                id_cotizacion:id_cotizacion
            },
            success: function (data) {

                $('.dz-preview').remove()
                data.forEach(element => {

                    /**Ruta donde se gurda imagen */
                    var file_image = element.url+'/'+element.nombre;
                    /**Archivo (Imagen) */
                    var mockFile = { name: element.nombre, size: 12345 };

                    var myDropzone = Dropzone.forElement(".dropzone");
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, file_image);

                     /** Redimenciona Imagen */
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});

                    /** Evento para Eliminar  imagen del servidor y base de datos */
                    myDropzone.on("removedfile", function(file){

                        /** Nombre de la imagen */
                        var archivo=file.name

                        /** Verifica para evitar que se hagan muchas peticiones de una misma imagen*/
                        if(img!=archivo)
                            estado=true

                            img=archivo
                            if(estado==true)
                            {
                                $.ajax({
                                    type: 'POST',
                                    url: '/rastreo/eliminarImagen', //llamada a la ruta
                                    data: {
                                        _token:$('input[name=_token]').val(),
                                        imagen:archivo
                                    },
                                    success: function (data) {
                                        showLoad(false);
                                        if(data.error)
                                            alertError(data.mensaje);
                                        else
                                        if(data.mensaje!="")
                                            alertSuccess(data.mensaje);
                                    },
                                    error: function (err) {
                                        alertError(err.responseText);
                                        showLoad(false);
                                    }
                                });
                                estado=false
                            }
                    });
                });
                showLoad(false);
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
        $("#id_detalle,#fecha_evento,#txt_evento,#txt_descripcion_evento").val("");

    }

    /** funcion para guardar detalle seguimiento sin imagen*/
    function guardarrastreo()
    {
        alertConfirm("¿Está seguro que desea guardar?", function (e) {
            /** Se recuperan datos de tabla Detalles de carga */
            var DATA1 = [];
            /** Se recuperan datos de tabla detalle de rastreo para validar*/
            var TABLA = $("#tblRastreo tbody > tr");
                //obtener detalle de rastreo
            TABLA.each(function (e) {
                let Fecha = $(this).find("input[id*='fecha_evento']").val();
                let Evento = $(this).find("select[id*='txt_evento']").val();
                let Descripcion = $(this).find("textarea[id*='txt_descripcion_evento']").val();
                let Id_detalle_seguimiento = $(this).find("input[id*='id_detalle']").val();

                item = {};
                item ["Fecha"] =Fecha;
                item ["Evento"] = Evento;
                item ["Descripcion"] = Descripcion;
                item ["Id_detalle_seguimiento"] = parseInt(Id_detalle_seguimiento);
                DATA1.push(item);
            });
            let tblRastreo = JSON.stringify(DATA1);

            var _token = $('input[name=_token]').val();
            var id_flete = $('#id_flete').val();
            if(id_flete!="")
            {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/rastreoSI/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        tblRastreo:tblRastreo,
                        id_flete:id_flete
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            $('#btnlimpiar').click();
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            }
            else
                alertError("Favor seleccione un flete");
        });
    }



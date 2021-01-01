var tblTipoTransporte = null;


    $(document).ready(function () {

        showLoad(true);
        listarTipoTransporte();

    });

    /** Funcion que lista todos los registro de tipo de transporte */
    function listarTipoTransporte() {

        var _token= $('input[name=_token]').val();

        tblTipoTransporte = setDataTable("#tblTipoTransporte", {
            ajax: {
                type: 'POST',
                url: '/tipoTransporte/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i class="btn btn-info fa fa-edit" title="Selecciona el registro" onclick="selectTipoTransporte(this)"></i>'
                }
            ]
        });

        /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
        $('#tblTipoTransporte').DataTable().on("draw", function(){
            showLoad(false);
        })

    }

    /** Funcion que permite actualizar o agregar un nuevo registro */
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_TipoTransporte= $('#id_TipoTransporte').val();
        var nombre= $('#txt_nombre').val();


        if (nombre!="" )
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/tipoTransporte/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_TipoTransporte:id_TipoTransporte,
                        nombre:nombre
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            tblTipoTransporte.ajax.reload();
                            resetForm();
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            });
        }
        else
            alertError("Favor ingrese nombre");
    }

    /** Limpia el formulario */
    function resetForm() {
        $("#id_TipoTransporte,#txt_nombre").val("");
        $('#btnEliminarTipoTransporte').attr("disabled", "FALSE");
    }

    /** Selecciona el tipo de transporte y carga valores en formulario */
    function selectTipoTransporte(datos) {

        var tr = $(datos).parents("tr")
        var data = tblTipoTransporte.row(tr).data();
        $('#btnEliminarTipoTransporte').removeAttr('disabled');

        //Capturamos valores de tabla
        Tipo = {
            id_TipoTransporte: data[0],
            nombre:data[1]
        };

        //Asignamos valores a formulario
        $('#id_TipoTransporte').val(Tipo.id_TipoTransporte);
        $('#txt_nombre').val(Tipo.nombre);

    }

    /** Funcion para eliminar registro*/
    function eliminar()
    {
        var id_TipoTransporte= $('#id_TipoTransporte').val();
        var _token = $('input[name=_token]').val();

        if (id_TipoTransporte!="")
        {
            alertConfirm("¿Está seguro que desea eliminar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/tipoTransporte/eliminar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_TipoTransporte:id_TipoTransporte
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            tblTipoTransporte.ajax.reload();
                            resetForm();
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            });
        }

    }

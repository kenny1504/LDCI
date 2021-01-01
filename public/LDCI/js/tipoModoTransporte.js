var tblTipoModoTransporte = null;


    $(document).ready(function () {

        showLoad(true);
        listarTipoModoTransporte();

    });

    /** Funcion que lista todos los registro de tipo modo transporte */
    function listarTipoModoTransporte() {

        var _token= $('input[name=_token]').val();

        tblTipoModoTransporte = setDataTable("#tblTipoModoTransporte", {
            ajax: {
                type: 'POST',
                url: '/tipoModoTransporte/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i class="btn btn-info fa fa-edit" title="Selecciona el registro" onclick="selectTipoModoTransporte(this)"></i>'
                }
            ]
        });

        /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
        $('#tblTipoModoTransporte').DataTable().on("draw", function(){
            showLoad(false);
        })

    }

    /** Funcion que permite actualizar o agregar un nuevo registro */
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_TipoModoTransporte= $('#id_TipoModoTransporte').val();
        var nombre= $('#txt_nombre').val();


        if (nombre!="" )
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/tipoModoTransporte/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_TipoModoTransporte:id_TipoModoTransporte,
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
                            tblTipoModoTransporte.ajax.reload();
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
        $("#id_TipoModoTransporte,#txt_nombre").val("");
        $('#btnEliminarTipoModoTransporte').attr("disabled", "FALSE");
    }

    /** Selecciona el tipo modo transporte y carga valores en formulario */
    function selectTipoModoTransporte(datos) {

        var tr = $(datos).parents("tr")
        var data = tblTipoModoTransporte.row(tr).data();
        $('#btnEliminarTipoModoTransporte').removeAttr('disabled');

        //Capturamos valores de tabla
        Tipo = {
            id_TipoModoTransporte: data[0],
            nombre:data[1]
        };

        //Asignamos valores a formulario
        $('#id_TipoModoTransporte').val(Tipo.id_TipoModoTransporte);
        $('#txt_nombre').val(Tipo.nombre);

    }

    /** Funcion para eliminar registro*/
    function eliminar()
    {
        var id_TipoModoTransporte= $('#id_TipoModoTransporte').val();
        var _token = $('input[name=_token]').val();

        if (id_TipoModoTransporte!="")
        {
            alertConfirm("¿Está seguro que desea eliminar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/tipoModoTransporte/eliminar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_TipoModoTransporte:id_TipoModoTransporte
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            tblTipoModoTransporte.ajax.reload();
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

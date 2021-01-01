var tblTipoMercancia = null;


    $(document).ready(function () {

        showLoad(true);
        listarTipoMercancia();

    });

    /** Funcion que lista todos los registro de tipo de mercancia */
    function listarTipoMercancia() {

        var _token= $('input[name=_token]').val();

        tblTipoMercancia = setDataTable("#tblTipoMercancia", {
            ajax: {
                type: 'POST',
                url: '/tipoMercancia/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i class="btn btn-info fa fa-edit" title="Selecciona el registro" onclick="selectTipoMercancia(this)"></i>'
                }
            ]
        });

        /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
        $('#tblTipoMercancia').DataTable().on("draw", function(){
            showLoad(false);
        })

    }

    /** Funcion que permite actualizar o agregar un nuevo registro */
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_TipoMercancia= $('#id_TipoMercancia').val();
        var nombre= $('#txt_nombre').val();


        if (nombre!="" )
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/tipoMercancia/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_TipoMercancia:id_TipoMercancia,
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
                            tblTipoMercancia.ajax.reload();
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
        $("#id_TipoMercancia,#txt_nombre").val("");
        $('#btnEliminarTipoMercancia').attr("disabled", "FALSE");
    }

    /** Selecciona el tipo de mercancia y carga valores en formulario */
    function selectTipoMercancia(datos) {

        var tr = $(datos).parents("tr")
        var data = tblTipoMercancia.row(tr).data();
        $('#btnEliminarTipoMercancia').removeAttr('disabled');

        //Capturamos valores de tabla
        Tipo = {
            id_TipoMercancia: data[0],
            nombre:data[1]
        };

        //Asignamos valores a formulario
        $('#id_TipoMercancia').val(Tipo.id_TipoMercancia);
        $('#txt_nombre').val(Tipo.nombre);

    }

    /** Funcion para eliminar registro*/
    function eliminar()
    {
        var id_TipoMercancia= $('#id_TipoMercancia').val();
        var _token = $('input[name=_token]').val();

        if (id_TipoMercancia!="")
        {
            alertConfirm("¿Está seguro que desea eliminar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/tipoMercancia/eliminar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_TipoMercancia:id_TipoMercancia
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            tblTipoMercancia.ajax.reload();
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

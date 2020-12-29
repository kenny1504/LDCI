var tblCotizaciones = null;
var id_cotizacion=null;
var asignada=null;
var id_usuario_asignado=null;


    $(document).ready(function () {

        listarCotizaciones();

    });

    /** Funcion que lista las cotizaciones hechas */
    function listarCotizaciones() {

        showLoad(true);

        var estado= $('#cmb_estado').val();
        var _token= $('input[name=_token]').val();

        tblCotizaciones = setDataTable("#tblCotizaciones", {
            ajax: {
                type: 'POST',
                url: '/cotizaciones/getAll', //llamada a la ruta
                data: {
                    _token:_token,
                    estado:estado
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
                    render: function (json) {
                        if(tipoUsuario==1)
                    {
                        if (json[5]!=-1)
                        {
                            return  '<i title="Asignar vendedor" class=" btn btn-success fa fa-user" onclick="setvendedor(this)">Asignar</i>'+
                                '<i title="Imprimir" class=" btn btn-info fa  fa-file-pdf-o" onclick="rpt_cotizacion(this)">PDF</i>'
                        }else
                        {
                            return  '<i title="Imprimir" class=" btn btn-info fa  fa-file-pdf-o" onclick="">PDF</i>'

                        }
                    }else
                    {
                        return  '<i title="Imprimir" class=" btn btn-info fa  fa-file-pdf-o" onclick="">PDF</i>'
                    }
                 }
                }
            ]
        });

        /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
        $('#tblCotizaciones').DataTable().on("draw", function(){
            showLoad(false);
        })

    }

    function changeEstado()
    {
        /** Limpia datatable para evitar error " Cannot reinitialise DataTable"  */
        table = $('#tblCotizaciones').DataTable().destroy();
        listarCotizaciones();
    }

    /** Funcion para asignar un vendedor a una cotizacion */
    function setvendedor(datos)
    {
        var dt = tblCotizaciones.row($(datos).parents('tr')).data();
         id_cotizacion=dt[0];
        var _token= $('input[name=_token]').val();
        $('#lblCotizacion').text("N.º Cotizacion "+id_cotizacion);

        /** recupera usuarios tipo vendedor*/
        $.ajax({
            type: 'POST',
            url: '/vendedores/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#selecVendedor').empty();
                $('#selecVendedor').select2({  height: "40px",width:"100%"}) // agrega el select2

                var datos='<option selected disabled value=" ">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_usuario + '">' + element.usuario + '</option>';
                });

                $('#selecVendedor').append(datos);
                $("#ModalAsignarVendedor").modal("show"); //Abre Modal


                /** Verifica que si existe una asignacion */
                $.ajax({
                    type: 'POST',
                    url: '/Asignacion', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_cotizacion:id_cotizacion
                    },
                    success: function (data) {
                        if (Object.entries(data).length==0)
                        {
                            id_usuario_asignado=null;
                            asignada=false;
                        }
                        else
                        {
                            alertSuccess("Eata cotizacion ya posee un vendedor asignado")
                            $('#selecVendedor').val(data[0].id_usuario);
                            id_usuario_asignado=data[0].id_usuario;
                            $('#selecVendedor').change()
                            asignada=true;
                        }

                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });

                showLoad(false);

            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });


    }


    /** funcion para asignar un vendedor a una cotizacion*/
    function setCotizacion()
    {

        var id_vendedor= $('#selecVendedor').val();
        var _token= $('input[name=_token]').val();

        if ( id_vendedor!=null && id_usuario_asignado==id_vendedor)
        {
            $("#ModalAsignarVendedor").modal("hide"); //cierra Modal
        }
        else
        {
            if (id_vendedor!=" " && id_vendedor!=null )
            {
                alertConfirm("¿Está seguro que desea asignar?", function (e) {

                    showLoad(true);
                    $.ajax({
                        type: 'POST',
                        url: '/Asignarvendedor', //llamada a la ruta
                        data: {
                            _token:_token,
                            id_vendedor:id_vendedor,
                            id_cotizacion:id_cotizacion,
                            asignada:asignada
                        },
                        success: function (data) {

                            showLoad(false);
                            if (data.error) {
                                alertError(data.mensaje);
                            }
                            else
                            {
                                alertSuccess(data.mensaje);
                                $("#ModalAsignarVendedor").modal("hide"); //cierra Modal
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
                alertError("Favor seleccione un vendedor");
        }

    }

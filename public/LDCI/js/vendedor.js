var tblVendedores = null;


    $(document).ready(function () {

        var _token= $('input[name=_token]').val();
        showLoad(true);

        /** recupera los departmentos de Nicaragua */
        $.ajax({
            type: 'POST',
            url: '/departamentos/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_Departamento').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_ciudad + '">' + element.nombre + '</option>';
                });

                $('#cmb_Departamento').append(datos);
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

    });

    function  listarVendedores()
    {
        var _token= $('input[name=_token]').val();
        $("#tblVendedores").DataTable().destroy();

        tblVendedores = setDataTable("#tblVendedores", {
            ajax: {
                type: 'POST',
                url: '/vendedor/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [{
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info btnSeleccionarRegistro" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }]
        });
    }


    /** Guarda / actualiza un  registros*/
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_empleado= $('#id_empleado').val();
        var nombres= $('#txt_nombres').val();
        var apellido1= $('#txt_apellido1').val();
        var apellido2= $('#txt_apellido2').val();
        var cedula= $('#txt_cedula').val();
        var direccion= $('#txt_direccion').val();
        var departamento= $('#cmb_Departamento').val();
        var telefono_1= $('#txt_telefono_1').val();
        var telefono_2= $('#txt_telefono_2').val();
        var nomb_notifica= $('#txt_nomb_notifica').val();
        var estado_civil= $('#cmb_estado_civil').val();
        var telefono_not= $('#txt_telefono_not').val();

        if (id_usuario=="")
            alertSuccess("Al registrar el usuario se genera una contraseña por default 'ldci123' ");

        if (usuario!="" && telefono!="" && correo!="" && tipo!="")
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/usuarios/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_usuario:id_usuario,
                        usuario:usuario,
                        correo:correo,
                        correo_old:correo_old,
                        telefono:telefono,
                        iso:iso,
                        tipo:tipo
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                            return;
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            tblUsuario.ajax.reload();
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
            alertError("Favor completar todos los campos");

    }

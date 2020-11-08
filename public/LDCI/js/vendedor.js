var tblVendedores = null;


    $(document).ready(function () {

        $('#txt_cedula').mask('000-000000-0000S');
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
        cedula = cedula.split("-")
        cedula=cedula[0]+cedula[1]+cedula[2]
        var direccion= $('#txt_direccion').val();
        var departamento= $('#cmb_Departamento').val();
        var telefono_1= $('#txt_telefono_1').val();
        var telefono_2= $('#txt_telefono_2').val();
        var nomb_notifica= $('#txt_nomb_notifica').val();
        var estado_civil= $('#cmb_estado_civil').val();
        var telefono_not= $('#txt_telefono_not').val();
        var edad= $('#txt_edad').val();
        var correo= $('#txt_correo').val();


        if (correo!="" && edad!="" && estado_civil!="" && nombres!="" && apellido1!="" && apellido2!="" && cedula!="" && cedula!=""&& direccion!="" && departamento!="" && telefono_1!="" && nomb_notifica!="" && telefono_not!="")
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/vendedor/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_empleado:id_empleado,
                        nombres:nombres.trim().toUpperCase(),
                        apellido1:apellido1.trim().toUpperCase(),
                        apellido2:apellido2.trim().toUpperCase(),
                        cedula:cedula.toUpperCase(),
                        direccion:direccion.trim(),
                        departamento:departamento,
                        telefono_1:telefono_1,
                        telefono_2:telefono_2,
                        nomb_notifica:nomb_notifica,
                        estado_civil:estado_civil,
                        telefono_not:telefono_not,
                        edad:edad,
                        correo:correo
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
                            tblVendedores.ajax.reload();
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

    /** Limpia el formulario */
    function resetForm() {

        $("#txt_correo,#txt_edad,#id_empleado,#txt_nombres,#txt_apellido1,#txt_apellido2,#txt_cedula,#txt_direccion,#cmb_Departamento,#txt_telefono_1,#txt_telefono_2,#txt_nomb_notifica,#cmb_estado_civil,#txt_telefono_not").val("");
        $('#btnEliminarEmpleado').attr("disabled", "FALSE");
    }

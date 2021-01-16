var tblVendedores = null;


    $(document).ready(function () {

        $('#txt_cedula').mask('000-000000-0000S');
        var _token= $('input[name=_token]').val();
        showLoad(true);

        /** recupera los departamentos de Nicaragua */
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
                defaultContent: '<button class="btn btn-info" title="Selecciona el registro" onclick="selectVendedor(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
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
        var edad= $('#txt_edad').val();
        var correo= $('#txt_correo').val();
        var sexo= $('#cmb_sexo').val();

        if (apellido2!="")
            apellido2:apellido2.trim().toUpperCase()

        if (correo!="" && edad!="" && estado_civil!="" && nombres!="" && apellido1!=""  && cedula!="" && sexo!=""&& direccion!="" && departamento!="" && telefono_1!="" && nomb_notifica!="" && telefono_not!="")
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
                        apellido2:apellido2,
                        cedula:cedula.toUpperCase(),
                        direccion:direccion.trim(),
                        departamento:departamento,
                        telefono_1:telefono_1,
                        telefono_2:telefono_2,
                        nomb_notifica:nomb_notifica.trim().toUpperCase(),
                        estado_civil:estado_civil,
                        telefono_not:telefono_not,
                        edad:edad,
                        correo:correo.trim(),
                        sexo:sexo.trim()
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                            return;
                        }
                        else
                        {
                            resetForm();
                            alertSuccess(data.mensaje);
                            tblVendedores.ajax.reload();
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

    function eliminar()
    {
        var _token = $('input[name=_token]').val();
        var id_empleado= $('#id_empleado').val();


        alertConfirm("¿Está seguro que desea eliminar?", function (e) {
            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/vendedor/eliminar', //llamada a la ruta
                data: {
                    _token:_token,
                    id_empleado:id_empleado
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

    /** Selecciona el vendedor y carga valores en formulario */
    function selectVendedor(datos) {

        showLoad(true);
        var _token = $('input[name=_token]').val();
        var tr = $(datos).parents("tr")
        var data = tblVendedores.row(tr).data();
        $('#btnEliminarEmpleado').removeAttr('disabled');

        //Capturamos valores de tabla
        Vendedor = {
            id_vendedor: data[0]
        };

        $.ajax({
            type:'POST',
            url: '/vendedor/datos',
            data:{
                _token:_token,
                id_vendedor:Vendedor.id_vendedor
            },
            success: function(data){
                showLoad(false);

                $('#id_empleado').val(Vendedor.id_vendedor);
                $('#txt_nombres').val(data[0].nombre);
                $('#txt_apellido1').val(data[0].apellido1);
                $('#txt_apellido2').val(data[0].apellido2);
                $('#txt_cedula').val(data[0].cedula);
                $('#txt_direccion').val(data[0].direccion);
                $('#cmb_Departamento').val(data[0].id_departamento);
                $('#txt_telefono_1').val(data[0].telefono_1);
                $('#txt_telefono_2').val(data[0].telefono_2);
                $('#txt_nomb_notifica').val(data[0].contacto_emergencia);
                $('#cmb_estado_civil').val(data[0].estado_civil);
                $('#txt_telefono_not').val(data[0].telefono_emergencia);
                $('#txt_edad').val(data[0].edad);
                $('#txt_correo').val(data[0].correo);
                $('#cmb_sexo').val(data[0].sexo);
                $('#cmb_sexo').change();
                $('.correo_validar').removeAttr('onblur');
                $('.correo_validar').attr('onchange','CorreoVerify(this)');

            },
            error: function(err){
                alertError(err.responseText);
                showLoad(false);
            }
        });

    }

    /** Limpia el formulario */
    function resetForm() {

        $("#txt_correo,#txt_edad,#id_empleado,#txt_nombres,#txt_apellido1,#txt_apellido2,#txt_cedula,#txt_direccion,#cmb_Departamento,#txt_telefono_1,#txt_telefono_2,#txt_nomb_notifica,#cmb_estado_civil,#txt_telefono_not").val("");
        $('#btnEliminarEmpleado').attr("disabled", "FALSE");
        $('.correo_validar').attr('onblur','valida_usuario()');
        $('.correo_validar').removeAttr('onchange');
    }

    /** Funcion para validar correo, que coincida con el usuario */
    function valida_usuario()
    {
        var _token= $('input[name=_token]').val();
        var correo= $('#txt_correo').val();

        if (correo!="")
        {
            $.ajax({
                type: 'POST',
                url: '/vendedor/correo', //llamada a la ruta
                data: {
                    _token:_token,
                    correo:correo
                },
                success: function (data) {

                    if (Object.entries(data).length==0)
                    {
                        alertError("No existe ningun usuario con este correo asociado");
                        $('#txt_correo').val("");
                    }else if (data[0].correo!=null)
                    {
                        alertError("Ya existe un usuario con este correo asociado");
                        $('#txt_correo').val("");
                    }
                    else
                        alertSuccess("Usuario:"+data[0].usuario);
                    showLoad(false);
                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }
            });
        }
    }



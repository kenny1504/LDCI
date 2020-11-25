var tblProveedores = null;


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

    function  listarProveedores()
    {
        var _token= $('input[name=_token]').val();
        $("#tblProveedores").DataTable().destroy();

        tblProveedores = setDataTable("#tblProveedores", {
            ajax: {
                type: 'POST',
                url: '/proveedor/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [{
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info" onclick="selectProveedor(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }]
        });
    }

    /** Guarda o actualizar un registros*/
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_proveedor= $('#id_proveedor').val();
        var nombres= $('#txt_nombres').val();
        var apellido1= $('#txt_apellido1').val();
        var apellido2= $('#txt_apellido2').val();
        var cedula= $('#txt_cedula').val();
        var direccion= $('#txt_direccion').val();
        var departamento= $('#cmb_Departamento').val();
        var telefono_1= $('#txt_telefono_1').val();
        var telefono_2= $('#txt_telefono_2').val();
        var edad= $('#txt_edad').val();
        var correo= $('#txt_correo').val();
        var sexo= $('#cmb_sexo').val();

        if (correo!="" && edad!="" && nombres!="" && apellido1!="" && apellido2!="" && cedula!="" && sexo!=""&& direccion!="" && departamento!="" && telefono_1!="")
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/proveedor/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_proveedor:id_proveedor,
                        nombres:nombres.trim().toUpperCase(),
                        apellido1:apellido1.trim().toUpperCase(),
                        apellido2:apellido2.trim().toUpperCase(),
                        cedula:cedula.toUpperCase(),
                        direccion:direccion.trim(),
                        departamento:departamento,
                        telefono_1:telefono_1,
                        telefono_2:telefono_2,
                        edad:edad,
                        correo:correo,
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
                            alertSuccess(data.mensaje);
                            tblProveedores.ajax.reload();
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
    /**Deshabilitar un proveedor */
    function eliminar()
    {
        var _token = $('input[name=_token]').val();
        var id_proveedor= $('#id_proveedor').val();


        alertConfirm("¿Está seguro que desea eliminar?", function (e) {
            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/proveedor/eliminar', //llamada a la ruta
                data: {
                    _token:_token,
                    id_proveedor:id_proveedor
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
                        tblProveedores.ajax.reload();
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

    /** Selecciona el proveedor y carga valores en formulario */
    function selectProveedor(datos) {

        showLoad(true);
        var _token = $('input[name=_token]').val();
        var tr = $(datos).parents("tr")
        var data = tblProveedores.row(tr).data();
        $('#btnEliminarProveedor').removeAttr('disabled');

        //Capturamos valores de tabla
        Proveedor = {
            id_proveedor: data[0]
        };

        $.ajax({
            type:'POST',
            url: '/proveedor/datos',
            data:{
                _token:_token,
                id_proveedor:Proveedor.id_proveedor
            },
            success: function(data){
                showLoad(false);

                $('#id_proveedor').val(Proveedor.id_proveedor);
                $('#txt_nombres').val(data[0].nombre);
                $('#txt_apellido1').val(data[0].apellido1);
                $('#txt_apellido2').val(data[0].apellido2);
                $('#txt_cedula').val(data[0].cedula);
                $('#txt_direccion').val(data[0].direccion);
                $('#cmb_Departamento').val(data[0].id_departamento);
                $('#txt_telefono_1').val(data[0].telefono_1);
                $('#txt_telefono_2').val(data[0].telefono_2);
                $('#txt_edad').val(data[0].edad);
                $('#txt_correo').val(data[0].correo);
                $('#cmb_sexo').val(data[0].sexo);
            },
            error: function(err){
                alertError(err.responseText);
                showLoad(false);
            }
        });
    }

    /** Limpia el formulario */
    function resetForm() {

        $("#txt_correo,#txt_edad,#id_proveedor,#txt_nombres,#txt_apellido1,#txt_apellido2,#txt_cedula,#txt_direccion,#cmb_Departamento,#txt_telefono_1,#txt_telefono_2,#cmb_sexo").val("");
        $('#btnEliminarProveedor').attr("disabled", "FALSE");
    }

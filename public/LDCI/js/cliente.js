var tblClientes=null;

    var input = document.querySelector("#txt_telefono_2");
    select = window.intlTelInput(input, {
    allowDropdown: true,
    autoHideDialCode: false,
    autoPlaceholder: "off",
    dropdownContainer: document.body,
    formatOnDisplay: false,
    geoIpLookup: function(callback) {
    $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
    var countryCode = (resp && resp.country) ? resp.country : "";
    callback(countryCode);
    });
    },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        setNumber:351,
        utilsScript: "LDCI/Core/utils.js",
    });

    var input = document.querySelector("#txt_telefono_1");
    select = window.intlTelInput(input, {
        allowDropdown: true,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        formatOnDisplay: false,
        geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        setNumber:351,
        utilsScript: "LDCI/Core/utils.js",
    });


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


    function clienteJuridico()
    {
        var checkbox=document.getElementById('ckTipo');

        if (checkbox.checked == true)
          $('.juridico').removeAttr('hidden');
      else
          $('.juridico').attr("hidden",true);
    }


    /** Guarda / actualiza un  registros*/
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_cliente= $('#id_cliente').val();
        var nombre_Empresa= $('#txt_nombreEmpresa').val();
        var giro_Negocio= $('#txt_giroNegocio').val();
        var ruc= $('#txt_ruc').val();
        var nombres= $('#txt_nombres').val();
        var telefono_1= $('#txt_telefono_1').val();
        var apellido1= $('#txt_apellido1').val();
        var apellido2= $('#txt_apellido2').val();
        var edad= $('#txt_edad').val();
        var sexo= $('#cmb_sexo').val();
        var cedula= $('#txt_cedula').val();
        var direccion= $('#txt_direccion').val();
        var departamento= $('#cmb_Departamento').val();
        var correo= $('#txt_correo').val();
        var telefono_2= $('#txt_telefono_2').val();
        var tipo=null;
        var guardar=false;

        if (apellido2!="")
            apellido2:apellido2.trim().toUpperCase()

        var checkbox=document.getElementById('ckTipo');

        if (checkbox.checked == true)
        {
            if (nombres!="" && ruc!="" && nombre_Empresa!="" && giro_Negocio!="" && telefono_1!=""  && apellido1!="" && cedula!="" && direccion!="" && departamento!="" && correo!="" && telefono_2!="" && sexo!="")
            {   guardar=true;
                nombre_Empresa= nombre_Empresa.trim().toUpperCase()
                giro_Negocio=giro_Negocio.trim().toUpperCase()
                tipo=2;
            }
         }
        else
        {
            if (estado_civil!="" && apellido1!="" && cedula!="" && direccion!="" && departamento!="" && correo!="" && telefono_2!="" && sexo!="")
            {guardar=true;
                tipo=1;
            }
        }

        if (guardar==true)
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/cliente/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_cliente:id_cliente,
                        nombre_Empresa:nombre_Empresa,
                        giro_Negocio:giro_Negocio,
                        ruc:ruc.trim().toUpperCase(),
                        nombres:nombres.trim().toUpperCase(),
                        apellido1:apellido1.trim().toUpperCase(),
                        apellido2:apellido2,
                        cedula:cedula.toUpperCase(),
                        direccion:direccion.trim().toUpperCase(),
                        departamento:departamento,
                        telefono_1:telefono_1,
                        telefono_2:telefono_2,
                        edad:edad,
                        correo:correo.trim(),
                        sexo:sexo.trim(),
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
                            tblClientes.ajax.reload();
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


    function  listarClientes()
    {
        var _token= $('input[name=_token]').val();
        $("#tblClientes").DataTable().destroy();

        tblClientes = setDataTable("#tblClientes", {
            ajax: {
                type: 'POST',
                url: '/cliente/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [{
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info" onclick="selectVendedor(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }]
        });
    }


    /** Limpia el formulario */
    function resetForm() {
        $('#ckTipo').removeAttr('checked');
        $("#id_cliente,#nombre_Empresa,#giro_Negocio,#ruc,#nombres").val("");
        $("#telefono_1,#apellido1,#apellido2,#edad,#sexo").val("");
        $("#cedula,#direccion,#correo,#telefono_2").val("");
    }

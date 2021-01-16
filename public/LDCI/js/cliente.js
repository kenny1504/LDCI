var tblClientes=null;

    var input = document.querySelector("#txt_telefono_2");
    select2 = window.intlTelInput(input, {
    allowDropdown: true,
    autoHideDialCode: false,
    autoPlaceholder: "off",
    dropdownContainer: document.body,
    formatOnDisplay: false,
    geoIpLookup: function(callback) {
    $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
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
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
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
                    datos+='<option value="0">'+ 'Otro' +'</option>';
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
        var iso2=select2.getSelectedCountryData().iso2;
        var iso=select.getSelectedCountryData().iso2;
        var tipo=null;
        var guardar=false;
        var extranjero=null;

        if (apellido2!="")
            apellido2:apellido2.trim().toUpperCase()

        var checkbox=document.getElementById('ckTipo');
        var checkbox1=document.getElementById('ckExtranjero');
        var save;
        var t;
        if(checkbox1.checked==false)
        {
            t = validar_cedula(cedula);
            if(t==false)
            save=false;
            else
            save=true;
        }
        else if(checkbox1.checked==true)
        {
            clienteExtranjero();
            save=true;
        }





        if (checkbox.checked == true)
        {
            if (nombres!="" && ruc!="" && nombre_Empresa!="" && giro_Negocio!="" && telefono_1!=""  && apellido1!="" && cedula!="" && direccion!="" && departamento!="" && correo!="" && telefono_2!="" && sexo!="" && sexo!=null)
            {   guardar=true;
                nombre_Empresa= nombre_Empresa.trim().toUpperCase()
                giro_Negocio=giro_Negocio.trim().toUpperCase()
                tipo=2;
            }
        }
        else
        {
            if (nombres!="" && apellido1!="" && cedula!="" && direccion!="" && departamento!="" && correo!="" && telefono_2!="" && sexo!="" && sexo!=null)
            {
                guardar=true;
                tipo=1;
            }
        }
        if(checkbox1.checked == true)//mandar si es extranjero o no
            extranjero=1
        else
            extranjero=0
        if (guardar==true && save)
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
                        tipo:tipo,
                        extranjero:extranjero,
                        iso2:iso2,
                        iso:iso
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
                            tblClientes.ajax.reload();
                            clienteExtranjero();
                        }
                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
            });
        }
        else if(!save)
            alertError("Verificar Cédula Naciona;");
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
            columnDefs: [
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        if (json[5] == 1)
                            return '<span data-toggle="tooltip" data-state="1" class="btnStatus btn btn-xs btn-block btn-primary">Natural</span>';
                        if (json[5] == 2)
                            return '<span data-toggle="tooltip" data-state="1" class="btnStatus btn btn-xs btn-block btn-success">Juridico</span>';
                    }
                },
                {
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info" title="Selecciona el registro" onclick="selectCliente(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }]
        });
    }

    function eliminar()
    {
        var _token = $('input[name=_token]').val();
        var id_cliente= $('#id_cliente').val();

        alertConfirm("¿Está seguro que desea eliminar?", function (e) {
            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/cliente/eliminar', //llamada a la ruta
                data: {
                    _token:_token,
                    id_cliente:id_cliente
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


    /** Selecciona el cliente  y carga valores en formulario */
    function selectCliente(datos) {

        showLoad(true);
        resetForm()
        var tr = $(datos).parents("tr")
        var data = tblClientes.row(tr).data();
        $('#btnEliminarCliente').removeAttr('disabled');
        //Capturamos valores de tabla
        cliente = {
            id_cliente: data[0]
        };

        var _token = $('input[name=_token]').val();
        $.ajax({
            type: 'POST',
            url: '/cliente/datos', //llamada a la ruta
            data: {
                _token:_token,
                id_cliente:cliente.id_cliente,
            },
            success: function (data) {

                $('#ckTipo').click();
                $('#ckExtranjero').click();
                var Tipo =   document.getElementById('ckTipo');
                var ciudadania =   document.getElementById('ckExtranjero');
                /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
                if (data[0].tipo==2)
                {
                    if (Tipo.checked == false)
                        $('#ckTipo').click();
                }
                else
                {
                    if (Tipo.checked == true)
                        $('#ckTipo').click();
                }

                if(data[0].extranjero==true)
                {
                    if(ciudadania.checked == false)
                        $('#ckExtranjero').click();
                }
                else
                {
                    if(ciudadania.checked == true)
                        $('#ckExtranjero').click();
                }

                $('#id_cliente').val(cliente.id_cliente);
                $('#txt_nombreEmpresa').val(data[0].nombre_empresa);
                $('#txt_giroNegocio').val(data[0].giro_negocio);
                $('#txt_ruc').val(data[0].ruc);
                $('#txt_nombres').val(data[0].nombre);
                $('#txt_telefono_1').val(data[0].telefono_1);
                $('#txt_apellido1').val(data[0].apellido1);
                $('#txt_apellido2').val(data[0].apellido2);
                $('#txt_edad').val(data[0].edad);
                $('#cmb_sexo').val(data[0].sexo.trim());
                $('#cmb_sexo').change();
                $('#txt_cedula').val(data[0].cedula);
                $('#txt_direccion').val(data[0].direccion);
                $('#cmb_Departamento').val(data[0].id_departamento);
                $('#txt_correo').val(data[0].correo);
                $('#txt_telefono_2').val(data[0].telefono_2);
                select2.setCountry(data[0].iso_2);
                select.setCountry(data[0].iso);
                $('.correo_validar').removeAttr('onblur');
                $('.correo_validar').attr('onchange','CorreoVerify(this)');
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });


    }

    /** Limpia el formulario */
    function resetForm() {

        var Tipo =   document.getElementById('ckTipo');
        var Tipo_Nac =   document.getElementById('ckExtranjero');
        if(Tipo_Nac.checked == true)
        $('#ckExtranjero').click();
        if (Tipo.checked == true)
            $('#ckTipo').click();

        $('#btnEliminarCliente').attr("disabled", "FALSE");
        $('#ckTipo').removeAttr('checked');
        $('#ckExtranjero').removeAttr('checked');
        $("#id_cliente,#txt_nombreEmpresa,#txt_giroNegocio,#txt_ruc,#txt_nombres").val("");
        $("#txt_telefono_1,#txt_apellido1,#apellido2,#txt_apellido2,#txt_edad").val("");
        $("#cmb_sexo,#txt_cedula,#txt_direccion,#cmb_Departamento,#txt_correo,#txt_telefono_2").val("");
        $('.correo_validar').attr('onblur','valida_usuario()');
        $('.correo_validar').removeAttr('onchange');

    }


    function valida_usuario()
    {
        var _token= $('input[name=_token]').val();
        var correo= $('#txt_correo').val();

        if (correo!="")
        {
            $.ajax({
                type: 'POST',
                url: '/cliente/correo', //llamada a la ruta
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

    function clienteExtranjero()
    {
        var checkbox=document.getElementById('ckExtranjero');
        if(checkbox.checked == true)
        {
            $('.extranjero').removeAttr('onblur');
            document.getElementById('textotest').innerText="Numero de Identificacion"
            $('#txt_cedula').unmask();//deshabilidar mascara
            $('.extranjero').attr('minlength','3');
            $('.extranjero').attr('maxlength','20');//establecer una longitud global para identificaciones, no nacionales
            $('.extranjero').removeAttr('placeholder');
        }
        else
        {
            document.getElementById('textotest').innerText="Cédula Nacional"

            $('#txt_cedula').mask('000-000000-0000S');
            $('.extranjero').attr('onblur','verificar_cedula(this)');
            $('.extranjero').attr('placeholder','001-000000-0000A');
        }
    }

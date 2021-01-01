var tblProveedores = null;

    var input = document.querySelector("#txt_telefono_1");
    select_1 = window.intlTelInput(input, {
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

    var input = document.querySelector("#txt_telefono_2");
    select_2 = window.intlTelInput(input, {
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

        var _token= $('input[name=_token]').val();
        showLoad(true);

        /** recupera los paises */
        $.ajax({
            type: 'POST',
            url: '/paises/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_Pais').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_pais + '">' + element.nombre + '</option>';
                });

                $('#cmb_Pais').append(datos);
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
            columnDefs:
            [
                {
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info" title="Selecciona el registro" onclick="selectProveedor(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }
        ]
        });
    }

    /** Guarda o actualizar un registros*/
    function guardar()
    {
        var _token = $('input[name=_token]').val();
        var id_proveedor= $('#id_proveedor').val();
        var nombre= $('#txt_nombre').val();
        var correo= $('#txt_correo').val();
        var direccion= $('#txt_direccion').val();
        var pais= $('#cmb_Pais').val();
        var pagina_web= $('#txt_pagina_web').val();
        var telefono_1= $('#txt_telefono_1').val();
        var telefono_2= $('#txt_telefono_2').val();
        var iso= select_1.getSelectedCountryData().iso2;
        var iso2= select_2.getSelectedCountryData().iso2;

        if (correo!="" && nombre!="" && direccion!="" && telefono_1!="")
        {
            alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/proveedor/guardar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_proveedor:id_proveedor,
                        nombre:nombre.trim().toUpperCase(),
                        correo:correo,
                        direccion:direccion.trim(),
                        pais:pais,
                        pagina_web:pagina_web,
                        telefono_1:telefono_1,
                        telefono_2:telefono_2,
                        iso:iso,
                        iso2:iso2
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
                $('#txt_nombre').val(data[0].nombre);
                $('#txt_correo').val(data[0].correo);
                $('#txt_direccion').val(data[0].direccion);
                $('#cmb_Pais').val(data[0].id_pais);
                $('#txt_pagina_web').val(data[0].pagina_web);
                $('#txt_telefono_1').val(data[0].telefono_1);
                $('#txt_telefono_2').val(data[0].telefono_2);
                select_1.setCountry(data[0].iso);
                select_2.setCountry(data[0].iso_2);
            },
            error: function(err){
                alertError(err.responseText);
                showLoad(false);
            }
        });
    }

    /** Limpia el formulario */
    function resetForm() {

        $("#id_proveedor,#txt_nombre,#txt_correo,#txt_direccion,#cmb_Pais,#txt_pagina_web,#txt_telefono_1,#txt_telefono_2").val("");
        $('#btnEliminarProveedor').attr("disabled", "FALSE");
    }

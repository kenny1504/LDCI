

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
        debugger;
        var checkbox=document.getElementById('ckTipo');

        if (checkbox.checked == true)
          $('.juridico').removeAttr('hidden');
      else
          $('.juridico').attr("hidden",true);
    }

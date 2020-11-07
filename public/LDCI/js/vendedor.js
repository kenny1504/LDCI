var tblVendedores = null;


    $(document).ready(function () {

        var _token= $('input[name=_token]').val();
        showLoad(true);

        $.ajax({
            type: 'POST',
            url: '/departamentos/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#SelectDepartamento').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_ciudad + '">' + element.nombre + '</option>';
                });

                $('#SelectDepartamento').append(datos);
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

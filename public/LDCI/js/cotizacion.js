    $(document).ready(function(){
        'use strict';
        var _token= $('input[name=_token]').val();

        $('#wizard').steps({
            headerTag: 'h3',
            bodyTag: 'section',
            autoFocus: true,
            titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
            onStepChanging: function (event, currentIndex, newIndex) {
                if(currentIndex < newIndex) {
                    // Step 1 form validation
                    if(currentIndex === 0) {
                        var tipo_transporte = $('#cmb_tipo_transporte').parsley();
                        var fecha = $('#txt_fecha').parsley();
                        var destino = $('#cmb_destino').parsley();
                        var origen = $('#cmb_origen').parsley();

                        if(tipo_transporte.isValid() && fecha.isValid() && destino.isValid() && origen.isValid()) {
                            return true;
                        } else {
                            tipo_transporte.validate();
                            fecha.validate();
                            destino.validate();
                            origen.validate();
                        }
                    }

                    // Step 2 form validation
                    if(currentIndex === 1) {
                        var email = $('#email').parsley();
                        if(email.isValid()) {
                            return true;
                        } else { email.validate(); }
                    }
                    // Always allow step back to the previous step even if the current step is not valid.
                } else { return true; }
            }
        });

        /** recupera ciudades del mundo*/
        $.ajax({
            type: 'POST',
            url: '/ciudades/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_destino').select2() // agrega el select2 a combobox tutores para buscar
                $('#cmb_origen').select2()

                var datos='';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_ciudad + '">' + element.ciudad + '</option>';
                });

                $('#cmb_destino').append(datos);
                $('#cmb_origen').append(datos);

                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** recupera tipos de transporte*/
        $.ajax({
            type: 'POST',
            url: '/transporte/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_tipo_transporte').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_tipo_transporte + '">' + element.nombre + '</option>';
                });

                $('#cmb_tipo_transporte').append(datos);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** recupera tipos de mercancias*/
        $.ajax({
            type: 'POST',
            url: '/mercancia/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_tipo_mercancia').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_tipo_mercancia + '">' + element.nombre + '</option>';
                });

                $('#cmb_tipo_mercancia').append(datos);
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** recupera modo transporte*/
        $.ajax({
            type: 'POST',
            url: '/modoTransporte/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_modo_transporte').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_tipo_modo_transporte + '">' + element.nombre + '</option>';
                });

                $('#cmb_modo_transporte').append(datos);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });



    });


    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFila").on("click", "#btnAdicionarFila", function () {

        $("#tblDetalle tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalle tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblDetalle").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblDetalle tr").length;
        if (numeroFilas > 2) {
            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

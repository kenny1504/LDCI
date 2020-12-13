    $(document).ready(function(){
        'use strict';
        var _token= $('input[name=_token]').val();

        /** Añade propiedades a wizard*/
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
                        var cantidad = $('#txtCantidad').parsley();
                        var mercancia = $('#cmb_tipo_mercancia').parsley();
                        var modo_transporte = $('#cmb_modo_transporte').parsley();

                        if(cantidad.isValid() && mercancia.isValid() && modo_transporte.isValid()) {
                            return true;
                        } else {
                            cantidad.validate();
                            mercancia.validate();
                            modo_transporte.validate();
                        }
                    }
                    // Step 3 form validation
                    if(currentIndex === 2) {
                        return true;
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

                $('#cmb_destino').select2({  height: "40px"}) // agrega el select2 a combobox tutores para buscar
                $('#cmb_origen').select2({  height: "40px"})

                var datos='<option selected disabled value ="">Seleccione</option>';
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

        /** recupera servicios*/
        $.ajax({
            type: 'POST',
            url: '/servicios/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_servicio').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_producto + '">' + element.nombre + '</option>';
                });

                $('#cmb_servicio').append(datos);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** Busca botton finish y añade evento para guardar cotizacion */
        var finish = $( "#wizard" ).find(".actions a[href$='#finish']")
        finish.on("click",guardar)


    });


    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFilaC").on("click", "#btnAdicionarFilaC", function () {

        $("#tblDetalleCarga tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleCarga tbody").find("input, select,textarea,label,div,span").val("");

    });

    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFilaS").on("click", "#btnAdicionarFilaS", function () {

        $("#tblDetalleServicios tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleServicios tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleCarga").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblDetalleCarga tr").length;
        if (numeroFilas > 2) {
            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleServicios").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblDetalleServicios tr").length;
        if (numeroFilas > 2) {
            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    function guardar()
    {
        alertSuccess("prueba");
    }

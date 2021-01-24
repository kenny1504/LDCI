var Total_Entrada=0;

    $(document).ready(function(){

        showLoad(true);
        'use strict';
        var _token= $('input[name=_token]').val();

        /** recupera proveedores*/
        $.ajax({
            type: 'POST',
            url: '/proveedores/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_Proveedor').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_proveedor + '">' + element.nombre + '</option>';
                });

                $('#cmb_Proveedor').append(datos);
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** recupera productos*/
        $.ajax({
            type: 'POST',
            url: '/productos/getAll', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {

                $('#cmb_Producto').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_producto + '">' + element.nombre + '</option>';
                });

                $('#cmb_Producto').append(datos);
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });
    });

    /** Funcion para calcular el total de entrada */
    function precio_total(e, input) {

        // Obtener contenedor desde el elemento que cambió
        let fila = $(e.target).closest('tr');

        // Usar .find() para obtener cantidad, precio
        let columna_cantidad = parseFloat($(fila).find("#txt_cantidad").val()) || 0;
        let columna_precio_unitario = parseFloat($( fila).find("#txt_precio").val()) || 0;

        // Asignar Importe
        $(fila).find("#txt_Sub_precio").val('$'+columna_cantidad * columna_precio_unitario);

        //Procedimiento para calcular Total Entrada
        if(input.id=="txt_cantidad")
        {
            var oldvalor= input.oldValue;
            var newValor = input.value;
            Total_Entrada=Total_Entrada-(oldvalor*columna_precio_unitario)
            Total_Entrada+=newValor*columna_precio_unitario
            $("#txt_totalEntrada").text(number_format(Total_Entrada, 2, ".", ","))

        }else{
            let producto= $(input).parents('tr').find("select[id*='cmb_Producto']").val();
            if(producto==null)
            {
                $(input).val("");
                alertError("favor primero seleccione un producto");
            }
            else
            {
                var oldvalor= input.oldValue;
                var newValor = input.value;
                Total_Entrada=Total_Entrada-(oldvalor*columna_cantidad)
                Total_Entrada+=newValor*columna_cantidad
                $("#txt_totalEntrada").text(number_format(Total_Entrada, 2, ".", ","))
            }
        }
    }

    /** Funcion para agregar fila */
    $(document).off("click", "#btnAgregarFila").on("click", "#btnAgregarFila", function () {

        $("#tblEntrada tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblEntrada tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblEntrada").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblEntrada tr").length;
        if (numeroFilas > 3) {
            /*----------------------------------------------------------------------------*/
            /*-----Procedimineto para calcular total entrada, si se elimina una fila-------/
            /*----------------------------------------------------------------------------*/
            let  cantidad=$(this).closest('tr').find("input[id*='txt_cantidad']").val();
            let  precio=$(this).closest('tr').find("input[id*='txt_precio']").val();

            if (cantidad!="" && cantidad!=undefined )
            cantidad=parseFloat( cantidad= cantidad.replace(/,/g, ""));
            else
            cantidad=0

            if (precio!="" && precio!=undefined )
            precio=parseFloat( precio= precio.replace(/,/g, ""));
            else
            precio=0
            Total_Entrada=Total_Entrada-(precio*cantidad)
            $("#txt_totalEntrada").text(number_format(Total_Entrada, 2, ".", ","))
            /*------------------------------------------------------------------------------/
            /**--------------------------------------------------------------------------- */
            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    /** Funcion para Guardar una entrada */
    function  GuardarEntrada()
    {
        alertConfirm("¿Está seguro que desea guardar?", function (e) {
            var guardar=true;
            /** Se recuperan datos de tabla Detalles de carga */
            var DATA1 = [];
            var TABLA = $("#tblEntrada tbody > tr");

            //obtener detalle de entrada
            TABLA.each(function (e) {
                let Cantidad = $(this).find("input[id*='txt_cantidad']").val();
                let id_producto = $(this).find("select[id*='cmb_Producto']").val();
                let precio = $(this).find("input[id*='txt_precio']").val();

                if (Cantidad !== "" && id_producto !== "" && precio) {
                    item = {};
                    item ["Cantidad"] =parseInt(Cantidad);
                    item ["id_producto"] = parseInt(id_producto);
                    item ["precio"] = parseInt(precio);
                    DATA1.push(item);
                }
                else
                {
                    guardar=false;
                    alertError("¡Por favor completar campos de nueva Entrada!");
                }

            });
            let tblEntrada = JSON.stringify(DATA1);

        if (guardar==true) {

            var _token = $('input[name=_token]').val();
            var fecha = $('#fecha_entrada').val();
            var proveedor = $('#cmb_Proveedor').val();

                if(fecha!="" && proveedor!=null)
                {
                    showLoad(true);
                    $.ajax({
                        type: 'POST',
                        url: '/guardarEntrada', //llamada a la ruta
                        data: {
                            _token:_token,
                            tblEntrada:tblEntrada,
                            fecha:fecha,
                            proveedor:proveedor,
                            monto:Total_Entrada
                        },
                        success: function (data) {

                            showLoad(false);
                            if (data.error) {
                                alertError(data.mensaje);
                            }
                            else
                            {
                                alertSuccess(data.mensaje);
                                var id=data.id_entrada;
                                $("#id_Entrada").val(id[0].id_entrada);
                                $('.deshabilitar').attr('disabled','true');
                                $('.remover').removeAttr('disabled');

                            }
                        },
                        error: function (err) {
                            alertError(err.responseText);
                            showLoad(false);
                        }

                    });
                }
                else
                    alertError("Favor completar todos los campos");
        }
    });
    }

    /** Funcion para Listar Entradas */
    function listarEntradas(){

        var _token= $('input[name=_token]').val();
        $("#tblEntradas").DataTable().destroy();

        tblEntradas = setDataTable("#tblEntradas", {
            ajax: {
                type: 'POST',
                url: '/entrada/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [{
                targets: 4,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        $estado =json[4];
                        if ($estado==1)
                            return '<span class="label success">Guardada</span>';
                        if ($estado==-1)
                            return '<span class="label danger">Anulada</span>';
                    }
                },
                {
                targets: -1,
                data: null,
                orderable: false,
                defaultContent: '<button class="btn btn-info" title="Seleccione ENtrada" onclick="selectEntrada(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
            }]
        });
    }

    /** Funcion carga valores en formulario de entrada seleccionada*/
    function selectEntrada(datos) {

        showLoad(true);
        limpiartablas()
        var _token= $('input[name=_token]').val();
        var e = tblEntradas.row($(datos).parents('tr')).data();
        id_entrada=e[0];
        valor=e[4];
        /** Recupera informacion de entrada*/
        $.ajax({
            type: 'POST',
            url: '/informacion/entrada', //llamada a la ruta
            data: {
                _token:_token,
                id_entrada:id_entrada,
            },
            success: function (data) {

                $('#fecha_entrada').val(data[0].f_entrada);
                $('#id_Entrada').val(id_entrada);
                $('#cmb_Proveedor').val(data[0].id_proveedor);
                $("#txt_totalEntrada").text(number_format(data[0].monto, 2, ".", ","))

                //solo ver modo lectura al mostrar, para evitar modificar informacion
                if(valor==1)
                {
                    $('.deshabilitar').attr('disabled','true');
                    $('.remover').removeAttr('disabled');
                }
                else
                {
                    $('.deshabilitar').attr('disabled','true');
                    $('.remover').attr('disabled','true');
                }
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });

        /** Recupera detalle de entrada*/
        $.ajax({
            type: 'POST',
            url: '/getDetalleEntrada/entrada', //llamada a la ruta
            data: {
                _token:_token,
                id_entrada:id_entrada,
            },
            success: function (response) {
                    response.forEach(cargarDetalleEntrada);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });
    }

    //funcion para agregar detalle de entrada a tabla y agregar fila
    function cargarDetalleEntrada(item, index)
    {
        if (0 == index) {
            $("#txt_cantidad").val(item['cantidad']);
            $("#cmb_Producto").val(item['id_producto']);
            $("#txt_precio").val('$'+item['precio']);
            $("#txt_Sub_precio").val('$'+item['precio']*item['cantidad']);

        } else {
            adicionarFilaCarga();
            $("#tblEntrada tbody tr:eq(" + index + ")").find("input,select,textarea").each(function () {

                if ($(this).attr("id") == "txt_cantidad") {
                    $(this).val(item['cantidad']);
                }
                if ($(this).attr("id") == "cmb_Producto") {
                    $(this).val(item['id_producto']);
                }
                if ($(this).attr("id") == "txt_precio") {
                    $(this).val('$'+item['precio']);
                }
                if ($(this).attr("id") == "txt_Sub_precio") {
                    $(this).val('$'+item['precio']*item['cantidad']);
                }
            });
        }
    }

    //funcion para agregar una fila al mostrar el detalle de entrada
    function adicionarFilaCarga() {
        $("#tblEntrada tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblEntrada tbody").find("input, select,textarea,label,div,span").val("");
    }

    //funcion para limpiar tabla y cargar nuevos dato de entrada
    function limpiartablas(){
        /** Limpia todos los inputs*/
        $('input[type="text"]').val('');
        $('input[type="date"]').val('');
        $('#txt_totalEntrada').text("0.00");
        Total_Entrada=0;
         $('select').val(""); /** Limpia todos select */
         /** Elimina todas las filas de tabla dinamica menos la primera */
        $('#tblEntrada tr').closest('.otrasFilas').remove();
    }

    /** Funcion para Anular Entrada */
    function anularEntrada(){

        var id_entrada= $('#id_Entrada').val();
        var _token = $('input[name=_token]').val();
        alertConfirm("¿Está seguro que desea anular entrada?", function (e) {
            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/entrada/anular', //llamada a la ruta
                data: {
                    _token:_token,
                    id_entrada:id_entrada
                },
                success: function (data) {
                    showLoad(false);
                    if (data.error) {
                        alertError(data.mensaje);
                    }
                    else
                    {
                        alertSuccess(data.mensaje);
                        $('#btnlimpiar').click();
                    }
                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }

            });
        });
    }

    /** Funcion para agregar un producto desde Entradas */
    function agregarProductoEntrada()
    {
        var checkbox2=document.getElementById('ck_iva');
        $('#txt_nombre_p_entrada,#txt_precio_p_entrada,#txt_descripcion_p_entrada').val("");
        if (checkbox2.checked == true)
                $('#ck_iva').click();
        /** Configuraciones para subir imagen */
        /** Funcion que permite actualizar o agregar un nuevo registro */
        Dropzone.discover(

            Dropzone.options.imageUpload = {
                autoProcessQueue: false,//Para evitar que guarde en el servidor
                uploadMultiple: true,
                parallelUploads: 3,
                maxFiles: 3, //archivos permitidos
                addRemoveLinks: true, //Botton eliminar
                acceptedFiles:'.jpeg,.jpg,.png,.gif',
                init: function() {

                    var myDropzone = this;

                    document.getElementById('btnGuardarProductoEntrada').addEventListener("click", function(e) {

                        var nombre_e_p= $('#txt_nombre_p_entrada').val();
                        var precio= $('#txt_precio_p_entrada').val();
                        var descripcion= $('#txt_descripcion_p_entrada').val();

                        if (nombre_e_p!=""  && precio!="" && descripcion!="" && myDropzone.files.length!=0)
                        {
                            alertConfirm("¿Está seguro que desea guardar?", function (ev) {
                                showLoad(true);
                                e.preventDefault();
                                e.stopPropagation();
                                myDropzone.processQueue();
                            });
                        }
                        else
                            alertError("Favor completar campos y/o añadir imagenes");

                    });
                    /** Recupera respuesta si es exitosa*/
                    this.on("successmultiple", function(files, response) {
                        showLoad(false);
                        alertSuccess(response.mensaje);
                        this.removeAllFiles();//elimina imagenes en dropzone

                        var name=$('#txt_nombre_p_entrada').val();
                        name=name.toUpperCase();
                        var datos;
                        var id=response.id_producto_nuevo_entrada;
                        datos += '<option  value="' + id[0].id_producto + '">' + name  + '</option>';
                        //asignar nuevo producto en lista cmb_Producto
                        var TABLA = $("#tblEntrada tbody > tr");
                        TABLA.each(function (e) {
                            let Cantidad = $(this).find('#cmb_Producto')
                            Cantidad.append(datos);
                        });
                        limpiarModalProducto();
                        $('#btn_close_ventana').click();

                    });

                    /** Recupera respuesta si es fallida*/
                    this.on("errormultiple", function(files, response) {
                        alertError(response.mensaje);
                    });

                    /**Valida que no sea mas de 3 archivos */
                    this.on("maxfilesexceeded", function(file){
                        alertError("Excedio el limite de imagenes, imagenes permitidas 3")
                    });

                },
                maxfilesexceeded: function (files) {
                    this.removeFile(files); //Remueve el archivo (Imagen) si execede el limite permitido
                },
            }
        ); //Rastrea el documento
    }

    /** Funcion para limpiar modal de agregar producto */
    function limpiarModalProducto()
    {
        $("#txt_nombre_p_entrada,#txt_precio_p_entrada,#txt_descripcion_p_entrada").val("");
    }

var tblFacturas=null;
var Total=0;
var TotalCordoba=0;
var SubTotal=0;
var Descuento=0;
var Iva=0;


    $(document).ready(function(){

        showLoad(true);
        var _token= $('input[name=_token]').val();

        /** recupera clientes*/
        $.ajax({
            type: 'POST',
            url: '/getClientes', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {


                $('#cmb_Cliente').select2({ width:"100%", height: "40px"})
                $('#cmb_Cliente').empty();

                var datos = '<option selected disabled value ="">Seleccione</option>';
                data.forEach(element => {
                    datos += '<option  value="' + element.id_cliente + '">' + element.nombre + '</option>';
                });

                $('#cmb_Cliente').append(datos);
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
            url: '/getProductos', //llamada a la ruta
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


    /** Funcion para Listar ventas */
    function listarVentas(){

        var _token= $('input[name=_token]').val();
        $("#tblFacturas").DataTable().destroy();

        tblFacturas = setDataTable("#tblFacturas", {
            ajax: {
                type: 'POST',
                url: '/getVentas', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [{
                targets: 2,
                data: null,
                orderable: false,
                render: function (json) {
                    $estado =json[2];
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
                    render: function (json) {

                        if (json[2] == 1) {
                            return '<i title="Anular factura"  class=" btn btn-danger fa fa-trash-o" onclick="anularFacturaProducto(this)" id="btnAnularFactura">Anular</i>'
                        }
                        else
                            return ' ';
                    }
                }]
        });
    }


    function  validarNoFactura(input)
    {
        var _token= $('input[name=_token]').val();
        var codigoFactura=input.value;


        if (codigoFactura!="")
        {
            $.ajax({
                type: 'POST',
                url: '/getNoFactura', //llamada a la ruta
                data: {
                    _token:_token,
                    codigoFactura:codigoFactura
                },
                success: function (data) {

                    if (Object.entries(data).length!=0)
                    {
                        alertError("Ya existe una factura con el numero proporsionado, emitida el "+data[0].fecha_emision);
                        input.value="";
                    }
                    showLoad(false);
                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }

            });
        }

    }

    /** Funcion para calcular importes*/
    function importe(e, input) {

            let producto= $(input).parents('tr').find("select[id*='cmb_Producto']").val();
            if(producto==null)
            {
                $(input).val("");
                alertError("favor primero seleccione un producto");
            }
            else
            {
                let precio= $(input).parents('tr').find("input[id*='txt_precio']");
                var valor= precio.val();/** Captura el nuevo valor del input*/
                if (valor!="" && valor!=undefined )
                    valor=parseFloat( valor= valor.replace(/,/g, "")); /**Formate numero */
                else
                    valor=0

                /** Recupera valores de la cantidad de productos*/

                var  producto_actual=input.value;
                if (producto_actual!="" && producto_actual!=undefined )
                    producto_actual=parseFloat( producto_actual= producto_actual.replace(/,/g, "")); /**Formate numero */
                else
                    producto_actual=0

                var importe_new=producto_actual*valor;
                $(input).parents('tr').find("input[id*='txt_importe']").val(importe_new);

                SubTotal=0;
                var TABLA= $("#tblDetalleProductos tbody > tr");
                /*Obtención de datos de la tabla dinámica*/
                TABLA.each(function (e) {

                    let importe = $(this).find("input[id*='txt_importe']").val();


                    if (importe!="")
                        importe=parseFloat( importe= importe.replace(/,/g, "")); /**Formate numero */
                    else
                        importe=0

                    SubTotal+=importe;
                });


                var tasa_cambio=$('#lbl_tasa_cambio').text();
                calcularIva();
                Total=SubTotal+Iva-Descuento
                TotalCordoba=Total*parseFloat(tasa_cambio)

                $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
                $('#txt_iva').text(number_format(Iva, 2, ".", ","));
                $('#txt_totalPr').text(number_format(SubTotal, 2, ".", ","));
                $('#txt_total').text(number_format(Total, 2, ".", ","));
                $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));
            }
    }

    /** Funcion para recuperar precio de un producto */
    function changeProducto(e, select)
    {

        var id_producto=select.value;
        var _token= $('input[name=_token]').val();

        var TABLA= $("#tblDetalleProductos tbody > tr");
        producto=0;
        TABLA.each(function (e) {

            let prod = $(this).find("select[id*='cmb_Producto']").val();

            if (id_producto==prod)
            {
                producto++;
            }

            if (producto>1)
            {
                select.value=""
                alertError("El producto ya existe en la factura")
                $(this).find("select[id*='txt_precio']").trigger("focus")
                $(this).find("select[id*='txt_precio']").trigger("change")
            }

        });


        // Obtener contenedor desde el elemento que cambió
        let fila = $(e.target).closest('tr');
        $(fila).find("#txt_cantidad").val("");

        if (select.value!="")
        {
            $.ajax({
                type: 'POST',
                url: '/producto/precio', //llamada a la ruta
                data: {
                    _token:_token,
                    id_producto:id_producto
                },
                success: function (data) {

                    $(fila).find("#txt_precio").trigger("focus") //desencadena evento
                    $(fila).find("#txt_precio").val(data[0].precio);
                    $(fila).find("#txtIva").val(data[0].iva);
                    $(fila).find("#txt_precio").trigger("change")

                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }

            });
        }


    }

    function  changeDescuento(select)
    {

        Total=Total+Descuento
        Descuento=0
        var descuento= select.value
        var tasa_cambio=$('#lbl_tasa_cambio').text();

        tasa_cambio=parseFloat(tasa_cambio);
        if (descuento!=0)
            Descuento=SubTotal*parseFloat(descuento);

        Total=Total-Descuento
        TotalCordoba=Total*tasa_cambio

        $('#txt_descuento').text(number_format(Descuento, 2, ".", ","));
        $('#txt_total').text(number_format(Total, 2, ".", ","));
        $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));
    }

    function olvaluePrecio(element){
        element.setAttribute("oldvalue",element.oldValue);
    }

    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFila").on("click", "#btnAdicionarFila", function () {

        $("#tblDetalleProductos tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleProductos tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleProductos").on('click', '.eliminarFila', function () {

        var tasa_cambio=$('#lbl_tasa_cambio').text();
        var numeroFilas = $("#tblDetalleProductos tbody tr").length;
        if (numeroFilas > 1) {

            /************ Funcion para calcular presupuesto si es eliminado una fila ************* */

            let  precio=$(this).closest('tr').find("input[id*='txt_precio']").val();
            let  cantidad=$(this).closest('tr').find("input[id*='txt_cantidad']").val();
            var descuento= $('#cmb_descuento').val();

            if (precio!="" && precio!=undefined )
                precio=parseFloat( precio= precio.replace(/,/g, ""));
            else
                precio=0

            if (cantidad!="" && cantidad!=undefined )
                cantidad=parseFloat( cantidad= cantidad.replace(/,/g, ""));
            else
                cantidad=0
            $(this).closest('tr').remove();
            calcularIva();

            var importe=cantidad*precio;

            SubTotal=SubTotal-importe
            if (descuento!=0)
                Descuento=SubTotal*parseFloat(descuento);

            if (descuento==null)
                Descuento=0;

            Total=SubTotal+Iva-Descuento
            TotalCordoba=Total*parseFloat(tasa_cambio)


            $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_descuento').text(number_format(Descuento, 2, ".", ","));
            $('#txt_iva').text(number_format(Iva, 2, ".", ","));
            $('#txt_totalPr').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));
            $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));

            /*********************************  *****************  **********************************/
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });


    /** Funcion para verificar la existencia de un producto */
    function  validarExistencia(input)
    {

        let producto= $(input).parents('tr').find("select[id*='cmb_Producto']").val();
        var _token= $('input[name=_token]').val();

        if (producto!=null && producto!="")
        {
            $.ajax({
                type: 'POST',
                url: '/factura/existencia', //llamada a la ruta
                data: {
                    _token:_token,
                    producto:producto
                },
                success: function (data) {
                    if(data[0].existencia<input.value)
                    {
                        input.value="";
                        alertError("Error la cantidad en existencia es igual a "+data[0].existencia);
                    }
                    calcularIva()

                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }

            });
        }

    }

    function GenerarFactura()
    {
        let guardar=true;

        alertConfirm("¿Está seguro que desea Generar factura?", function (e) {

            /** Se recuperan datos de tabla servicios adicionales*/
            var DATA = [];
            var TABLA= $("#tblDetalleProductos tbody > tr");

            /*Obtención de datos de la tabla dinámica*/
            TABLA.each(function (e) {

                let producto = $(this).find("select[id*='cmb_Producto']").val();
                let precio = $(this).find("input[id*='txt_precio']").val()
                let cantidad = $(this).find("input[id*='txt_cantidad']").val();

                if (producto!="" && producto!=null && cantidad!="" )
                {
                        item = {};
                        item["producto"] =parseInt(producto);
                        precio=parseFloat( precio= precio.replace(/,/g, "")); /**Formate numero */
                        item["monto"] =precio;
                        item["cantidad"] =parseInt(cantidad);
                        DATA.push(item);
                }
                else
                {
                    alertError("Favor completar datos de productos");
                     guardar=false;
                }


            });

            let tblDetalleProductos = JSON.stringify(DATA);

            if (guardar==true)
            {
                var clienteVAL=$('#cmb_Cliente').parsley();
                var codigoFacturaVAL=$('#txt_codigoFactura').parsley();
                var monedaVAL=$('#cmb_moneda').parsley();
                var descuentoVAL=$('#cmb_descuento').parsley();
                var tipo_VAL=$('#cmb_tipo').parsley();


                if (codigoFacturaVAL.isValid() && monedaVAL.isValid() && descuentoVAL.isValid() && tipo_VAL.isValid())
                {
                    var tipo = $('#cmb_tipo').val();
                    tipo=parseInt(tipo);
                    var termino = $('#txt_termino').val();
                    var termino_VAL=$('#txt_termino').parsley();

                    if (tipo==2 && termino.trim()=="")
                    {
                        termino_VAL.validate();
                        alertError("Favor especificar termino");
                    }
                    else
                    {
                        if (clienteVAL.isValid())
                        {
                                var cliente=$('#cmb_Cliente').val();
                                var codigoFactura=$('#txt_codigoFactura').val();
                                var moneda=$('#cmb_moneda').val();

                              Guardar(cliente,codigoFactura,moneda,tblDetalleProductos,termino,tipo);
                        }
                        else
                        {
                            var checkbox=document.getElementById('ckComun');
                            if(checkbox.checked==true)
                            {

                                var cliente=$('#cmb_Cliente').val();
                                var codigoFactura=$('#txt_codigoFactura').val();
                                var moneda=$('#cmb_moneda').val();

                                Guardar(cliente,codigoFactura,moneda,tblDetalleProductos,termino,tipo);
                            }
                            else
                                alertError("Favor seleccione un cliente o de check en 'Comun' si es un cliente comun")
                        }

                    }
                }
                else
                {
                    codigoFacturaVAL.validate();
                    monedaVAL.validate();
                    descuentoVAL.validate();
                    tipo_VAL.validate();
                    alertError("Favor completar Datos");
                }
            }
        });

    }

    function Guardar(cliente,codigoFactura,moneda,tblDetalleProductos,termino,tipo)
    {
        var _token= $('input[name=_token]').val();
        showLoad(true);
        $.ajax({
            type: 'POST',
            url: '/factura/guardar', //llamada a la ruta
            data: {
                _token: _token,
                tblDetalleProductos: tblDetalleProductos,
                termino: termino.trim(),
                tipo: tipo,
                codigoFactura:codigoFactura,
                descuento:Descuento,
                total:Total,
                subTotal:SubTotal,
                iva:Iva,
                moneda:moneda,
                cliente:cliente
            },
            success: function (data) {

                if (data.error) {
                    alertError(data.mensaje);
                } else {
                    alertSuccess(data.mensaje);
                    alertSuccess("Generando Factura ...");

                   $.ajax({
                        type:"post",
                        url: '/productos/factura', //llamada a la ruta
                        global:false,
                        data:{
                            _token:_token,
                            codigoFactura:codigoFactura
                        }
                    })
                        .done(function(data,textstatus,jqXHR )
                        {
                            showLoad(false);
                            var nombrelogico="pdf"
                            var parametros="dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=80,screenY=80,width=900,height=1400";
                            var htmltext="<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(data) +"'></enbed>";
                            var detailwindows= window.open("",nombrelogico,parametros);
                            if(detailwindows==null)
                            {
                                alertError("No se puede mostrar PDF, ventana emergente bloqueada.");
                                alertError("Click en 🔒 para habilitar ventana emergente.");
                            }
                            else
                            {
                                detailwindows.document.write(htmltext);
                                detailwindows.document.close();
                            }
                            $('#btnlimpiar').click();
                            showLoad(false);
                        });
                }
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }
        });

    }

    function anularFacturaProducto(datos)
    {
        var dt = tblFacturas.row($(datos).parents('tr')).data();
        var  factura= dt[1];
        var _token= $('input[name=_token]').val();

        alertConfirm("Esta seguro de anular factura?", function (e){
            showLoad(true);
            $.ajax({
                type:'POST',
                url: '/factura/anular',
                data:{
                    _token:_token,
                    factura:factura
                },
                success: function(data){
                    showLoad(false);
                    if(data.error){
                        alertError(data.mensaje);
                    }
                    else{
                        alertSuccess(data.mensaje);
                        tblFacturas.ajax.reload();
                    }
                },
                error: function(err){
                    alertError(err.responseText);
                    showLoad(false);
                }
            });

        });

    }

    function calcularIva()
    {
        var TABLA= $("#tblDetalleProductos tbody > tr");

        Iva=0;
        TABLA.each(function (e) {

            let iva = $(this).find("input[id*='txtIva']").val();

            if (iva=="true")
            {
                let precio = $(this).find("input[id*='txt_precio']").val()
                let cantidad = $(this).find("input[id*='txt_cantidad']").val();


                if (cantidad!="" && cantidad!=undefined )
                    cantidad=parseFloat( cantidad= cantidad.replace(/,/g, "")); /**Formate numero */
                else
                    cantidad=0

                Iva+=cantidad*parseFloat(precio)*0.15;
            }


        });

    }






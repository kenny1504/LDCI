var tblFacturas=null;
var Total=0;
var TotalCordoba=0;
var SubTotal=0;
var Descuento=0;
var Iva=0;


    $(document).ready(function(){

        showLoad(true);
        var _token= $('input[name=_token]').val();

        /** recupera proveedores*/
        $.ajax({
            type: 'POST',
            url: '/getClientes', //llamada a la ruta
            data: {
                _token:_token
            },
            success: function (data) {


                $('#cmb_Cliente').select2({  height: "40px"})
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
                targets: 4,
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
                    defaultContent: '<button class="btn btn-info" title="Seleccione Venta" onclick="selectEntrada(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
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

                var tasa_cambio=$('#lbl_tasa_cambio').text();

                /** Recupera valores de la cantidad de productos*/

                var  producto_actual=input.value;
                if (producto_actual!="" && producto_actual!=undefined )
                    producto_actual=parseFloat( producto_actual= producto_actual.replace(/,/g, "")); /**Formate numero */
                else
                    producto_actual=0

                var  producto_old=input.oldValue;
                if (producto_old!="" && producto_old!=undefined )
                    producto_old=parseFloat( producto_old= producto_old.replace(/,/g, "")); /**Formate numero */
                else
                    producto_old=0
                /********* +++++++++++++++++++++++ ************/


                var importe_old=producto_old*valor;
                var importe_new=producto_actual*valor;

                SubTotal=SubTotal-importe_old
                SubTotal+=importe_new
                Iva=SubTotal*0.15
                Total=SubTotal+Iva-Descuento
                TotalCordoba=Total*parseFloat(tasa_cambio)

                $(input).parents('tr').find("input[id*='txt_importe']").val(importe_new);
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

        // Obtener contenedor desde el elemento que cambió
        let fila = $(e.target).closest('tr');

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
                $(fila).find("#txt_precio").trigger("change")


                let precio= $(select).parents('tr').find("input[id*='txt_precio']");
                let producto= $(select).parents('tr').find("input[id*='txt_cantidad']");
                var oldvalue=  precio[0].attributes.oldvalue.nodeValue /** Captura el anterior valor del input */
                var valor= precio.val();/** Captura el nuevo valor del input*/

                if (valor!="" && valor!=undefined )
                    valor=parseFloat( valor= valor.replace(/,/g, "")); /**Formate numero */
                else
                    valor=0

                if (oldvalue!="" && oldvalue!=undefined )
                    oldvalue=parseFloat( oldvalue= oldvalue.replace(/,/g, ""));
                else
                    oldvalue=0

                var tasa_cambio=$('#lbl_tasa_cambio').text();

                /** Recupera valores de la cantidad de productos*/

                var  producto_actual=producto.val();
                if (producto_actual!="" && producto_actual!=undefined )
                    producto_actual=parseFloat( producto_actual= producto_actual.replace(/,/g, "")); /**Formate numero */
                else
                    producto_actual=0

                /********* +++++++++++++++++++++++ ************/


                var importe_old=producto_actual*oldvalue;
                var importe_new=producto_actual*valor;

                SubTotal=SubTotal-importe_old
                SubTotal+=importe_new
                Iva=SubTotal*0.15
                Total=SubTotal+Iva-Descuento
                TotalCordoba=Total*parseFloat(tasa_cambio)

                $(select).parents('tr').find("input[id*='txt_importe']").val(importe_new);
                $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
                $('#txt_iva').text(number_format(Iva, 2, ".", ","));
                $('#txt_totalPr').text(number_format(SubTotal, 2, ".", ","));
                $('#txt_total').text(number_format(Total, 2, ".", ","));
                $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));


            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

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

            if (precio!="" && precio!=undefined )
                precio=parseFloat( precio= precio.replace(/,/g, ""));
            else
                precio=0

            if (cantidad!="" && cantidad!=undefined )
                cantidad=parseFloat( cantidad= cantidad.replace(/,/g, ""));
            else
                cantidad=0

            var importe=cantidad*precio;

            SubTotal=SubTotal-importe
            Iva=SubTotal*0.15
            Total=SubTotal+Iva-Descuento
            TotalCordoba=Total*parseFloat(tasa_cambio)


            $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_iva').text(number_format(Iva, 2, ".", ","));
            $('#txt_totalPr').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));
            $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));

            /*********************************  *****************  **********************************/

            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });



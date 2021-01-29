var tblCotizaciones = null;
var id_flete=null
var id_cotizacion=null
var Total=0;
var TotalCordoba=0;
var SubTotal=0;
var Descuento=0;
var Micelaneos=0;
var Iva=0;
var codCliente=null; /** Guarda el codigo del pais del cliente */
var codConsig=null; /** Guarda el codigo del pais del consignatario */

$(document).ready(function () {

    var _token= $('input[name=_token]').val();
    showLoad(true);

    /** recupera tipos de transporte*/
    $.ajax({
        type: 'POST',
        url: '/transporte/getAll', //llamada a la ruta
        data: {
            _token:_token
        },
        success: function (data) {

            $('#cmb_transporte').empty();

            var datos = '<option selected disabled value ="">Seleccione</option>';
            data.forEach(element => {
                datos += '<option  value="' + element.id_tipo_transporte + '">' + element.nombre + '</option>';
            });

            $('#cmb_transporte').append(datos);
            showLoad(false);
        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }

    });

});

    /** Funcion que lista las cotizaciones hechas */
    function listarCotizaciones() {

        /** Limpia datatable para evitar error " Cannot reinitialise DataTable"  */
        table = $('#tblCotizaciones').DataTable().destroy();
        var _token= $('input[name=_token]').val();

        tblCotizaciones = setDataTable("#tblCotizaciones", {
            ajax: {
                type: 'POST',
                url: '/factura/cotizaciones', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs:[
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        $estado =json[5];
                        if ($estado==4)
                            return '<span class="label primary">Tramite</span>';
                        if ($estado==5)
                            return '<span class="label default">Impresa</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<button class="btn btn-info" title="Selecciona el registro" onclick="selectCotizacion(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
                }
            ]
        });

    }


    /** funcion para cargar datos de cotizacion */
    function selectCotizacion(datos)
    {

        showLoad(true);
        var _token= $('input[name=_token]').val();
        var dt = tblCotizaciones.row($(datos).parents('tr')).data();
        id_cotizacion=dt[0];

        /** Recupera encabezado*/
        $.ajax({
            type: 'POST',
            url: '/factura/EncabezadoCotizaciones', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion
            },
            success: function (data) {

                limpiartablas();
                $("#btnGenerar ").removeAttr("disabled", "disabled");
                /** Busca codigos de pais en arreglo de objeto */
                codCliente=allCountries.find( paises => paises.iso2 === data[0].telcliente );
                codConsig=allCountries.find( paises => paises.iso2 === data[0].telconsignatario );

                id_flete=data[0].id_flete;
                Total=data[0].total;
                Total=parseFloat( Total= Total.replace(/,/g, ""));
                SubTotal=data[0].subtotal
                SubTotal=parseFloat( SubTotal= SubTotal.replace(/,/g, ""));
                Iva=data[0].iva
                Iva=parseFloat( Iva= Iva.replace(/,/g, ""));
                var tasa_cambio=$('#lbl_tasa_cambio').text();
                TotalCordoba=Total*parseFloat(tasa_cambio)

                $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
                $('#txt_iva').text(number_format(Iva, 2, ".", ","));
                $('#txt_total').text(number_format(Total, 2, ".", ","));
                $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));
                $('#id_cotizacion').val(id_cotizacion);
                $('#txt_nombreCliente').val(data[0].cliente);
                $('#txt_fecha').val(data[0].fecha);
                $('#txt_destino').val(data[0].destino);
                $('#txt_origen').val(data[0].origen);
                $('#cmb_transporte').val(data[0].id_tipo_transporte);
                showLoad(false);

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

    /** Funcion para agregar fila */
    $(document).off("click", "#btnAdicionarFila").on("click", "#btnAdicionarFila", function () {

        $("#tblDetalleCargos tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleCargos tbody").find("input, select,textarea").val("");

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleCargos").on('click', '.eliminarFila', function () {

        var tasa_cambio=$('#lbl_tasa_cambio').text();
        var numeroFilas = $("#tblDetalleCargos tbody tr").length;
        if (numeroFilas > 1) {

            /************ Funcion para calcular presupuesto si es eliminado una fila ************* */

            let  valor=$(this).closest('tr').find("input[id*='txtmonto']").val();

            if (valor!="" && valor!=undefined )
                valor=parseFloat( valor= valor.replace(/,/g, ""));
            else
                valor=0

            SubTotal=SubTotal-Micelaneos
            Micelaneos=Micelaneos-valor
            SubTotal=SubTotal+Micelaneos
            Total=SubTotal+Iva-Descuento
            TotalCordoba=Total*parseFloat(tasa_cambio)

            $('#txt_micelaneos').text(number_format(Micelaneos, 2, ".", ","));
            $('#txt_totalMice').text(number_format(Micelaneos, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));
            $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));

            /*********************************  *****************  **********************************/

            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    /** Funcion para calcular, total,iva,y subtotal */
    function  calcularPresupuesto(input)
    {


        let calcular=false;

            /** Verifica que ingrese una descripcion*/
            let descripcion= $(input).parents('tr').find("textarea[id*='txt_descripcion']").val();
            if (descripcion.trim()=="")
            {
                $(input).val("");
                alertError("favor ingrese una descripcion");
            }
            else
                calcular=true;



        if (calcular==true)
        {
            var oldvalue=  input.oldValue /** Captura el anterior valor del input */
            var valor= input.value;/** Captura el nuevo valor del input*/

            if (valor!="" && valor!=undefined )
                valor=parseFloat( valor= valor.replace(/,/g, "")); /**Formate numero */
            else
                valor=0

            if (oldvalue!="" && oldvalue!=undefined )
                oldvalue=parseFloat( oldvalue= oldvalue.replace(/,/g, ""));
            else
                oldvalue=0

            var tasa_cambio=$('#lbl_tasa_cambio').text();

            SubTotal=SubTotal-Micelaneos
            Micelaneos=Micelaneos-oldvalue
            Micelaneos+=valor
            SubTotal=SubTotal+Micelaneos
            Total=SubTotal+Iva-Descuento
            TotalCordoba=Total*parseFloat(tasa_cambio)

            $('#txt_micelaneos').text(number_format(Micelaneos, 2, ".", ","));
            $('#txt_totalMice').text(number_format(Micelaneos, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));
            $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));
        }

    }

    function limpiartablas()
    {
         Total=0;
         TotalCordoba=0;
         SubTotal=0;
         Descuento=0;
         Micelaneos=0;
         Iva=0;

        /** Limpia todos los inputs*/
        $('input[type="text"]').val('');
        $('input[type="text"]').focus();


        $('input[type="tel"]').val('');
        $('textarea').val('');

        $('select').val(""); /** Limpia todos select */
       $('#txt_subtotal,#txt_iva,#txt_total,#txt_micelaneos,#txt_descuento,#txt_total_corboba').text("0.00");
        /** Elimina todas las filas de tabla dinamica menos la primera */
        $('#tblDetalleCargos tr').closest('.otrasFilas').remove();
    }

    /** Funcion para generar factura de una cotizacion */
    function generar()
    {
        let guardar=true;
        var _token= $('input[name=_token]').val();

        alertConfirm("¿Está seguro que desea Generar factura?", function (e) {

            /** Se recuperan datos de tabla servicios adicionales*/
            var DATA = [];
            var TABLA= $("#tblDetalleCargos tbody > tr");

            /*Obtención de datos de la tabla dinámica*/
            TABLA.each(function (e) {

                let descripcion = $(this).find("textarea[id*='txt_descripcion']").val();
                let monto = $(this).find("input[id*='txtmonto']").val();
                if (descripcion.trim()!="")
                {

                    if (monto!="")
                    {
                        item = {};
                        item["descripcion"] =descripcion;
                        precio=parseFloat( monto= monto.replace(/,/g, "")); /**Formate numero */
                        item["monto"] =precio;
                        DATA.push(item);
                    }
                    else
                    {
                        alertError("Favor ingrese el monto del cargo");
                        monto.focus(); guardar=false;
                    }

                }

            });

            let tblDetalleCargos = JSON.stringify(DATA);

            if (guardar==true)
            {
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
                        var codigoFactura=$('#txt_codigoFactura').val();
                        var moneda=$('#cmb_moneda').val();

                      showLoad(true);
                        $.ajax({
                            type: 'POST',
                            url: '/Generarfactura/cotizacion', //llamada a la ruta
                            data: {
                                _token: _token,
                                tblDetalleCargos: tblDetalleCargos,
                                termino: termino.trim(),
                                tipo: tipo,
                                id_flete: id_flete,
                                id_cotizacion:id_cotizacion,
                                codigoFactura:codigoFactura,
                                descuento:Descuento,
                                total:Total,
                                micelaneos:Micelaneos,
                                moneda:moneda
                            },
                            success: function (data) {

                                if (data.error) {
                                    alertError(data.mensaje);
                                } else {
                                    alertSuccess(data.mensaje);
                                    alertSuccess("Generando Factura ...");

                                    $.ajax({
                                        type:"post",
                                        url: '/cotizaciones/factura', //llamada a la ruta
                                        global:false,
                                        data:{
                                            _token:_token,
                                            id_cotizacion: id_cotizacion,
                                            codConsig: codConsig.dialCode,
                                            codCliente: codCliente.dialCode
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
                                        });
                                }
                            },
                            error: function (err) {
                                alertError(err.responseText);
                                showLoad(false);
                            }
                        });
                    }
                }
                else
                {
                    codigoFacturaVAL.validate();
                    monedaVAL.validate();
                    descuentoVAL.validate();
                    tipo_VAL.validate();
                    alertError("Favor completar Datos")
                }
            }
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




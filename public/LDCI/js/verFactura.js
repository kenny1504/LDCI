
var tblFacturas = null;

    $(document).ready(function () {

        var _token= $('input[name=_token]').val();
        showLoad(true);

        tblFacturas = setDataTable("#tblFacturas", {
            ajax: {
                type: 'POST',
                url: '/getFacturas', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs:[
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    render: function (json) {

                        if (json[9]==1)
                        {
                            if(tipoUsuario==1 || tipoUsuario==2 )
                            {
                                return '<i title="Anular factura"  class=" btn btn-danger fa fa-trash-o" onclick="anularFactura(this)" id="btnAnularFactura">Anular</i>'+
                                       '<i title="Imprimir factura" class=" btn btn-info fa  fa-file-pdf-o" onclick="rpt_factura(this)">PDF</i>'

                            }
                            else
                                return '<i title="Imprimir factura" class=" btn btn-info fa  fa-file-pdf-o" onclick="rpt_factura(this)">PDF</i>'

                        }
                        else
                        {
                            if(tipoUsuario==1 || tipoUsuario==2 )
                            {
                                return '<i title="Anular factura"  class=" btn btn-danger fa fa-trash-o" onclick="anularFacturaProducto(this)" id="btnAnularFactura">Anular</i>'+
                                    '<i title="Imprimir factura" class=" btn btn-info fa  fa-file-pdf-o" onclick="rpt_factura_productos(this)">PDF</i>'

                            }
                            else
                                return '<i title="Imprimir factura" class=" btn btn-info fa  fa-file-pdf-o" onclick="rpt_factura_productos(this)">PDF</i>'


                        }

                    }
                },
                {
                    targets: [ 7,8,9 ],
                    visible: false
                }
            ]
        });

        /** se ejecuta despues que la tabla cargo datos, GIF CARGANDO */
        $('#tblFacturas').DataTable().on("draw", function(){
            showLoad(false);
        })

    });

    /** Funcion que genera reporte */
    function rpt_factura(datos)
    {
        var dt = tblFacturas.row($(datos).parents('tr')).data();
        var  id_cotizacion= dt[1];
        var  codClient=codClient=allCountries.find( paises => paises.iso2 === dt[7] );
        var  codConsi=codConsi=allCountries.find( paises => paises.iso2 === dt[8] );

        showLoad(true);
        var _token= $('input[name=_token]').val();

        $.ajax({
            type:"post",
            url: '/cotizaciones/factura', //llamada a la ruta
            global:false,
            data:{
                _token:_token,
                id_cotizacion: id_cotizacion,
                codConsig: codClient.dialCode,
                codCliente: codConsi.dialCode
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

    function anularFactura(datos)
    {
        var dt = tblFacturas.row($(datos).parents('tr')).data();
        var  id_cotizacion= dt[1];
        var  factura= dt[0];
        var _token= $('input[name=_token]').val();

        alertConfirm("Esta seguro de anular factura?", function (e){
            showLoad(true);
            $.ajax({
                type:'POST',
                url: '/facturaCotizacion/anular',
                data:{
                    _token:_token,
                    id_cotizacion:id_cotizacion,
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

    function anularFacturaProducto(datos)
    {
        var dt = tblFacturas.row($(datos).parents('tr')).data();
        var  factura= dt[0];
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

    /** Funcion que genera reporte */
    function rpt_factura_productos(datos)
    {
        var dt = tblFacturas.row($(datos).parents('tr')).data();
        var  codigoFactura= dt[0];

        showLoad(true);
        var _token= $('input[name=_token]').val();

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
            });
    }


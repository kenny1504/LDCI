
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
                    defaultContent: '<i title="Imprimir factura" class=" btn btn-info fa  fa-file-pdf-o" onclick="rpt_factura(this)">PDF</i>'
                },
                {
                    targets: [ 7,8 ],
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
                var nombrelogico="pdf"
                var parametros="dependent=yes,locationbar=no,scrollbars=yes,menubar=yes,resizable,screenX=80,screenY=80,width=900,height=1400";
                var htmltext="<embed width=100% height=100% type='application/pdf' src='data:application/pdf,"+escape(data) +"'></enbed>";
                var detailwindows= window.open("",nombrelogico,parametros);
                detailwindows.document.write(htmltext);
                detailwindows.document.close();
                showLoad(false);
                $('#btnlimpiar').click();
            });
    }

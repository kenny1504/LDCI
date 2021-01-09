var tblCotizaciones = null;
var Total=0;
var TotalCordoba=0;
var SubTotal=0;
var Descuento=0;
var Micelaneos=0;
var Iva=0;

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
                id_cotizacion:id_cotizacion,
            },
            success: function (data) {

                Total=data[0].total
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
            $('#txt_total').text(number_format(Total, 2, ".", ","));
            $('#txt_total_corboba').text(number_format(TotalCordoba, 2, ".", ","));
        }

    }

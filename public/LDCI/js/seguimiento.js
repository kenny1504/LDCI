var tblCotizaciones = null;
var Estado=null;
var tblClientes=null;
var tblProveedores = null;
var id_cotizacion=null;
var id_remitente=null;
var id_consignatario=null;
var id_proveedor=null;
var Total=0;
var SubTotal=0;
var Iva=0;


    var input = document.querySelector("#txt_telefonoRemitente");
    selectR = window.intlTelInput(input, {
        allowDropdown: true,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        formatOnDisplay: false,
        geoIpLookup: function(callback) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        setNumber:351,
        utilsScript: "LDCI/Core/utils.js",
    });

    var input = document.querySelector("#txt_telefonoConsignatario");
    selectC = window.intlTelInput(input, {
        allowDropdown: true,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        formatOnDisplay: false,
        geoIpLookup: function(callback) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        setNumber:351,
        utilsScript: "LDCI/Core/utils.js",
    });

    var input = document.querySelector("#txt_telefonoProveedor");
    selectP = window.intlTelInput(input, {
        allowDropdown: true,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        formatOnDisplay: false,
        geoIpLookup: function(callback) {
            $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        hiddenInput: "full_number",
        initialCountry: "auto",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: true,
        setNumber:351,
        utilsScript: "LDCI/Core/utils.js",
    });

    $(document).ready(function () {

        showLoad(true);
        var _token= $('input[name=_token]').val();

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

    });


    /** Funcion que lista las cotizaciones hechas */
    function listarCotizaciones() {

        /** Limpia datatable para evitar error " Cannot reinitialise DataTable"  */
        table = $('#tblCotizaciones').DataTable().destroy();
        var _token= $('input[name=_token]').val();

        tblCotizaciones = setDataTable("#tblCotizaciones", {
            ajax: {
                type: 'POST',
                url: '/cotizaciones/getAll', //llamada a la ruta
                data: {
                    _token:_token,
                    estado:0
                },
            },
            columnDefs:[
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        $estado =json[5];
                        if ($estado==-1)
                            return '<span class="label danger">Rechazada</span>';
                        if ($estado==1)
                            return '<span class="label info">Nueva</span>';
                        if ($estado==2)
                            return '<span class="label warning">Revisada</span>';
                        if ($estado==3)
                            return '<span class="label success">Aprobada</span>';
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

            /************ Funcion para calcular presupuesto si es eliminado una fila ************* */

            let  valor=$(this).closest('tr').find("input[id*='txtprecioCargar']").val();

            if (valor!="" && valor!=undefined )
              valor=parseFloat( valor= valor.replace(/,/g, ""));
            else
              valor=0

            SubTotal=SubTotal-valor
            Iva=SubTotal*0.15
            Total=SubTotal+Iva

            $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_iva').text(number_format(Iva, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));

            /*********************************  *****************  **********************************/

            $(this).closest('tr').remove();
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    /** Funcion para eliminar fila */
    $("#tblDetalleServicios").on('click', '.eliminarFila', function () {

        var numeroFilas = $("#tblDetalleServicios tr").length;
        if (numeroFilas > 2) {

            /************ Funcion para calcular presupuesto si es eliminado una fila ************* */

            let  valor=$(this).closest('tr').find("input[id*='txtPrecioServicio']").val();

            if (valor!="" && valor!=undefined )
                valor=parseFloat( valor= valor.replace(/,/g, ""));
            else
                valor=0

            SubTotal=SubTotal-valor
            $(this).closest('tr').remove();
            calcularIva();
            Total=SubTotal+Iva

            $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_iva').text(number_format(Iva, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));

            /*********************************  *****************  **********************************/
        } else {
            alertError("¡Esta fila no puede ser eliminada!");
        }

    });

    /** funcion para cargar datos de cotizacion */
    function selectCotizacion(datos)
    {

        showLoad(true);
        limpiartablas()
        var _token= $('input[name=_token]').val();
        var dt = tblCotizaciones.row($(datos).parents('tr')).data();
        id_cotizacion=dt[0];

        /** Recupera encabezado*/
        $.ajax({
            type: 'POST',
            url: '/getEncabezado/cotizacion', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (data) {

                Estado=data[0].estado;
                if(Estado>2)
                    CargarDatosFlete()
                $('#cmb_estado').val(data[0].estado);
                $('#cmb_estado').change();
                $("#btnimprimir ").removeAttr("disabled", "disabled");

                if(Estado!=-1)
                    $("#btnGuardar ").removeAttr("disabled", "disabled");
                else
                    $("#btnGuardar ").attr("disabled", "disabled");

                if(Estado==5 )
                    $("#btnGuardar ").attr("disabled", "disabled");

                /** Solo se puede editar informacion de cargar y servicio cuando esten en estado NUEVA o REVISADA  */
                if(Estado==1 || Estado==2)
                {
                    $('#txt_nota_adicional').removeAttr("disabled", "disabled");
                    $("#tblDetalleServicios ").find("input,button,textarea,select").removeAttr("disabled", "disabled");
                    $("#tblDetalleCarga ").find("input,button,textarea,select").removeAttr("disabled", "disabled");
                }
                else
                {
                    $('#txt_nota_adicional').attr("disabled", "disabled");
                    $("#tblDetalleServicios ").find("input,button,textarea,select").attr("disabled", "disabled");
                    $("#tblDetalleCarga ").find("input,button,textarea,select").attr("disabled", "disabled");
                }

                $('#id_cotizacion').val(id_cotizacion);
                $('#txt_usuario').val(data[0].grabacion);
                $('#txt_vendedor').val(data[0].vendedor);
                $('#txt_fecha').val(data[0].fecha);
                $('#txt_destino').val(data[0].destino);
                $('#txt_origen').val(data[0].origen);
                $('#cmb_transporte').val(data[0].id_tipo_transporte);
                $('#txt_nota_adicional_cliente').val(data[0].nota_cliente);
                $('#txt_nota_adicional').val(data[0].nota_adicional);
                $('#txt_nota_interna').val(data[0].descripcion);
                $('#txt_enviarCorreo').val(data[0].correo);


            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** Recupera Detalle de carga*/
        $.ajax({
            type: 'POST',
            url: '/getDetalleCarga/cotizacion', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (response) {
                    response.forEach(cargarDetalleCarga);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

        /** Recupera Detalle servicio*/
        $.ajax({
            type: 'POST',
            url: '/getDetalleServicio/cotizacion', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (response) {
                response.forEach(cargarDetalleServicio);
                showLoad(false);
            },
            error: function (err) {
                showLoad(false);
                alertError(err.responseText);
            }

        });

    }

    function cargarDetalleCarga(item, index) {

        if (0 == index) {
            $("#txtCantidad").val(item['cantidad']);
                var estado =   document.getElementById('ckEstado');
                /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
                if (item['nuevo']==true)
                {
                    if (estado.checked == false)
                        $('#ckEstado').click();
                }
                else
                {
                    if (estado.checked == true)
                        $('#ckEstado').click();
                }
            $("#cmb_tipo_mercancia").val(item['id_tipo_mercancia']);
            $("#cmb_modo_transporte").val(item['id_tipo_modo_transporte']);
            $("#txt_observacion").val(item['descripcion']);
            /**Asigna 0 al valor anterior del input */
            var elem = document.getElementById('txtprecioCargar');
            elem.oldValue=0
            $("#txtprecioCargar").val(item['precio']);
            $("#txtprecioCargar").change();

        } else {
            adicionarFilaCarga();
            $("#tblDetalleCarga tbody tr:eq(" + index + ")").find("input,select,textarea").each(function () {

                if ($(this).attr("id") == "txtCantidad") {
                    $(this).val(item['cantidad']);
                }
                if ($(this).attr("id") == "ckEstado") {
                    let nuevo= $(this).parents("#tblDetalleCarga tbody > tr").find("input[id*='ckEstado']");
                    /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
                    if (item['nuevo']==true)
                    {
                        if(nuevo[0].checked==false)
                        {
                            $(this).click();
                        }
                    }
                    else
                    {
                        if(nuevo[0].checked == true)
                        {
                            $(this).click();
                        }
                    }
                }
                if ($(this).attr("id") == "cmb_tipo_mercancia") {
                    $(this).val(item['id_tipo_mercancia']);
                }
                if ($(this).attr("id") == "cmb_modo_transporte") {
                    $(this).val(item['id_tipo_modo_transporte']);
                }
                if ($(this).attr("id") == "txt_observacion") {
                    $(this).val(item['descripcion']);
                }
                if ($(this).attr("id") == "txtprecioCargar") {
                    $(this).val(item['precio']);
                    $(this).change();
                }

            });
        }
    }

    /**Metodo para añadir fila a tabla Detalle Carga */
    function adicionarFilaCarga() {
        $("#tblDetalleCarga tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleCarga tbody").find("input, select,textarea,label,div,span").val("");
    }

    function cargarDetalleServicio(item, index) {

        if (0 == index) {

            $("#cmb_servicio").val(item['id_producto']);
             /** Asigna 0 al valor anterior del input */
            var elem = document.getElementById('txtPrecioServicio');
            elem.oldValue=0
            $("#txtPrecioServicio").val(item['precio']);
            $("#txtIva").val(item['iva']);
            $("#txtPrecioServicio").change();

        } else {
            adicionarFilaServicio();
            $("#tblDetalleServicios tbody tr:eq(" + index + ")").find("select,input").each(function () {

                if ($(this).attr("id") == "cmb_servicio") {
                    $(this).val(item['id_producto']);
                }
                if ($(this).attr("id") == "txtIva") {
                    $(this).val(item['iva']);
                }
                if ($(this).attr("id") == "txtPrecioServicio") {
                    $(this).val(item['precio']);
                    $(this).change();
                }

            });
        }
    }

    /**Metodo para añadir fila a tabla Detalle servicio*/
    function adicionarFilaServicio() {
        $("#tblDetalleServicios tbody tr:eq(0)").clone().addClass("otrasFilas").removeClass("fila-base").appendTo("#tblDetalleServicios tbody").find("input, select,textarea").val("");
    }

    function limpiartablas()
    {
         Total=0;
         SubTotal=0;
         Iva=0;
        id_remitente=null;
        id_consignatario=null;
        id_proveedor=null;
        /** Limpia todos los inputs*/
        $('input[type="text"]').val('');
        $('input[type="text"]').focus();


        $('input[type="tel"]').val('');
        $('textarea').val('');
        $('#txt_fecha_llegada').val('');

        $('select').val(""); /** Limpia todos select */
        $('#txt_subtotal,#txt_iva,#txt_total').text("0.00");
        /** Elimina todas las filas de tabla dinamica menos la primera */
        $('#tblDetalleServicios tr').closest('.otrasFilas').remove();
        $('#tblDetalleCarga tr').closest('.otrasFilas').remove();

    }

    /**  Funcion para mostrar informacion segun sea el estado de la cotizacion  */
    function changeestado()
    {

        let estado=$('#cmb_estado').val();

        if (estado>2)
            $('.InfoContacto').removeAttr('hidden');
        else
            $('.InfoContacto').attr("hidden",true);

        if (Estado==5)
            $('.InfoContacto').removeAttr('hidden');

    }

    /** Funcion para calcular, total,iva,y subtotal */
    function  calcularPresupuesto(input)
    {

        let calcular=false;
        /** Verifica que existan valores seccionados*/
        if (input.id=="txtPrecioServicio")
        {
            let servicio= $(input).parents('tr').find("select[id*='cmb_servicio']").val();
            if (servicio==null)
            {
                $(input).val("");
                alertError("favor primero seleccione un servicio");
            }
            else
                calcular=true;
        }
        else
        {
           let transporte= $(input).parents('tr').find("select[id*='cmb_modo_transporte']").val();
           let mercancia= $(input).parents('tr').find("select[id*='cmb_tipo_mercancia']").val();
           let cantidad = $(input).parents('tr').find("input[id*='txtCantidad']").val();
            if (transporte==null || mercancia==null || cantidad=="")
            {
                $(input).val("");
                alertError("favor primero completar campos, detalles de la carga");
            }
            else
                calcular=true;
        }



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

            SubTotal=SubTotal-oldvalue
            SubTotal+=valor
            calcularIva();
            Total=SubTotal+Iva

            $('#txt_subtotal').text(number_format(SubTotal, 2, ".", ","));
            $('#txt_iva').text(number_format(Iva, 2, ".", ","));
            $('#txt_total').text(number_format(Total, 2, ".", ","));
        }

    }

    function  listarClientesRemitente()
    {
        var _token= $('input[name=_token]').val();
        $("#tblClientes").DataTable().destroy();

        tblClientes = setDataTable("#tblClientes", {
            ajax: {
                type: 'POST',
                url: '/cliente/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        if (json[5] == 1)
                            return '<span data-toggle="tooltip" data-state="1" class="btnStatus btn btn-xs btn-block btn-primary">Natural</span>';
                        if (json[5] == 2)
                            return '<span data-toggle="tooltip" data-state="1" class="btnStatus btn btn-xs btn-block btn-success">Juridico</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<button class="btn btn-info" title="Selecciona el  registro" onclick="selectClienteRemitente(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
                }]
        });
    }


    /** Selecciona el cliente  y carga valores en formulario */
    function selectClienteRemitente(datos) {

        var dt = tblClientes.row($(datos).parents('tr')).data();
        id_cliente=dt[0];
        remitente(id_cliente)

    }

    function remitente(id_cliente)
    {
        showLoad(true);
        var _token = $('input[name=_token]').val();
        $.ajax({
            type: 'POST',
            url: '/cliente/datos', //llamada a la ruta
            data: {
                _token:_token,
                id_cliente:id_cliente,
            },
            success: function (data) {

                id_remitente=id_cliente;
                $('#txt_nombresRemitente').val(data[0].nombre);
                $('#txt_telefonoRemitente').val(data[0].telefono_2);
                $('#txt_apellido1Remitente').val(data[0].apellido1);
                $('#txt_apellido2Remitente').val(data[0].apellido2);
                $('#txt_direccionRemitente').val(data[0].direccion);
                $('#txt_CorreoRemitente').val(data[0].correo);
                selectR.setCountry(data[0].iso_2);

                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

    }

    function  listarClientesConsignatario()
    {
        var _token= $('input[name=_token]').val();
        $("#tblClientes").DataTable().destroy();

        tblClientes = setDataTable("#tblClientes", {
            ajax: {
                type: 'POST',
                url: '/cliente/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        if (json[5] == 1)
                            return '<span data-toggle="tooltip" data-state="1" class="btnStatus btn btn-xs btn-block btn-primary">Natural</span>';
                        if (json[5] == 2)
                            return '<span data-toggle="tooltip" data-state="1" class="btnStatus btn btn-xs btn-block btn-success">Juridico</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<button class="btn btn-info" title="Selecciona el  registro" onclick="selectClienteConsignatario(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
                }]
        });
    }


    /** Selecciona el cliente  y carga valores en formulario */
    function selectClienteConsignatario(datos) {

        var dt = tblClientes.row($(datos).parents('tr')).data();
        id_cliente=dt[0];

        Consignatario(id_cliente)
    }

    function Consignatario(id_cliente)
    {
        showLoad(true);
        var _token = $('input[name=_token]').val();
        $.ajax({
            type: 'POST',
            url: '/cliente/datos', //llamada a la ruta
            data: {
                _token:_token,
                id_cliente:id_cliente,
            },
            success: function (data) {

                id_consignatario=data[0].id_persona;
                $('#txt_nombresConsignatario').val(data[0].nombre);
                $('#txt_telefonoConsignatario').val(data[0].telefono_2);
                $('#txt_apellido1Consignatario').val(data[0].apellido1);
                $('#txt_apellido2Consignatario').val(data[0].apellido2);
                $('#txt_direccionConsignatario').val(data[0].direccion);
                $('#txt_correoConsignatario').val(data[0].correo);
                selectC.setCountry(data[0].iso_2);

                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });
    }


    function  listarProveedores()
    {
        var _token= $('input[name=_token]').val();
        $("#tblProveedores").DataTable().destroy();

        tblProveedores = setDataTable("#tblProveedores", {
            ajax: {
                type: 'POST',
                url: '/proveedor/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs:
                [
                    {
                        targets: -1,
                        data: null,
                        orderable: false,
                        defaultContent: '<button class="btn btn-info" title="Selecciona el registro" onclick="selectProveedor(this)" data-dismiss="modal"><i class="fa fa-check"> </i> </button>'
                    }
                ]
        });
    }

    /** Selecciona el proveedor y carga valores en formulario */
    function selectProveedor(datos) {

        var dt = tblProveedores.row($(datos).parents('tr')).data();
        id_proveedor=dt[0];
        proveedor(id_proveedor)
    }

    function proveedor(id_proveedor)
    {
        showLoad(true);
        var _token = $('input[name=_token]').val();
        $.ajax({
            type:'POST',
            url: '/proveedor/datos',
            data:{
                _token:_token,
                id_proveedor:id_proveedor
            },
            success: function(data){
                showLoad(false);

                $('#txt_id_proveedor').val(id_proveedor);
                $('#txt_nombresProveedor').val(data[0].nombre);
                $('#txt_correoProveedor').val(data[0].correo);
                $('#txt_telefonoProveedor').val(data[0].telefono_1);
                selectP.setCountry(data[0].iso);
            },
            error: function(err){
                alertError(err.responseText);
                showLoad(false);
            }
        });
    }

    /** Funcion para validar estado de la cotizacion  */
    function GuardarSeguimiento()
    {
        /**
         * Funcion para validar que una cotizacion sea guardada en el orden correcto
         * No se puede guardar una cotizacion de un estado 1 a estado 3 sin pasar por
         * el estado anterior
         */

        let estado=$('#cmb_estado').val();
        let estadonext=Estado+1

        if (estado!=-1 && estado!=2)
        {
            if (estadonext==estado)
                    guardar()
            else
                    alertError("No es posible guardar cotizacion al estado seleccionado");
        }
        else
            guardar()

    }

    /** Guarda Cotizacion */
    function guardar()
    {
        alertConfirm("¿Está seguro que desea guardar?", function (e) {

            var _token = $('input[name=_token]').val();
            let estado=$('#cmb_estado').val();

            /** Solo si esta en estado NUEVA o REVISADA se puede editar Cotizacion */
            if(estado==2) {


                if (Estado>estado)
                {
                    alertError("No es posible guardar cotizacion al estado seleccionado");

                }
                else {

                    $("#ModalEnviarCorreo").modal("show"); //Abre Modal

                    /** Funcion para agregar fila */
                    $(document).off("click", ".guardar").on("click", ".guardar", function ()
                    {

                        var guardar=true;
                        /** Se recuperan datos de tabla Detalles de carga */
                        var DATA1 = [];
                        var TABLA1 = $("#tblDetalleCarga tbody > tr");

                        /*Obtención de datos de la tabla dinámica*/
                        TABLA1.each(function (e) {

                            let estado=false;
                            let Cantidad = $(this).find("input[id*='txtCantidad']").val();
                            let ckEstado = $(this).find("input[id*='ckEstado']");
                            if (ckEstado[0].checked == true)
                                estado=true;

                            let id_tipo_mercancia = $(this).find("select[id*='cmb_tipo_mercancia']").val();
                            let id_modo_transporte = $(this).find("select[id*='cmb_modo_transporte']").val();
                            let observacion = $(this).find("textarea[id*='txt_observacion']").val();

                            let precio = $(this).find("input[id*='txtprecioCargar']")[0].attributes[1].value;

                            if (Cantidad !== "" && id_tipo_mercancia !== "" && id_modo_transporte && precio!== "") {
                                item = {};
                                item ["Cantidad"] =parseInt(Cantidad);
                                item ["estado"] = estado;
                                item ["id_tipo_mercancia"] = parseInt(id_tipo_mercancia);
                                item ["id_modo_transporte"] = parseInt(id_modo_transporte);
                                item ["observacion"] = observacion;
                                precio=parseFloat( precio= precio.replace(/,/g, "")); /**Formate numero */
                                item ["precio"] = precio;
                                DATA1.push(item);
                            }
                            else
                            {
                                guardar=false; $(this).focus();
                                alertError("¡Por favor completar datos de la informacion de Carga!");
                            }

                        });

                        let tblDetalleCarga = JSON.stringify(DATA1);

                        /** Se recuperan datos de tabla servicios adicionales*/
                        var DATA2 = [];
                        var TABLA2 = $("#tblDetalleServicios tbody > tr");

                        /*Obtención de datos de la tabla dinámica*/
                        TABLA2.each(function (e) {

                            let id_servicio = $(this).find("select[id*='cmb_servicio']").val();
                            let precio = $(this).find("input[id*='txtPrecioServicio']").val();
                            if (id_servicio!="" && id_servicio!=null &&  precio!="")
                            {
                                item = {};
                                item["id_servicio"] =parseInt(id_servicio);
                                precio=parseFloat( precio= precio.replace(/,/g, "")); /**Formate numero */
                            item["precio"] =precio;
                                DATA2.push(item);
                            }
                            else
                            {
                                guardar=false; $(this).focus();
                                alertError("¡Por favor completar datos de servicio!");
                            }


                        });

                        let tblDetalleServicios = JSON.stringify(DATA2);

                        if (guardar==true)
                        {
                            var nota_adicional = $('#txt_nota_adicional').val();
                            var nota_interna = $('#txt_nota_interna').val();
                            var correo =$('#txt_enviarCorreo').val();

                            showLoad(true);
                            $.ajax({
                                type: 'POST',
                                url: '/actualizarCotizacion', //llamada a la ruta
                                data: {
                                    _token: _token,
                                    tblDetalleCarga: tblDetalleCarga,
                                    tblDetalleServicios: tblDetalleServicios,
                                    nota_interna: nota_interna,
                                    nota_adicional: nota_adicional,
                                    estado: estado,
                                    id_cotizacion: id_cotizacion,
                                    correo:correo,
                                    total:Total,
                                    iva:Iva
                                },
                                success: function (data) {

                                    showLoad(false);
                                    if (data.error) {
                                        alertError(data.mensaje);
                                    } else {
                                        alertSuccess(data.mensaje);
                                        $('#btnRefresh').click();
                                    }
                                },
                                error: function (err) {
                                    alertError(err.responseText);
                                    showLoad(false);
                                }

                            });
                        }
                    });
                }

            }
            else
            {
                /** Rechazar una cotizacion */
                if (estado==-1)
                {
                    var nota_interna = $('#txt_nota_interna').val();
                    showLoad(true);

                    $.ajax({
                        type: 'POST',
                        url: '/EstadoCotizacion', //llamada a la ruta
                        data: {
                            _token: _token,
                            id_cotizacion: id_cotizacion,
                            nota_interna:nota_interna,
                            estado:estado
                        },
                        success: function (data) {

                            showLoad(false);
                            if (data.error) {
                                alertError(data.mensaje);
                            } else {
                                alertSuccess(data.mensaje);
                                $('#btnRefresh').click();
                            }
                        },
                        error: function (err) {
                            alertError(err.responseText);
                            showLoad(false);
                        }

                    });

                }
                else /** Guardar flete Estado "Aprobada" */
                {
                    guardarFlete();
                }
            }

        });
    }


    /** Guarda flete (Estado 3-5) */
    function guardarFlete()
    {
        let estado=$('#cmb_estado').val();
        var _token = $('input[name=_token]').val();

        if (estado==3)
        {
            let guardar=true;
            var fecha_llegada=$('#txt_fecha_llegada').val();
            var fecha_llegadaVAL=$('#txt_fecha_llegada').parsley();
            var fecha=$('#txt_fecha').val();

            /** Datos remitente */
            var nombresConsignatario=$('#txt_nombresConsignatario').val();
            var apellido1Consignatario=$('#txt_apellido1Consignatario').val();
            var apellido2Consignatario=$('#txt_apellido2Consignatario').val();
            var telefonoConsignatario=$('#txt_telefonoConsignatario').val()
            var iso2=selectC.getSelectedCountryData().iso2;
            var correoConsignatario=$('#txt_correoConsignatario').val();
            var direccionConsignatario=$('#txt_direccionConsignatario').val();
            /** Validando INPUTS */
            var nombresConsignatarioVAL=$('#txt_nombresConsignatario').parsley();
            var apellido1ConsignatarioVAL=$('#txt_apellido1Consignatario').parsley();
            var telefonoConsignatarioVAL=$('#txt_telefonoConsignatario').parsley();
            var correoConsignatarioVAL=$('#txt_correoConsignatario').parsley();
            var direccionConsignatarioVAL=$('#txt_direccionConsignatario').parsley();

            if (id_remitente!=null && id_proveedor!=null && fecha_llegada!="" && fecha!="")
            {

                /** Verifica que exista un consignatario */
                if (id_consignatario==null)
                {
                    if (nombresConsignatarioVAL.isValid() && apellido1ConsignatarioVAL.isValid()  && telefonoConsignatarioVAL.isValid() && correoConsignatarioVAL.isValid() && direccionConsignatarioVAL.isValid()  )
                        guardar=true;
                    else
                    {
                        nombresConsignatarioVAL.validate();
                        apellido1ConsignatarioVAL.validate();
                        telefonoConsignatarioVAL.validate();
                        correoConsignatarioVAL.validate();
                        direccionConsignatarioVAL.validate();
                        alertError("Favor completar Datos de consignatario")
                        guardar=false;
                    }

                }

                if (guardar==true)
                    {

                    showLoad(true);
                        $.ajax({
                            type: 'POST',
                            url: '/guardarFlete', //llamada a la ruta
                            data: {
                                _token: _token,
                                id_cotizacion: id_cotizacion,
                                id_remitente:id_remitente,
                                id_consignatario:id_consignatario,
                                id_proveedor:id_proveedor,
                                fecha:fecha,
                                fecha_llegada:fecha_llegada,
                                nombresConsignatario:nombresConsignatario.trim(),
                                apellido1Consignatario:apellido1Consignatario.trim(),
                                apellido2Consignatario:apellido2Consignatario,
                                telefonoConsignatario:telefonoConsignatario,
                                iso2:iso2,
                                correoConsignatario:correoConsignatario,
                                direccionConsignatario:direccionConsignatario.trim(),
                                estado:estado
                            },
                            success: function (data) {

                                showLoad(false);
                                if (data.error) {
                                    alertError(data.mensaje);
                                } else {
                                    alertSuccess(data.mensaje);
                                    $('#btnRefresh').click();
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
                if (fecha_llegadaVAL.isValid())
                    console.clear();
                else /** Valida que se agrege una fecha de llegada */
                    fecha_llegadaVAL.validate();

                alertError("Favor completar campos");
            }

        }
        else {

            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/setEstado', //llamada a la ruta
                data: {
                    _token: _token,
                    id_cotizacion: id_cotizacion,
                    estado:estado
                },
                success: function (data) {

                    showLoad(false);
                    if (data.error) {
                        alertError(data.mensaje);
                    } else {
                        alertSuccess(data.mensaje);
                        $('#btnRefresh').click();
                    }
                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }

            });
        }
    }

    function EnviarCorreo()
    {
        $('#txt_enviarCorreo').val("");
    }


    function CargarDatosFlete()
    {
        showLoad(true);
        var _token= $('input[name=_token]').val();

        /** Recupera encabezado*/
        $.ajax({
            type: 'POST',
            url: '/getFlete', //llamada a la ruta
            data: {
                _token:_token,
                id_cotizacion:id_cotizacion,
            },
            success: function (data) {

                $('#txt_fecha_llegada').val(data[0].fecha_entrega);
                remitente(data[0].id_cliente)
                proveedor(data[0].id_proveedor)

                /** Recupera datos de consignatario */
                $.ajax({
                    type: 'POST',
                    url: '/getConsignatario', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_consignatario:data[0].id_consignatario,
                    },
                    success: function (datos) {

                        $('#txt_nombresConsignatario').val(datos[0].nombre);
                        $('#txt_apellido1Consignatario').val(datos[0].apellido1);
                        $('#txt_apellido2Consignatario').val(datos[0].apellido2);
                        $('#txt_telefonoConsignatario').val(datos[0].telefono_2)
                        selectC.setCountry(datos[0].iso_2);
                        $('#txt_correoConsignatario').val(datos[0].correo);
                        $('#txt_direccionConsignatario').val(datos[0].direccion);

                        showLoad(false);

                    },
                    error: function (err) {
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });

            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

    }

    /** Funcion que genera reporte */
    function rpt_cotizacion()
    {
        showLoad(true);
        var _token= $('input[name=_token]').val();

        $.ajax({
            type:"post",
            url: '/cotizaciones/datos', //llamada a la ruta
            global:false,
            data:{
                _token:_token,
                id_cotizacion: id_cotizacion
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

    /** Funcion para si el servicio cobra iva */
    function  validarServicio(select)
    {
        var id_servicio=select.value;

        var TABLA= $("#tblDetalleServicios tbody > tr");
        servicio=0;
        TABLA.each(function (e) {

            let ser = $(this).find("select[id*='cmb_servicio']").val();

            if (id_servicio==ser)
            {
                servicio++;
            }

            if (servicio>1)
            {
                select.value=""
                alertError("El servicio ya existe en la factura")
                $(this).find("select[id*='txtPrecioServicio']").trigger("focus")
                $(this).find("select[id*='txtPrecioServicio']").trigger("change")
            }

        });

        if (select.value!="")
        {
            var _token= $('input[name=_token]').val();

            $.ajax({
                type: 'POST',
                url: '/getDetalleServicio/iva', //llamada a la ruta
                data: {
                    _token:_token,
                    id_servicio:id_servicio
                },
                success: function (data) {
                    $(select).parents('tr').find("input[id*='txtIva']").val(data[0].iva);
                    calcularIva()

                },
                error: function (err) {
                    alertError(err.responseText);
                    showLoad(false);
                }

            });
        }


    }

    function calcularIva()
    {

        var TABLA= $("#tblDetalleServicios tbody > tr");

        Iva=0;
        TABLA.each(function (e) {

            let iva = $(this).find("input[id*='txtIva']").val();

            if (iva=="true")
            {
                let precio = $(this).find("input[id*='txtPrecioServicio']").val();

                if (precio!="" && precio!=undefined )
                    precio=parseFloat( precio= precio.replace(/,/g, "")); /**Formate numero */
                else
                    precio=0

                Iva+=precio*0.15;
            }
        });

    }

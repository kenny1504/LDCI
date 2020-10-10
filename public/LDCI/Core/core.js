/** archivo creado para funciones generales del sistema */
/** 10-10-2020 Kevin Kenny saenz zapata */




    /*
        Mostrar mensaje cuando la ejecucion sea correcta
    */
    function alertSuccess(textHtml) {

        alertify.success(textHtml);
    }

    /*
        Mostrar mensaje de error
    */
    function alertError(textHtml) {

        //http://naoxink.hol.es/notifIt/#step2

        alertify.error(textHtml);
    }

    /**
     * Muestra un alert y espera la confirmación
     * @param {string}   texto    Texto a mostrar
     * @param {function} callback Funcion que se ejecutar una vez confirmada o denegada la accion
     */
    function alertConfirm(texto, callback) {
        alertify.set({buttonFocus: "cancel"});
        alertify.set({
            labels: {
                ok: "Continuar",
                cancel: "Cancelar"
            }
        });
        alertify.confirm(texto, function (e) {
            if (is.function(callback))
                callback(e);
            else
                alertError("No se puede llamar a esta function");

        });
    }


    function showLoad(option) {
        if (option) {
            //
            $("#loader-wrapper").css("display", "block");
            $(".section-left").show("slide", {direction: "left"}, 500);
            $(".section-right").show("slide", {direction: "right"}, 500, function () {
                $("#loader").fadeIn();
            });
        } else {
            $("#loader").hide();
            $(".section-left").hide("slide", {direction: "left"}, 500);
            $(".section-right").hide("slide", {direction: "right"}, 500, function () {
                //$("#loader-wrapper").remove();
                $("#loader-wrapper").css("display", "none");
            });
        }
    }


    /** Metodo pára darle formato a las consultas de tipo con campos que involucren dinero */
    function formatNumber(num) {
        var result = "";
        if (is.not.empty(num)) {
            $.each(num.split(""), function (index, caracter) {
                if (!(caracter == "C" || caracter == "$" || caracter == ",")) {
                    result += caracter;
                }
            })
            return result;
        } else
            return num;
    }


    /**
     * Asigna a una tabla las propiedades del dataTable
     * @param {string} idTabla Identificador del elemento en el DOM
     */
    function setDataTable(idTabla, config) {
        var configParam = config || {ajax: {}};

        //configParam.ajax = typeof(configParam.ajax) == "undefined" ? false : $.extend(configParam.ajax,dt_extra_params);
        /*if(configParam.ajax){
            configParam.ajax.data = function ( d ) {
                return $.extend(d, configParam.ajax.data,{
                    "extra_params" : dt_extra_params
                } );
                }
        }
        debugger*/
        try {
            //var config = configParam || {};

            var ajax = {};

            /*if(typeof(configParam.ajax) != "undefined"){
                ajax = {
                    url : configParam.ajax.url,
                    type: configParam.ajax.type,
                    data: function(d){
                        return $.extend(d, configParam.ajax.data,{
                            "extra_params" : dt_extra_params
                        });

                    }
                }
            }*/
            return $(idTabla).DataTable({
                "search": {
                    "regex": true
                },
                "lengthMenu": [[10, 25, 50,500,1000], [10, 25, 50,500,1000]],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "&Uacute;ltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                //fixedHeader: typeof(configParam.fixedHeader) == "undefined" ? null : configParam.fixedHeader,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: typeof(configParam.ajax.url) == "undefined" ? false : true,
                serverSide: typeof(configParam.ajax.url) == "undefined" ? false : true,
                ajax: {
                    url: configParam.ajax.url,
                    type: configParam.ajax.type,
                    data: function (d) {
                        return $.extend(d, configParam.ajax.data, {
                            "extra_params": dt_extra_params
                        });

                    }
                },
                aoColumns: typeof(configParam.aoColumns) == "undefined" ? null : configParam.aoColumns,
                order: typeof(configParam.order) == "undefined" ? [] : configParam.order,
                fnRowCallback: typeof(configParam.fnRowCallback) == "undefined" ? null : configParam.fnRowCallback,
                columnDefs: typeof(configParam.columnDefs) == "undefined" ? false : configParam.columnDefs

            });
        } catch (err) {
            alertError("Ocurrio un error inesperado");
            console.log(err);
        }
    }

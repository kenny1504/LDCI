/** archivo creado para funciones generales del sistema */
/** 10-10-2020 Kevin Kenny saenz zapata */

  //Mostrar alerta al usuario

  $(document).ready(function () {
  
  console.log("%c\tAlerta!! \n", "color: red; font-size: x-large");
  console.log("%cEl codigo que ingrese en esta consola que pueda altere el comportamiento del sistema sera penalizado.\n", "color: green");

  })


var pass=null; /** Variable que guarda contraseña del usuario */
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
        alertify.confirm(texto, function(action){
            if(action)
                callback();
            else
              alertify.error('Cancelado');
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


    /** Funcion para cerrar session */
    function loginOut()
    {
        showLoad(true);
        alertSuccess("Cerrando session");

       /** Detiene , para mostrar alertSucess  */
        setTimeout(function(){
            window.location.href='/login';
            showLoad(False);
        }, 200);

    }

    /** Funcion que recupera datos del usuario para modificar*/
    function editarUsuario()
    {
        var _token= $('input[name=_token]').val();
        showLoad(true);
        $.ajax({
            type: 'POST',
            url: '/datos/usuario', //llamada a la ruta
            data: {
              _token:_token
            },
            success: function(data){
               $('#usuario').val(data[0].usuario);
               pass=data[0].pass;
               $('#telefono').val(data[0].telefono);
               $('#correo').val(data[0].correo);
               showLoad(false);
           },
            error : function(err){
                alertError(err.responseText);
                showLoad(false);
            }

        });
        
    }


    /** Funcion que guardar datos de usuario a modificar*/
    function guardarUsuario()
    {
    
        var _token= $('input[name=_token]').val();
        var usuario= $('#usuario').val();
        //var nombre= $('#nombre').val();
        var telefono =$('#telefono').val();
        var correo =$('#correo').val();
        var pass_old =$('#pass_old').val();
        var pass_new=$('#pass_new').val();
        var pass_confirm =$("#pass_new_confirm").val();

    if(pass_confirm!==pass_new || pass_old ==='' )
    {
        alertError("Contraseña anterior no coincide");
    }
    else
    {
        alertConfirm("¿Está seguro que desea guardar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/datos/modificaUsuario', //llamada a la ruta
                    data: {
                    _token:_token,
                    usuario:usuario,
                    correo:correo,
                    telefono:telefono,
                    pass_old:Base64.encode(pass_old),
                    password:Base64.encode(pass_new)
  
                    },
                    success: function(data){
                        showLoad(false);
                        if(data.error){
                            alertError(data.mensaje);
                            return;
                        }
                        alertSuccess("Se ha actualizado la información");
                        setTimeout(function(){
                            window.location.href='';
                            showLoad(false);
                        },200);
                    },
                    error : function(err){
                        alertError(err.responseText);
                        showLoad(false);
                    }

                });
       });
    }

       
        
    }


    function registrarUsuario()
    {

        var _token= $('input[name=_token]').val();
        var usuario= $('#txt_usuario').val();
        var correo= $('#txt_correo').val();
        var telefono =$('#txt_telefono').val();
        var pass =$('#txt_pass').val();
        pass=Base64.encode(pass);
  
        if(usuario!="" && correo!="" && telefono!="" && pass!=""  )
        {
            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/registro/usuario', //llamada a la ruta
                data: {
                _token:_token,
                usuario:usuario,
                correo:correo,
                telefono:telefono,
                pass:pass
                },
                success: function(data){
                    switch (data)
                    {
                        case 1: 
                            alertSuccess("Se ha enviado un correo de confirmacion");
                            /** Detiene , para mostrar alertSucess  */
                                setTimeout(function(){
                                    window.location.href='/login';
                                }, 200);break;
                        
                        case 0:
                            alertSuccess("El correo ya esta siendo usado por otro usuario");break;

                        case 2:
                            alertSuccess("El usuario ya esta siendo usado por otro usuario");break;
                        default:
                            alertSuccess("Error desconocido");break;
                    }
                    showLoad(false);
                    
                },
                error : function(err){
                    alertError(err.responseText);
                }

            });
        }
        else
            alertError("Favor completar todos los campos");

    }


      /*** Funcion para Codificar o Decodificar */
      var Base64 = {

        // Clave
        _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    
        // public methodo para codificiar
        encode : function (input) {
            var output = "";
            var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
            var i = 0;
    
            input = Base64._utf8_encode(input);
    
            while (i < input.length) {
    
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);
    
                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;
    
                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }
    
                output = output +
                    this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                    this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
    
            }
    
            return output;
        },
    
        // public methodo decodificar
        decode : function (input) {
            var output = "";
            var chr1, chr2, chr3;
            var enc1, enc2, enc3, enc4;
            var i = 0;
    
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
    
            while (i < input.length) {
    
                enc1 = this._keyStr.indexOf(input.charAt(i++));
                enc2 = this._keyStr.indexOf(input.charAt(i++));
                enc3 = this._keyStr.indexOf(input.charAt(i++));
                enc4 = this._keyStr.indexOf(input.charAt(i++));
    
                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;
    
                output = output + String.fromCharCode(chr1);
    
                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }
    
            }
    
            output = Base64._utf8_decode(output);
    
            return output;
    
        },
    
        // private methodo para UTF-8 codificar
        _utf8_encode : function (string) {
            string = string.replace(/\r\n/g,"\n");
            var utftext = "";
    
            for (var n = 0; n < string.length; n++) {
    
                var c = string.charCodeAt(n);
    
                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
    
            }
    
            return utftext;
        },
    
        // private method para UTF-8 decodificar
        _utf8_decode : function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;
    
            while ( i < utftext.length ) {
    
                c = utftext.charCodeAt(i);
    
                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                }
                else if((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i+1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                }
                else {
                    c2 = utftext.charCodeAt(i+1);
                    c3 = utftext.charCodeAt(i+2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }
    
            }
    
            return string;
        }
    
      }
    
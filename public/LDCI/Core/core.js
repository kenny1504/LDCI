/** archivo creado para funciones generales del sistema */
/** 10-10-2020 Kevin Kenny saenz zapata */

//Variables adicionales para el filtro de registro
//en el datatable
var dt_extra_params = {};
var configDataTable = {};
var pass = null; /** Variable que guarda contraseña del usuario */
var select=null; /** Variable pára guardar inicializacion de select flag (countries) */
var allCountries=null; /** Guarda paises y sus codigos (Telefono) */

    $(document).ready(function () {

        setTimeout(function () {
            console.clear();
            console.log("%c\tAlerta!! \n", "color: red; font-size: x-large");
            console.log("%cEl codigo que ingrese en esta consola que pueda alterar el comportamiento del sistema sera penalizado.\n", "color: green");
        }, 300);
        $('#btnLeftMenu').click();

        var input = document.querySelector("#phone");
        select = window.intlTelInput(input, {
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

        allCountries = [ [ "Afghanistan (‫افغانستان‬‎)", "af", "93" ], [ "Albania (Shqipëri)", "al", "355" ], [ "Algeria (‫الجزائر‬‎)", "dz", "213" ], [ "American Samoa", "as", "1", 5, [ "684" ] ], [ "Andorra", "ad", "376" ], [ "Angola", "ao", "244" ], [ "Anguilla", "ai", "1", 6, [ "264" ] ], [ "Antigua and Barbuda", "ag", "1", 7, [ "268" ] ], [ "Argentina", "ar", "54" ], [ "Armenia (Հայաստան)", "am", "374" ], [ "Aruba", "aw", "297" ], [ "Australia", "au", "61", 0 ], [ "Austria (Österreich)", "at", "43" ], [ "Azerbaijan (Azərbaycan)", "az", "994" ], [ "Bahamas", "bs", "1", 8, [ "242" ] ], [ "Bahrain (‫البحرين‬‎)", "bh", "973" ], [ "Bangladesh (বাংলাদেশ)", "bd", "880" ], [ "Barbados", "bb", "1", 9, [ "246" ] ], [ "Belarus (Беларусь)", "by", "375" ], [ "Belgium (België)", "be", "32" ], [ "Belize", "bz", "501" ], [ "Benin (Bénin)", "bj", "229" ], [ "Bermuda", "bm", "1", 10, [ "441" ] ], [ "Bhutan (འབྲུག)", "bt", "975" ], [ "Bolivia", "bo", "591" ], [ "Bosnia and Herzegovina (Босна и Херцеговина)", "ba", "387" ], [ "Botswana", "bw", "267" ], [ "Brazil (Brasil)", "br", "55" ], [ "British Indian Ocean Territory", "io", "246" ], [ "British Virgin Islands", "vg", "1", 11, [ "284" ] ], [ "Brunei", "bn", "673" ], [ "Bulgaria (България)", "bg", "359" ], [ "Burkina Faso", "bf", "226" ], [ "Burundi (Uburundi)", "bi", "257" ], [ "Cambodia (កម្ពុជា)", "kh", "855" ], [ "Cameroon (Cameroun)", "cm", "237" ], [ "Canada", "ca", "1", 1, [ "204", "226", "236", "249", "250", "289", "306", "343", "365", "387", "403", "416", "418", "431", "437", "438", "450", "506", "514", "519", "548", "579", "581", "587", "604", "613", "639", "647", "672", "705", "709", "742", "778", "780", "782", "807", "819", "825", "867", "873", "902", "905" ] ], [ "Cape Verde (Kabu Verdi)", "cv", "238" ], [ "Caribbean Netherlands", "bq", "599", 1, [ "3", "4", "7" ] ], [ "Cayman Islands", "ky", "1", 12, [ "345" ] ], [ "Central African Republic (République centrafricaine)", "cf", "236" ], [ "Chad (Tchad)", "td", "235" ], [ "Chile", "cl", "56" ], [ "China (中国)", "cn", "86" ], [ "Christmas Island", "cx", "61", 2, [ "89164" ] ], [ "Cocos (Keeling) Islands", "cc", "61", 1, [ "89162" ] ], [ "Colombia", "co", "57" ], [ "Comoros (‫جزر القمر‬‎)", "km", "269" ], [ "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "cd", "243" ], [ "Congo (Republic) (Congo-Brazzaville)", "cg", "242" ], [ "Cook Islands", "ck", "682" ], [ "Costa Rica", "cr", "506" ], [ "Côte d’Ivoire", "ci", "225" ], [ "Croatia (Hrvatska)", "hr", "385" ], [ "Cuba", "cu", "53" ], [ "Curaçao", "cw", "599", 0 ], [ "Cyprus (Κύπρος)", "cy", "357" ], [ "Czech Republic (Česká republika)", "cz", "420" ], [ "Denmark (Danmark)", "dk", "45" ], [ "Djibouti", "dj", "253" ], [ "Dominica", "dm", "1", 13, [ "767" ] ], [ "Dominican Republic (República Dominicana)", "do", "1", 2, [ "809", "829", "849" ] ], [ "Ecuador", "ec", "593" ], [ "Egypt (‫مصر‬‎)", "eg", "20" ], [ "El Salvador", "sv", "503" ], [ "Equatorial Guinea (Guinea Ecuatorial)", "gq", "240" ], [ "Eritrea", "er", "291" ], [ "Estonia (Eesti)", "ee", "372" ], [ "Eswatini", "sz", "268" ], [ "Ethiopia", "et", "251" ], [ "Falkland Islands (Islas Malvinas)", "fk", "500" ], [ "Faroe Islands (Føroyar)", "fo", "298" ], [ "Fiji", "fj", "679" ], [ "Finland (Suomi)", "fi", "358", 0 ], [ "France", "fr", "33" ], [ "French Guiana (Guyane française)", "gf", "594" ], [ "French Polynesia (Polynésie française)", "pf", "689" ], [ "Gabon", "ga", "241" ], [ "Gambia", "gm", "220" ], [ "Georgia (საქართველო)", "ge", "995" ], [ "Germany (Deutschland)", "de", "49" ], [ "Ghana (Gaana)", "gh", "233" ], [ "Gibraltar", "gi", "350" ], [ "Greece (Ελλάδα)", "gr", "30" ], [ "Greenland (Kalaallit Nunaat)", "gl", "299" ], [ "Grenada", "gd", "1", 14, [ "473" ] ], [ "Guadeloupe", "gp", "590", 0 ], [ "Guam", "gu", "1", 15, [ "671" ] ], [ "Guatemala", "gt", "502" ], [ "Guernsey", "gg", "44", 1, [ "1481", "7781", "7839", "7911" ] ], [ "Guinea (Guinée)", "gn", "224" ], [ "Guinea-Bissau (Guiné Bissau)", "gw", "245" ], [ "Guyana", "gy", "592" ], [ "Haiti", "ht", "509" ], [ "Honduras", "hn", "504" ], [ "Hong Kong (香港)", "hk", "852" ], [ "Hungary (Magyarország)", "hu", "36" ], [ "Iceland (Ísland)", "is", "354" ], [ "India (भारत)", "in", "91" ], [ "Indonesia", "id", "62" ], [ "Iran (‫ایران‬‎)", "ir", "98" ], [ "Iraq (‫العراق‬‎)", "iq", "964" ], [ "Ireland", "ie", "353" ], [ "Isle of Man", "im", "44", 2, [ "1624", "74576", "7524", "7924", "7624" ] ], [ "Israel (‫ישראל‬‎)", "il", "972" ], [ "Italy (Italia)", "it", "39", 0 ], [ "Jamaica", "jm", "1", 4, [ "876", "658" ] ], [ "Japan (日本)", "jp", "81" ], [ "Jersey", "je", "44", 3, [ "1534", "7509", "7700", "7797", "7829", "7937" ] ], [ "Jordan (‫الأردن‬‎)", "jo", "962" ], [ "Kazakhstan (Казахстан)", "kz", "7", 1, [ "33", "7" ] ], [ "Kenya", "ke", "254" ], [ "Kiribati", "ki", "686" ], [ "Kosovo", "xk", "383" ], [ "Kuwait (‫الكويت‬‎)", "kw", "965" ], [ "Kyrgyzstan (Кыргызстан)", "kg", "996" ], [ "Laos (ລາວ)", "la", "856" ], [ "Latvia (Latvija)", "lv", "371" ], [ "Lebanon (‫لبنان‬‎)", "lb", "961" ], [ "Lesotho", "ls", "266" ], [ "Liberia", "lr", "231" ], [ "Libya (‫ليبيا‬‎)", "ly", "218" ], [ "Liechtenstein", "li", "423" ], [ "Lithuania (Lietuva)", "lt", "370" ], [ "Luxembourg", "lu", "352" ], [ "Macau (澳門)", "mo", "853" ], [ "Macedonia (FYROM) (Македонија)", "mk", "389" ], [ "Madagascar (Madagasikara)", "mg", "261" ], [ "Malawi", "mw", "265" ], [ "Malaysia", "my", "60" ], [ "Maldives", "mv", "960" ], [ "Mali", "ml", "223" ], [ "Malta", "mt", "356" ], [ "Marshall Islands", "mh", "692" ], [ "Martinique", "mq", "596" ], [ "Mauritania (‫موريتانيا‬‎)", "mr", "222" ], [ "Mauritius (Moris)", "mu", "230" ], [ "Mayotte", "yt", "262", 1, [ "269", "639" ] ], [ "Mexico (México)", "mx", "52" ], [ "Micronesia", "fm", "691" ], [ "Moldova (Republica Moldova)", "md", "373" ], [ "Monaco", "mc", "377" ], [ "Mongolia (Монгол)", "mn", "976" ], [ "Montenegro (Crna Gora)", "me", "382" ], [ "Montserrat", "ms", "1", 16, [ "664" ] ], [ "Morocco (‫المغرب‬‎)", "ma", "212", 0 ], [ "Mozambique (Moçambique)", "mz", "258" ], [ "Myanmar (Burma) (မြန်မာ)", "mm", "95" ], [ "Namibia (Namibië)", "na", "264" ], [ "Nauru", "nr", "674" ], [ "Nepal (नेपाल)", "np", "977" ], [ "Netherlands (Nederland)", "nl", "31" ], [ "New Caledonia (Nouvelle-Calédonie)", "nc", "687" ], [ "New Zealand", "nz", "64" ], [ "Nicaragua", "ni", "505" ], [ "Niger (Nijar)", "ne", "227" ], [ "Nigeria", "ng", "234" ], [ "Niue", "nu", "683" ], [ "Norfolk Island", "nf", "672" ], [ "North Korea (조선 민주주의 인민 공화국)", "kp", "850" ], [ "Northern Mariana Islands", "mp", "1", 17, [ "670" ] ], [ "Norway (Norge)", "no", "47", 0 ], [ "Oman (‫عُمان‬‎)", "om", "968" ], [ "Pakistan (‫پاکستان‬‎)", "pk", "92" ], [ "Palau", "pw", "680" ], [ "Palestine (‫فلسطين‬‎)", "ps", "970" ], [ "Panama (Panamá)", "pa", "507" ], [ "Papua New Guinea", "pg", "675" ], [ "Paraguay", "py", "595" ], [ "Peru (Perú)", "pe", "51" ], [ "Philippines", "ph", "63" ], [ "Poland (Polska)", "pl", "48" ], [ "Portugal", "pt", "351" ], [ "Puerto Rico", "pr", "1", 3, [ "787", "939" ] ], [ "Qatar (‫قطر‬‎)", "qa", "974" ], [ "Réunion (La Réunion)", "re", "262", 0 ], [ "Romania (România)", "ro", "40" ], [ "Russia (Россия)", "ru", "7", 0 ], [ "Rwanda", "rw", "250" ], [ "Saint Barthélemy", "bl", "590", 1 ], [ "Saint Helena", "sh", "290" ], [ "Saint Kitts and Nevis", "kn", "1", 18, [ "869" ] ], [ "Saint Lucia", "lc", "1", 19, [ "758" ] ], [ "Saint Martin (Saint-Martin (partie française))", "mf", "590", 2 ], [ "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508" ], [ "Saint Vincent and the Grenadines", "vc", "1", 20, [ "784" ] ], [ "Samoa", "ws", "685" ], [ "San Marino", "sm", "378" ], [ "São Tomé and Príncipe (São Tomé e Príncipe)", "st", "239" ], [ "Saudi Arabia (‫المملكة العربية السعودية‬‎)", "sa", "966" ], [ "Senegal (Sénégal)", "sn", "221" ], [ "Serbia (Србија)", "rs", "381" ], [ "Seychelles", "sc", "248" ], [ "Sierra Leone", "sl", "232" ], [ "Singapore", "sg", "65" ], [ "Sint Maarten", "sx", "1", 21, [ "721" ] ], [ "Slovakia (Slovensko)", "sk", "421" ], [ "Slovenia (Slovenija)", "si", "386" ], [ "Solomon Islands", "sb", "677" ], [ "Somalia (Soomaaliya)", "so", "252" ], [ "South Africa", "za", "27" ], [ "South Korea (대한민국)", "kr", "82" ], [ "South Sudan (‫جنوب السودان‬‎)", "ss", "211" ], [ "Spain (España)", "es", "34" ], [ "Sri Lanka (ශ්‍රී ලංකාව)", "lk", "94" ], [ "Sudan (‫السودان‬‎)", "sd", "249" ], [ "Suriname", "sr", "597" ], [ "Svalbard and Jan Mayen", "sj", "47", 1, [ "79" ] ], [ "Sweden (Sverige)", "se", "46" ], [ "Switzerland (Schweiz)", "ch", "41" ], [ "Syria (‫سوريا‬‎)", "sy", "963" ], [ "Taiwan (台灣)", "tw", "886" ], [ "Tajikistan", "tj", "992" ], [ "Tanzania", "tz", "255" ], [ "Thailand (ไทย)", "th", "66" ], [ "Timor-Leste", "tl", "670" ], [ "Togo", "tg", "228" ], [ "Tokelau", "tk", "690" ], [ "Tonga", "to", "676" ], [ "Trinidad and Tobago", "tt", "1", 22, [ "868" ] ], [ "Tunisia (‫تونس‬‎)", "tn", "216" ], [ "Turkey (Türkiye)", "tr", "90" ], [ "Turkmenistan", "tm", "993" ], [ "Turks and Caicos Islands", "tc", "1", 23, [ "649" ] ], [ "Tuvalu", "tv", "688" ], [ "U.S. Virgin Islands", "vi", "1", 24, [ "340" ] ], [ "Uganda", "ug", "256" ], [ "Ukraine (Україна)", "ua", "380" ], [ "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "ae", "971" ], [ "United Kingdom", "gb", "44", 0 ], [ "United States", "us", "1", 0 ], [ "Uruguay", "uy", "598" ], [ "Uzbekistan (Oʻzbekiston)", "uz", "998" ], [ "Vanuatu", "vu", "678" ], [ "Vatican City (Città del Vaticano)", "va", "39", 1, [ "06698" ] ], [ "Venezuela", "ve", "58" ], [ "Vietnam (Việt Nam)", "vn", "84" ], [ "Wallis and Futuna (Wallis-et-Futuna)", "wf", "681" ], [ "Western Sahara (‫الصحراء الغربية‬‎)", "eh", "212", 1, [ "5288", "5289" ] ], [ "Yemen (‫اليمن‬‎)", "ye", "967" ], [ "Zambia", "zm", "260" ], [ "Zimbabwe", "zw", "263" ], [ "Åland Islands", "ax", "358", 1, [ "18" ] ] ];
        // loop over all of the countries above, restructuring the data to be objects with named keys
        for (var i = 0; i < allCountries.length; i++) {
            var c = allCountries[i];
            allCountries[i] = {
                name: c[0],
                iso2: c[1],
                dialCode: c[2],
                priority: c[3] || 0,
                areaCodes: c[4] || null
            };
        }


    })

    /**
        Mostrar mensaje cuando la ejecucion sea correcta
    */
    function alertSuccess(textHtml) {

        alertify.success(textHtml);
    }

    /**
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
        alertify.set({ buttonFocus: "cancel" });
        alertify.set({
            labels: {
                ok: "Continuar",
                cancel: "Cancelar"
            }
        });
        alertify.confirm(texto, function (action) {
            if (action)
                callback();
            else
                alertify.error('Cancelado');
        });
    }

    function showLoad(option) {
        if (option) {
            //
            $("#loader-wrapper").css("display", "block");
            $(".section-left").show("slide", { direction: "left" }, 500);
            $(".section-right").show("slide", { direction: "right" }, 500, function () {
                $("#loader").fadeIn();
            });
        } else {
            $("#loader").hide();
            $(".section-left").hide("slide", { direction: "left" }, 500);
            $(".section-right").hide("slide", { direction: "right" }, 500, function () {
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
        var configParam = config || { ajax: {} };

        try {
            var ajax = {};

            return $(idTabla).DataTable({
                "search": {
                    "regex": true
                },
                "lengthMenu": [[10, 25, 50, 500, 1000], [10, 25, 50, 500, 1000]],
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
                processing: typeof (configParam.ajax.url) == "undefined" ? false : true,
                serverSide: typeof (configParam.ajax.url) == "undefined" ? false : true,
                ajax: {
                    url: configParam.ajax.url,
                    type: configParam.ajax.type,
                    data: function (d) {
                        return $.extend(d, configParam.ajax.data, {
                            "extra_params": dt_extra_params
                        });

                    }
                },
                aoColumns: typeof (configParam.aoColumns) == "undefined" ? null : configParam.aoColumns,
                order: typeof (configParam.order) == "undefined" ? [] : configParam.order,
                fnRowCallback: typeof (configParam.fnRowCallback) == "undefined" ? null : configParam.fnRowCallback,
                columnDefs: typeof (configParam.columnDefs) == "undefined" ? false : configParam.columnDefs

            });
        } catch (err) {
            alertError("Ocurrio un error inesperado");
            console.log(err);
        }
    }

    configDataTable.clearFilter = function (reload) {
        dt_extra_params = {};
    }

    configDataTable.extra_params = function (params) {
        dt_extra_params = params;
    }


    /** Funcion para evitar que ingrese Letras */
    function soloNumeros(e,id) {

        // capturamos la tecla pulsada
        var teclaPulsada=window.event ? window.event.keyCode:e.which;

        // capturamos el contenido del input
        var valor=id.value;

        // devolvemos true o false dependiendo de si es numerico o no
        return /\d/.test(String.fromCharCode(teclaPulsada));
    }


    /** Metodo para Cargar Vistas */
    $(document).off("click", ".optionMenu").on('click', '.optionMenu', clickOpcionMenu);

    function clickOpcionMenu(e) {

        var _token= $('input[name=_token]').val();
        e.preventDefault();
        e.stopPropagation();
        var vista = $(this).attr("href");
        $.ajax({
            url: window.location.pathname,
            method: 'POST',
            data:{
                _token:_token,
                vista:vista},
            success: function (response) {
                if(response==-1)
                {
                    alertError("Sesion Expirada");
                    window.location.href = '/login';
                }
                else
                {
                    $(".row").empty();
                    $(".row").html(response);
                }
            },
            error: function (err) {
                if (err.status == 403) {
                    location.reload();
                } else {
                    alertError("Ocurrio un error al ejecutar la accion");
                }
            }
        })
    }


    /**
     * Asigna a los input cuya propiedad type-input es igual a date el calendario datepicker
     */
    function setTypeDate() {
        if (is.desktop()) {
            //Configurar el ditepicker en español
            $.datepicker.regional['es'] =
                {
                    closeText: 'Cerrar',
                    prevText: 'Previo',
                    nextText: 'Próximo',

                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
                        'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    dateFormat: 'dd/mm/yy', firstDay: 0,
                    initStatus: 'Selecciona la fecha', isRTL: false
                };
            $.datepicker.setDefaults($.datepicker.regional['es']);

            //asignarle al input el calendario
            $('input[type-input="date"]').attr("type", "text");
            $('input[type-input="date"]').datepicker({
                changeMonth: true,
                changeYear: true,
                minDate: new Date("1920/01/01")
            });
            $(".ui-datepicker-month").css("color", "#444");
            $(".ui-datepicker-year").css("color", "#444");
        } else {
            $('input[type-input="date"]').attr("type", "date");
        }

        $(document).on("click", 'input[type-input="date"]', function () {
            if ($(this).hasClass("hasDatepicker"))
                return
            else {
                $(this).datepicker({
                    changeMonth: true,
                    changeYear: true
                });
                $(this).focus();
                $(".ui-datepicker-month").css("color", "#444");
                $(".ui-datepicker-year").css("color", "#444");
            }
        });

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    }

    /*******************  Funciones de Usuario en session *****************************************/

    /** Funcion para cerrar session */
    function loginOut() {
        showLoad(true);
        alertSuccess("Cerrando session");

        /** Detiene , para mostrar alertSucess  */
        setTimeout(function () {
            window.location.href = '/login';
            showLoad(False);
        }, 200);

    }

    /** Funcion para validar credenciales del usuario */
    function login() {

        var user= $('#user').val(); /** Token obligatorio en ajax */
        var password=  $('#password').val();
        password=Base64.encode(password);/** Encripta password */
        var _token= $('input[name=_token]').val();

        showLoad(true);
        $.ajax({
            type: 'POST',
            url: '/login/in', //llamada a la ruta
            data: {
                _token:_token,
                password:password ,
                user: user
            },
            success: function(data){
                showLoad(false);

                if (data==0)
                    alertError("Credenciales no validas");
                else
                {
                    if (data!=1)
                    {
                        if (data==3)
                        {
                            alertSuccess("El usuario aun no ha confirmado el correo electronico");
                            $('#user').val("");
                            $('#password').val("");
                        }
                        else
                        {
                            alertError("El usuario esta desactivado");
                            $('#user').val("");
                            $('#password').val("");
                        }
                    }
                    else
                    {
                        alertSuccess("Credenciales Validadas");
                        /** Detiene , para mostrar alertSucess  */
                        setTimeout(function(){
                            window.location.href='/';
                        }, 200);
                    }

                }
            },
            error : function(err){
                showLoad(false);
                alertError(err.responseText);
            }

        });


    }

    /** Funcion que recupera datos del usuario para modificar*/
    function editarUsuario() {
        var _token = $('input[name=_token]').val();
        showLoad(true);
        $.ajax({
            type: 'POST',
            url: '/datos/usuario', //llamada a la ruta
            data: {
                _token: _token
            },
            success: function (data) {
                $('#usuario').val(data[0].usuario);
                pass = data[0].pass;
                $('#phone').val(data[0].telefono);
                select.setCountry(data[0].iso2);
                $('#correo').val(data[0].correo);
                $('#correo').attr("data-correo",data[0].correo);
                showLoad(false);
            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

    }

    /** Funcion que guardar datos de usuario a modificar*/
    function guardarUsuario() {

        var ok = true;
        var iso=select.getSelectedCountryData().iso2;
        var _token = $('input[name=_token]').val();
        var usuario = $('#usuario').val();
        var telefono = $('#phone').val();
        var correo = $('#correo').val();
        var correo_old=$('#correo').attr("data-correo");
        var pass_now = $('#pass_now').val();
        var pass_new = $('#pass_new').val();
        var pass_confirm = $("#pass_new_confirm").val();

        if (pass_new !="") {
            if (pass_confirm !== pass_new) {
                alertError("Las contraseñas no coiciden");
                ok = false;
            }
        }

        if ( pass_now!="")
        {
            if(ok == true)
            {
                alertConfirm("¿Está seguro que desea guardar?", function (e) {
                    showLoad(true);
                    $.ajax({
                        type: 'POST',
                        url: '/datos/modificaUsuario', //llamada a la ruta
                        data: {
                            _token:_token,
                            usuario:usuario,
                            correo:correo.trim(),
                            correo_old:correo_old,
                            telefono:telefono,
                            pass_new:Base64.encode(pass_new),
                            pass_now:Base64.encode(pass_now),
                            iso:iso
                        },
                        success: function (data) {
                            showLoad(false);
                            if (data.error) {
                                alertError(data.mensaje);
                                return;
                            }
                            else
                            {
                                alertSuccess("Se ha actualizado la información");
                                setTimeout(function(){
                                    window.location.href='';
                                    showLoad(false);
                                },200);
                            }
                        },
                        error: function (err) {
                            alertError(err.responseText);
                            showLoad(false);
                        }

                    });
                });
            }
        }
        else
            alertError("Favor ingrese contraseña actual para efectuar cambios");

    }

    /** Funcion para activar el button guardar al hacer click (Login) */
    function pulsar(e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            var boton = document.getElementById("btnEntrar");
            boton.click();
        }
    }

    function registrarUsuario() {

        var iso=select.getSelectedCountryData().iso2;
        var _token = $('input[name=_token]').val();
        var usuario = $('#txt_usuario').val();
        var correo = $('#txt_correo').val();
        var telefono = $('#phone').val();
        var pass = $('#txt_pass').val();
        pass = Base64.encode(pass);

        if (usuario != "" && correo != "" && telefono != "" && pass != "") {
            showLoad(true);
            $.ajax({
                type: 'POST',
                url: '/registro/usuario', //llamada a la ruta
                data: {
                    _token: _token,
                    usuario: usuario,
                    correo: correo,
                    telefono: telefono,
                    pass: pass,
                    iso:iso
                },
                success: function (data) {
                    switch (data) {
                        case 1:
                            alertSuccess("Se ha enviado un correo de confirmacion");
                            /** Detiene , para mostrar alertSucess  */
                            setTimeout(function () {
                                window.location.href = '/login';
                            }, 200); break;

                        case 0:
                            alertSuccess("El correo ya esta siendo usado por otro usuario"); break;

                        case 2:
                            alertSuccess("El nombre de usuario ya esta siendo usado"); break;
                        default:
                            alertSuccess("Error desconocido"); break;
                    }
                    showLoad(false);

                },
                error: function (err) {
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
        _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

        // public methodo para codificiar
        encode: function (input) {
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
        decode: function (input) {
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
        _utf8_encode: function (string) {
            string = string.replace(/\r\n/g, "\n");
            var utftext = "";

            for (var n = 0; n < string.length; n++) {

                var c = string.charCodeAt(n);

                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if ((c > 127) && (c < 2048)) {
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
        _utf8_decode: function (utftext) {
            var string = "";
            var i = 0;
            var c = c1 = c2 = 0;

            while (i < utftext.length) {

                c = utftext.charCodeAt(i);

                if (c < 128) {
                    string += String.fromCharCode(c);
                    i++;
                }
                else if ((c > 191) && (c < 224)) {
                    c2 = utftext.charCodeAt(i + 1);
                    string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                    i += 2;
                }
                else {
                    c2 = utftext.charCodeAt(i + 1);
                    c3 = utftext.charCodeAt(i + 2);
                    string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                    i += 3;
                }

            }

            return string;
        }

    }

    /********************************************************************************************** */


    function verificar_cedula(input)
    {
        var valor=input.value;
        valor = valor.split("-")
        valor=valor[0]+valor[1]+valor[2]

        var  ced1=valor;
        let  ced2=valor;
        let  ced3=valor;
        ced1=ced1.substr(0,3);
        ced2=ced2.substr(3,6);
        ced3=ced3.substr(9,5);
        let band= false;

        if(valor!="")
        {
            if ((ced1.length<3) || (ced2.length<6) || (ced3.length<5) || (valor.length!=14))
            {
                input.value="";
                alertError("Cedula debe tener 14 digitos")
            }
            else
            {
                var union=ced1+"-"+ced2+"-"+ced3;
                if (validar_cedula(union)==false)
                {
                    alertError("Cedula invalida");
                    input.value="";
                }
            }
        }
        return band
    }


    /**
     *Valida numeros de cedula nicaraguense correctos
     * @param {string}  numero de cedula separado por guiones
     * @return verdadero o falso
     */
    function validar_cedula(num_ced) {
        if (num_ced.length == 16) {
            var letras = new Array("A", "B", "C", "D", "E", "F", "G", "H", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y");
            tfecha = new String;
            partes = num_ced.split("-");
            tfecha = partes[1];
            dia = tfecha.substr(0, 2);
            mes = tfecha.substr(2, 2);
            anno = tfecha.substr(4, 2);
            conletra = partes[2];
            sinletras = conletra.substr(0, 4);
            num_ced = partes[0] + partes[1] + sinletras;
            letra = conletra.substr(4, 1);
            letra = letra.toUpperCase();
            p1 = num_ced / 23;
            temporal = parseInt(p1);
            digito = num_ced - (temporal) * 23;

            if (letras[digito] == letra) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /** Funcion para agregar fila */
    $(document).off("change", "#cmb_sexo").on("change", "#cmb_sexo" , function () {

        if (this.value=='F')
            $('#imgsexo').prop('src','LDCI/img/userF.png');
        else
            $('#imgsexo').prop('src','LDCI/img/userM.png');
    });

    /** Funcion  par aplicar formato (Dinero)*/
    function number_format(amount, decimals) {
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

    /** Funcion para Validar Correo Y evitar rebotes en servidor de Correo*/
    function CorreoVerify(input)
    {

       /** Validacion Utilizando api mailboxlayer */
        var correo=input.value;

        $.get( "https://apilayer.net/api/check", { email: correo, access_key : "0f19511937cbc3c4b9ee95205e91641d" } )
            .done(function( data ) {

                if (data.format_valid==true && data.mx_found==true && data.smtp_check==true  )
                    alertSuccess( "Correo Valido");
                else
                {
                    alertError( "Correo No Valido");
                    input.value="";
                }
                console.log(data);
            });

    }

    /** Funcion para validar Contraseña Segura */
    function validar_clave(input)
    {
        var  contrasenna=input.value
        if(contrasenna.length >= 8)
        {
            var mayuscula = false;
            var minuscula = false;
            var numero = false;
            var caracter_raro = false;

            for(var i = 0;i<contrasenna.length;i++)
            {
                if(contrasenna.charCodeAt(i) >= 65 && contrasenna.charCodeAt(i) <= 90)
                {
                    mayuscula = true;
                }
                else if(contrasenna.charCodeAt(i) >= 97 && contrasenna.charCodeAt(i) <= 122)
                {
                    minuscula = true;
                }
                else if(contrasenna.charCodeAt(i) >= 48 && contrasenna.charCodeAt(i) <= 57)
                {
                    numero = true;
                }
                else
                {
                    caracter_raro = true;
                }
            }
            if(mayuscula == true && minuscula == true && caracter_raro == true && numero == true)
            {
                return true;
            }
            else
            {
                alertError("La contraseña debe posser al menos una letra Mayuscula, letras minusculas , un numero y un caractrer especial")
                input.value="";
            }
        }
        else
            alertError("La contraseña debe posser al menos 8 caracteres")
            input.value="";
    }

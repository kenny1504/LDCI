
$(document).ready(function () {

    showLoad(true);

    /** Recupera id de productos */
    $.ajax({
        type: 'POST',
        url: '/producto/getProducto', //llamada a la ruta
        data: {
            _token:$('input[name=_token]').val()
        },
        success: function (data) {

            if (Object.entries(data).length==0)
            {

                  var animacion="<div class=\"bb\"></div>"

                $('#principal').append(animacion);
                showLoad();
                alertError("Nos quedamos sin productos :O")
            }
                else
            {
                data.forEach(element => {

                    var id_producto=element.id_producto
                    var precio=element.precio
                    /** Recupera todas las imagenes de un producto */
                    $.ajax({
                        type: 'POST',
                        url: '/producto/getProductoImagenes', //llamada a la ruta
                        data: {
                            _token:$('input[name=_token]').val(),
                            id_producto:id_producto
                        },
                        success: function (data) {

                            var carousel="#listbox"+id_producto;
                            var carou="<figure   class=\"figure tag tag-sale figure"+id_producto+"\">"+
                                "</figure>" +
                                "<div id=\"carousel"+id_producto+"\" class=\"carousel slide\" data-ride=\"carousel\">\n" +
                                "    <ol class=\"carousel-indicators\">\n" +
                                "        <li data-target=\"#carousel"+id_producto+"\" data-slide-to=\"0\" class=\"active\"></li>\n" +
                                "        <li data-target=\"#carousel"+id_producto+"\" data-slide-to=\"1\"></li>\n" +
                                "        <li data-target=\"#carousel"+id_producto+"\" data-slide-to=\"2\"></li>\n" +
                                "    </ol>\n" +
                                "    <div id=\"listbox"+id_producto+"\" class=\"carousel-inner\">\n" +
                                "    </div>\n" +
                                "    <a class=\"carousel-control-prev\" href=\"#carousel"+id_producto+"\" role=\"button\" data-slide=\"prev\">\n" +
                                "        <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>\n" +
                                "        <span class=\"sr-only\">Previous</span>\n" +
                                "    </a>\n" +
                                "    <a class=\"carousel-control-next\" href=\"#carousel"+id_producto+"\" role=\"button\" data-slide=\"next\">\n" +
                                "        <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>\n" +
                                "        <span class=\"sr-only\">Next</span>\n" +
                                "    </a>\n" +
                                "</div>"

                            /** Añadiendo precio a etiqueta*/
                            carou+="<style>\n" +
                                "    .figure.tag-sale.figure"+id_producto+"::before{\n" +
                                "        content: \"$"+precio+"\";\n" +
                                "        background: #00d95a;\n" +
                                "    }\n" +
                                "</style>"

                            $('#principal').append(carou);

                            var html='',control=1;
                            /** recorre arreglo (Rutas de imagenes de un producto) */
                            data.forEach(element => {

                                if(control==1)
                                {
                                    html+="<div class=\"carousel-item active\">\n" +
                                        "            <img style='width: 70% !important' class=\"d-block w-100\" src="+element.url+"/"+element.imagen+" alt=\"First slide\">\n" +
                                        "<div class=\"carousel-caption d-none d-md-block\">\n" +
                                        "    <h5>"+element.nombre+"</h5>\n" +
                                        "<p>"+element.descripcion+"</p>"+
                                        "  </div>" +
                                        " </div>"
                                }else
                                {
                                    html+="<div class=\"carousel-item\">\n" +
                                        "            <img style='width: 70% !important' class=\"d-block w-100\" src="+element.url+"/"+element.imagen+" alt=\"First slide\">\n" +
                                        "<div class=\"carousel-caption d-none d-md-block\">\n" +
                                        "    <h5>"+element.nombre+"</h5>\n" +
                                        "<p>"+element.descripcion+"</p>"+
                                        "  </div>" +
                                        " </div>"
                                }
                                control++;

                            });

                            $(carousel).append(html);
                            showLoad(false);

                        },
                        error: function (err) {
                            alertError(err.responseText);
                            showLoad(false);
                        }
                    });
                })
            }
        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }
    });

});


var letra="<p></p>"

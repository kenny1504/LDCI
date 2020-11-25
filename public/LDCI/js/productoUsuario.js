
$(document).ready(function () {

    /** Recupera id de productos */
    $.ajax({
        type: 'POST',
        url: '/producto/getProducto', //llamada a la ruta
        data: {
            _token:$('input[name=_token]').val()
        },
        success: function (data) {

            data.forEach(element => {

                var id_producto=element.id_producto
                  /** Recupera todas las imagenes de un producto */
                    $.ajax({
                        type: 'POST',
                        url: '/producto/getProductoImagenes', //llamada a la ruta
                        data: {
                            _token:$('input[name=_token]').val(),
                            id_producto:id_producto
                        },
                        success: function (data) {

                         var carousel="carousel"+id_producto;
                           var carou=("<div class=\"col-sm-6 col-lg-4 mg-t-20 mg-lg-t-0\">\n" +
                                "    <div class=\"card bd-0\">\n" +
                                "        <div id=\"carousel"+id_producto+"\" class=\"carousel slide\" data-ride=\"carousel\">\n" +
                                "            <ol class=\"carousel-indicators\">\n" +
                                "                <li data-target=\"#carousel"+id_producto+"\" data-slide-to=\"0\" class=\"\"></li>\n" +
                                "                <li data-target=\"#carousel"+id_producto+"\" data-slide-to=\"1\" class=\"\"></li>\n" +
                                "                <li data-target=\"#carousel"+id_producto+"\" data-slide-to=\"2\" class=\"active\"></li>\n" +
                                "            </ol>\n" +
                                "            <div id='listbox' style=\"margin-top: 5%;\" class=\"carousel-inner\" role=\"listbox\">\n" +
                                "            </div><!-- carousel-inner -->\n" +
                                "        </div><!-- carousel -->\n" +
                                "    </div><!-- card -->\n" +
                                "</div>");

                            $('#principal').append(carou);

                            var html=''
                            /** recorre arreglo (Rutas de imagenes de un producto) */
                            data.forEach(element => {

                                 html+="<div class=\"carousel-item\">\n" +
                                    "                    <div style=\'background-image: url("+element.url+"/"+element.imagen+");\' class=\"bg-purple pd-30 ht-300 d-flex pos-relative align-items-center rounded\">\n" +
                                    "                        <div class=\"tx-white\">\n" +
                                    "                            <p class=\"tx-uppercase tx-11 tx-medium tx-mont tx-spacing-2 tx-white-5\">Recent Article</p>\n" +
                                    "                            <h5 class=\"lh-5 mg-b-20\">10 Reasons Why Travel Makes You a Happier Person</h5>\n" +
                                    "                            <nav class=\"nav flex-row tx-13\">\n" +
                                    "                                <a href=\"\" class=\"tx-white-8 hover-white pd-l-0 pd-r-5\">Edit</a>\n" +
                                    "                                <a href=\"\" class=\"tx-white-8 hover-white pd-x-5\">Unpublish</a>\n" +
                                    "                                <a href=\"\" class=\"tx-white-8 hover-white pd-x-5\">Delete</a>\n" +
                                    "                            </nav>\n" +
                                    "                        </div>\n" +
                                    "                    </div><!-- d-flex -->\n" +
                                    "                </div>"
                            });

                            $('#listbox').append(html);

                        },
                        error: function (err) {
                            alertError(err.responseText);
                            showLoad(false);
                        }
                    });
            })

        },
        error: function (err) {
            alertError(err.responseText);
            showLoad(false);
        }
    });

});

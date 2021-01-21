var tblProducto = null;
var estado=null; //Variable para control (Eliminar imagen)
var img=null;

    $(document).ready(function () {

        listarProducto();

        /** Configuraciones para subir imagen */
        /** Funcion que permite actualizar o agregar un nuevo registro */
        Dropzone.discover(

            Dropzone.options.imageUpload = {
                autoProcessQueue: false,//Para evitar que guarde en el servidor
                uploadMultiple: true,
                parallelUploads: 3,
                maxFiles: 3, //archivos permitidos
                addRemoveLinks: true, //Botton eliminar
                acceptedFiles:'.jpeg,.jpg,.png,.gif',
                init: function() {

                    var myDropzone = this;

                    document.getElementById('btnGuardarProducto').addEventListener("click", function(e) {

                        var nombre= $('#txt_nombre').val();
                        var existencia= $('#txt_existencia').val();
                        var precio= $('#txt_precio').val();
                        var descripcion= $('#txt_descripcion').val();

                        if (nombre!="" && existencia!="" && precio!="" && descripcion!="" && myDropzone.files.length!=0)
                        {
                            alertConfirm("¿Está seguro que desea guardar?", function (ev) {
                                showLoad(true);
                                e.preventDefault();
                                e.stopPropagation();
                                myDropzone.processQueue();
                            });
                        }
                        else
                            alertError("Favor completar campos y/o añadir imagenes");

                    });

                    /** Recupera respuesta si es exitosa*/
                    this.on("successmultiple", function(files, response) {
                        showLoad(false);
                        alertSuccess(response.mensaje);
                        this.removeAllFiles();//elimina imagenes en dropzone
                        $('#btnlimpiar').click();

                    });

                    /** Recupera respuesta si es fallida*/
                    this.on("errormultiple", function(files, response) {
                        alertError(response.mensaje);
                    });

                    /**Valida que no sea mas de 3 archivos */
                    this.on("maxfilesexceeded", function(file){
                        alertError("Excedio el limite de imagenes, imagenes permitidas 3")
                    });

                },
                maxfilesexceeded: function (files) {
                    this.removeFile(files); //Remueve el archivo (Imagen) si execede el limite permitido
                },
            }
        ); //Rastrea el documento

    });

    /** Funcion que lista todos los registro de productos */
    function listarProducto() {

        var _token= $('input[name=_token]').val();

        tblProducto = setDataTable("#tblProducto", {
            ajax: {
                type: 'POST',
                url: '/producto/getAll', //llamada a la ruta
                data: {
                    _token:_token
                },
            },
            columnDefs: [
                {
                    targets: 4,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        $Existenca =json[4];
                        if ($Existenca!=0)
                            return '<span class="label success">'+$Existenca+'</span>';
                        else
                            return '<span class="label danger">'+$Existenca+'</span>';
                    }
                },
                {
                    targets: 5,
                    data: null,
                    orderable: false,
                    render: function (json) {
                        $tipo =json[5];
                        if ($tipo==1)
                            return '<span class="label  warning">Producto</span>';
                        else
                            return '<span class="label info">Servicio</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    defaultContent: '<i class="btn btn-info fa fa-edit" title="Selecciona el registro" onclick="selectProducto(this)"></i>'
                }
            ]
        });

    }

    /** Selecciona el producto y carga valores en formulario */
    function selectProducto(datos) {

        showLoad(true);

        var tr = $(datos).parents("tr")
        var data = tblProducto.row(tr).data();
        $('#btnEliminarProducto').removeAttr('disabled');

        //Capturamos valores de tabla
        Producto = {
            id_producto: data[0],
            nombre:data[1],
            descricion:data[2],
            precio:data[3],
            existencia:data[4],
            tipo:data[5],
            iva:data[6]
        };

        //Asignamos valores a formulario
        $('#id_Producto').val(Producto.id_producto);
        $('#txt_nombre').val(Producto.nombre);
        $('#txt_existencia').val(Producto.existencia);
        $('#txt_precio').val(Producto.precio);
        $('#txt_descripcion').val(Producto.descricion);

        var checkbox=document.getElementById('cktipo');

        /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
        if (Producto.tipo==2)
        {
            if (checkbox.checked == false)
                $('#cktipo').click();
        }
        else
        {
            if (checkbox.checked == true)
                $('#cktipo').click();
        }

        var checkbox2=document.getElementById('ckiva');

        /** Verifica si ya esta activado el checkbox, de lo contrario lo activa */
        if (Producto.iva==true)
        {
            if (checkbox2.checked == false)
                $('#ckiva').click();
        }
        else
        {
            if (checkbox2.checked == true)
                $('#ckiva').click();
        }

        /** Carga imagenes del producto seleccionado */
        $.ajax({
            type: 'POST',
            url: '/producto/fotos', //llamada a la ruta
            data: {
                _token:$('input[name=_token]').val(),
                id_producto:Producto.id_producto
            },
            success: function (data) {

                $('.dz-preview').remove()
                data.forEach(element => {

                    /**Ruta donde se gurda imagen */
                    var file_image = element.url+'/'+element.nombre;
                    /**Archivo (Imagen) */
                    var mockFile = { name: element.nombre, size: 12345 };

                    var myDropzone = Dropzone.forElement(".dropzone");
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, file_image);

                     /** Redimenciona Imagen */
                    $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});

                    /** Evento para Eliminar  imagen del servidor y base de datos */
                    myDropzone.on("removedfile", function(file){

                        /** Nombre de la imagen */
                        var archivo=file.name

                        /** Verifica para evitar que se hagan muchas peticiones de una misma imagen*/
                        if(img!=archivo)
                            estado=true

                          img=archivo
                           if(estado==true)
                           {
                               $.ajax({
                                   type: 'POST',
                                   url: '/producto/eliminarImagen', //llamada a la ruta
                                   data: {
                                       _token:$('input[name=_token]').val(),
                                       imagen:archivo
                                   },
                                   success: function (data) {
                                       showLoad(false);
                                       if(data.error)
                                           alertError(data.mensaje);
                                       else
                                       if(data.mensaje!="")
                                           alertSuccess(data.mensaje);
                                   },
                                   error: function (err) {
                                       alertError(err.responseText);
                                       showLoad(false);
                                   }
                               });
                               estado=false
                           }
                    });
                });
                showLoad(false);

            },
            error: function (err) {
                alertError(err.responseText);
                showLoad(false);
            }

        });

    }

    /** Funcion para eliminar registro*/
    function eliminar()
    {
        var id_Producto= $('#id_Producto').val();
        var _token = $('input[name=_token]').val();

        if (id_Producto!="")
        {
            alertConfirm("¿Está seguro que desea eliminar?", function (e) {
                showLoad(true);
                $.ajax({
                    type: 'POST',
                    url: '/producto/eliminar', //llamada a la ruta
                    data: {
                        _token:_token,
                        id_Producto:id_Producto
                    },
                    success: function (data) {
                        showLoad(false);
                        if (data.error) {
                            alertError(data.mensaje);
                        }
                        else
                        {
                            alertSuccess(data.mensaje);
                            $('#btnlimpiar').click();
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



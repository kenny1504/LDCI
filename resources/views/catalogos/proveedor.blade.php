<div class="col-md-10 col-md-offset-2">
    <div class="row" style="margin-left: 12%;" >
        <div class="box box-success">
            <div class="box-heading">
                <div class="row"></div>
            </div>
            <div class="box-body">
                <div class="row" style="margin: 2%">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-primary">
                                    <legend class="text-primary">Información de Proveedor</legend>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">No.Proveedor</label>
                                    <div class="input-group">
                                        <input disabled type="text" id="id_proveedor" name="id_proveedor" class="form-control input-md">
                                        <span class="input-group-btn">
                                            <button onclick="listarProveedores()" class="btn btn-default" data-toggle="modal" data-target="#ModalProveedores"
                                                    id="btnBuscarProveedor" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <img class="img-responsive" width="100px"
                            src="LDCI/img/buildings.png" alt="">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txt_nombres">Nombre</label>
                            <input type="text" id="txt_nombre"  name="txt_nombre" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txt_pagina_web">Dirección de Pagina Web</label>
                            <input type="text" id="txt_pagina_web" name="txt_pagina_web"  class="form-control input-md">
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 2%">
                    <div class="col-md-12">
                        <h5 class="text-primary">
                            <legend class="text-primary">Datos de Contacto</legend>
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_direccion">Dirección</label>
                            <input type="text" id="txt_direccion" name="txt_direccion" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cmb_Pais">Pais</label>
                            <select name="cmb_Pais"  id="cmb_Pais" class="form-control input-md">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="txt_correo">Correo</label>
                            <input type="text" id="txt_correo" name="txt_correo" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txt_telefono_1">Telefono N#1</label>
                            <input onkeypress="return soloNumeros(event,txt_telefono_1);" type="tel" required id="txt_telefono_1" maxlength="8" name="txt_telefono_1" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txt_telefono_2">Telefono N#2</label>
                            <input onkeypress="return soloNumeros(event,txt_telefono_2);"  type="tel" id="txt_telefono_2" maxlength="8" name="txt_telefono_2" class="form-control input-md">
                        </div>
                    </div>
                </div>
            <div class="box-footer text-center">
                <div class="col-md-12">
                    <button onclick="guardar()" class="btn btn-success" id="btnGuardarProveedor">
                        <i class="fa fa-save"> </i> Guardar
                    </button>
                    <button disabled onclick="eliminar()" class="btn btn-danger" id="btnEliminarProveedor">
                        <i class="fa fa-trash-o"> </i> Eliminar
                    </button>
                    <button title="Limpiar formulario" onclick="resetForm()" class="btn btn-warning" ><i class="fa fa-recycle"></i> Limpiar</button>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>


    <div id="ModalProveedores" class="modal fade" role="document" >
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="align-self: flex-end;" >
                    <a type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="box box-success">
                        <div class="box-heading text-success">
                            <div class="row"></div>
                            <h4 align="center">Busqueda de Registro</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive" >
                                <table id="tblProveedores" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Seleccione</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- js -->
<script src="{{asset("LDCI/js/proveedor.js")}}" ></script>

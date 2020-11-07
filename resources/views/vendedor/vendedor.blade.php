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
                                    <legend class="text-primary">Información Personal</legend>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">No.Empleado</label>
                                    <div class="input-group">
                                        <input type="text" id="id_empleado" name="id_empleado" class="form-control input-md">
                                        <span class="input-group-btn">
                                            <button onclick="listarVendedores()" class="btn btn-default" data-toggle="modal" data-target="#ModalVendedores"
                                                    id="btnBuscarEmpleado" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <img class="img-responsive" width="100px"
                             src="LDCI/img/user.png" alt="">
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Nombres</label>
                            <input type="text" id="nombres"  name="nombres" class="form-control input-md">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Apellido 1</label>
                            <input type="text" id="apellido1"  name="apellidos" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Apellido 2</label>
                            <input type="text" id="apellido2"  name="apellidos" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Edad</label>
                            <input type="text" id="edad" name="edad"  class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Sexo</label>
                            <select name="sexo" id="sexo"  class="form-control input-md">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Estado Civil</label>
                            <select name="estado_civil"  id="estado_civil" class="form-control input-md">
                                <option value="1">Casado/a</option>
                                <option value="2">Divoriciado/a</option>
                                <option value="3">Unión Libre</option>
                                <option value="4">Soltero/a</option>
                                <option value="5">Viudo/a</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Cédula Nacional</label>
                            <input type="text" name="cedula"  id="cedula" class="form-control input-md">
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
                            <label for="">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Departamento</label>
                            <select name="SelectDepartamento"  id="SelectDepartamento" class="form-control input-md">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Correo</label>
                            <input type="text" id="correo" name="correo" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Telefono Domicilio</label>
                            <input type="text" id="telfono_1" maxlength="8" name="telfono_1" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Telefono Personal</label>
                            <input type="text" id="telfono_2" maxlength="8" name="telfono_2" class="form-control input-md">
                        </div>
                    </div>
                </div>
                <div class="row" style="margin: 2%">
                    <div class="col-md-12">
                        <h5 class="text-danger">
                            <legend class="text-danger">En caso de emergencia</legend>
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Notificar a</label>
                            <input type="text" id="nomb_notifica" name="nomb_notifica" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Telefono</label>
                            <input type="text" maxlength="8" id="txt_telefono" name="txt_telefono" class="form-control input-md">
                        </div>
                    </div>
                </div >
            </div>
            <div class="box-footer text-center">
                <div class="col-md-12">
                    <button onclick="guardar()" class="btn btn-success" id="btnGuardarEmpleado">
                        <i class="fa fa-save"> </i> Guardar
                    </button>
                    <button disabled onclick="" class="btn btn-danger" id="btnEliminarEmpleado">
                        <i class="fa fa-trash-o"> </i> Eliminar
                    </button>
                    <button onclick="resetForm()" class="btn btn-warning" ><i class="fa fa-recycle"></i> Limpiar</button>
                   <br><br>
                </div>
            </div>
        </div>
    </div>
</div>


    <div id="ModalVendedores" class="modal fade" role="document" >
        <div class="modal-dialog modal-lg" style="width: 1400px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="align-self: flex-end;" >
                    <button type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="box box-success">
                        <div class="box-heading text-success">
                            <div class="row"></div>
                            <h4 align="center">Busqueda de Registro</h4>
                        </div>
                        <div class="box-body">
                            <table id="tblVendedores" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Cedula</th>
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

<!-- js -->
<script src="{{asset("LDCI/js/vendedor.js")}}" ></script>

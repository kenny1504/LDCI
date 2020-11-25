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
                                    <legend class="text-primary">Información</legend>
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">No.Cliente</label>
                                    <div class="input-group">
                                        <input disabled type="text" id="id_empleado" name="id_empleado" class="form-control input-md">
                                        <span class="input-group-btn">
                                            <button onclick="listarVendedores()" class="btn btn-default" data-toggle="modal" data-target="#ModalVendedores"
                                                    id="btnBuscarEmpleado" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label >Cliente Juridico</label>
                                <div class="form-group">
                                    <label class="switch">
                                        <input onchange="clienteJuridico()" id="ckTipo" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <img class="img-responsive" width="100px"
                             src="LDCI/img/80652.JPG" alt="">
                    </div>

                        <div hidden class="juridico col-md-8">
                            <div class="form-group">
                                <label for="txt_nombreEmpresa">Nombre Empresa</label>
                                <input type="text" id="txt_nombreEmpresa"  name="txt_nombreEmpresa" class="form-control input-md">
                            </div>
                        </div>
                        <div hidden class="juridico col-md-4">
                            <div class="form-group">
                                <label for="txt_ruc">Ruc</label>
                                <input type="text" id="txt_ruc"  name="txt_ruc" class="form-control input-md">
                            </div>
                        </div>
                        <div hidden class="juridico col-md-8">
                            <div class="form-group">
                                <label for="txt_giroNegocio">Giro de Negocio</label>
                                <input type="text" id="txt_giroNegocio"  name="txt_giroNegocio" class="form-control input-md">
                                <br>
                                <h5 class="text-primary">
                                    <legend class="text-primary">Representante</legend>
                                </h5>
                            </div>
                        </div>
                        <div hidden class="juridico col-md-4">
                            <div class="form-group">
                                <label for="txt_telefono_1">Telefono Empresa</label>
                                <input onkeypress="return soloNumeros(event,txt_telefono_1);"  type="tel" id="txt_telefono_1" maxlength="8" name="txt_telefono_2" class="form-control input-md">
                            </div>
                        </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txt_nombres">Nombres</label>
                            <input type="text" id="txt_nombres"  name="txt_nombres" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txt_apellido1">Apellido 1</label>
                            <input type="text" id="txt_apellido1"  name="txt_apellido1" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txt_apellido2">Apellido 2</label>
                            <input type="text" id="txt_apellido2"  name="txt_apellido2" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="txt_edad">Edad</label>
                            <input type="text" id="txt_edad" name="txt_edad"  class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cmb_sexo">Sexo</label>
                            <select name="cmb_sexo" id="cmb_sexo"  class="form-control input-md">
                                <option selected disabled value="">Seleccione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cmb_estado_civil">Estado Civil</label>
                            <select name="cmb_estado_civil"  id="cmb_estado_civil" class="form-control input-md">
                                <option selected disabled value="">Seleccione</option>
                                <option value="1">Casado/a</option>
                                <option value="2">Divorciado/a</option>
                                <option value="3">Unión Libre</option>
                                <option value="4">Soltero/a</option>
                                <option value="5">Viudo/a</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="txt_cedula">Cédula Nacional</label>
                            <input placeholder="001-000000-0000A" onblur="verificar_cedula(this)" type="text" name="txt_cedula"  id="txt_cedula" class="form-control input-md">
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
                            <label for="cmb_Departamento">Departamento</label>
                            <select name="cmb_Departamento"  id="cmb_Departamento" class="form-control input-md">
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
                            <label for="txt_telefono_2">Telefono</label>
                            <input onkeypress="return soloNumeros(event,txt_telefono_2);" type="tel" required id="txt_telefono_2" maxlength="8" name="txt_telefono_1" class="form-control input-md">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-center">
                <div class="col-md-12">
                    <button onclick="guardar()" class="btn btn-success" id="btnGuardarEmpleado">
                        <i class="fa fa-save"> </i> Guardar
                    </button>
                    <button disabled onclick="eliminar()" class="btn btn-danger" id="btnEliminarEmpleado">
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
<script src="{{asset("LDCI/js/cliente.js")}}" ></script>




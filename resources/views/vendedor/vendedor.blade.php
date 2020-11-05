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
                                            <button class="btn btn-default" data-toggle="modal" data-target="#mdbBuscarEmpleado"
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
                            <input type="text" id="nombres"  readonly name="nombres" class="form-control input-md">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Apellido 1</label>
                            <input type="text" id="apellido1" readonly name="apellidos" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Apellido 2</label>
                            <input type="text" id="apellido2" readonly name="apellidos" class="form-control input-md">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Edad</label>
                            <input type="text" id="edad" name="edad" readonly class="form-control input-md" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Sexo</label>
                            <select name="sexo" id="sexo" readonly="" class="form-control input-md">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Estado Civil</label>
                            <select name="estado_civil" readonly="" id="estado_civil" class="form-control input-md">
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
                            <input type="text" name="cedula" readonly id="cedula" class="form-control input-md">
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
                            <select name="id_departamento" readonly="" id="id_departamento" class="form-control input-md">
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
                            <input type="text" maxlength="8" id="telf_notifica" name="telf_notifica" class="form-control input-md">
                        </div>
                        <input type="hidden" readonly id="id_contrato_anterior" name="id_contrato_anterior" class="form-control input-md">
                        <input type="hidden" readonly id="existeContratoHistorico" name="existeContratoHistorico" class="form-control input-md">
                        <input type="hidden" readonly id="nuevoContrato" name="nuevoContrato" class="form-control input-md">
                        <input type="hidden" readonly id="conAdendum" name="conAdendum" class="form-control input-md">
                    </div>
                </div >
            </div>
        </div>
    </div>
</div>

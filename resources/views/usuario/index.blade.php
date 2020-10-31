
@csrf
<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-heading"><h5 class="text-center">Catálogo de Usuarios</h5></div>
        <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_usuario">Código</label>
                            <input name="id_usuario" id="id_usuario" readonly class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label >Estado</label>
                        <div class="form-group">
                            <label class="switch">
                                <input id="ckestado" type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_usuario">Usuario</label>
                            <input name="txt_usuario" id="txt_usuario" class="form-control input-sm" type="text" maxlength="40">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_telefono">Telefono</label>
                            <input id="txt_telefono"  onkeypress="return soloNumeros(event,txt_telefono);" name="txt_telefono" class="form-control" maxlength="25" type="tel">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_correo">Correo</label>
                            <input name="txt_correo" id="txt_correo" class="form-control input-sm" type="email" maxlength="40">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Tipo</label>
                            <select id="selecTipo" name="selecTipo" class="form-control">
                                    <option selected disabled value ="" >Seleccione</option>
                                    <option value ="1">Administrador</option>
                                    <option value ="2">Vendedor</option>
                                    <option value ="3">Cliente</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>
        <div class="box-footer text-right">
            <button class="btn btn-success btn-sm" id="btnGuardarUsuario">
                <i class="fa fa-save"> </i> Guardar
            </button>
            <a onclick="resetForm()" class="btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
        </div>
    </div>
</div>

<div class="col-md-7">
    <div class="box box-success">
        <div class="box-heading">
            <div class="row"></div>
        </div>
        <div class="box-body">
            <div class="row form-group">
                    <div class="col-lg-12">
                        <div id="results" class="table-responsive">
                            <table class="table table-hover table-strippet " id="tblUsuario">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Usuario</th>
                                    <th>Telefono</th>
                                    <th>Estado Correo</th>
                                    <th>Correo</th>
                                    <th></th>
                                    <th>Tipo</th>
                                    <th></th>
                                    <th>Estado</th>
                                    <th>Acción</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- js -->
<script src="{{asset("LDCI/js/usuario.js")}}" ></script>

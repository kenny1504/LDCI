<!--form para poder activar la ruta y poder guardar el registro--><!-- -->
<form id="ingresar_materia" >
    <div class="modal  modal-info fade" id="editar_Usuario" >
              <div class="modal-dialog" >
                <div class="modal-content" >
                    <div class="modal-header"  style="align-self: flex-end;">
                        <a  type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></a>
                      </div>
                        <div class="align-items-center justify-content-center">
                            @csrf
                            <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white rounded shadow-base">
                              <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> Usuario <span class="tx-normal">]</span></div>
                              <br>
                              <div class="form-group">
                                <input  id="usuario"  type="text" class="form-control" placeholder="Ingrese Usuario">
                              </div><!-- form-group -->
                              <div class="form-group">
                                <input id="pass_now" type="password" class="form-control" placeholder="Ingrese Actual Contraseña">
                              </div><!-- form-group -->
                              <div class="form-group">
                                <input id="pass_new" onchange="validar_clave(this)" type="password" class="form-control" placeholder="Ingrese Nueva Contraseña (Opcional)">
                              </div><!-- form-group -->
                              <div class="form-group">
                                <input id="pass_new_confirm" type="password" class="form-control" placeholder="Confirmar contraseña nueva (Opcional)">
                              </div><!-- form-group -->
                              <div class="form-group">
                                  <input id="phone" onkeypress="return soloNumeros(event,phone);" name="phone" class="form-control" maxlength="25" type="tel">
                              </div><!-- form-group -->
                              <div class="form-group">
                                <input id="correo" onchange="CorreoVerify(this)" type="email" class="form-control" placeholder="Correo Electronico">
                              </div><!-- form-group -->
                              <div class="form-group tx-12">Al hacer clic en el botón Guardar a continuación, acepta nuestra política de privacidad y los términos de uso</div>
                              <a id="btnGuardar" onclick="guardarUsuario()" class="btn btn-info btn-block text-white">Guardar</a>
                            </div><!-- login-wrapper -->
                          </div><!-- d-flex -->
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->

    </div>
</form>

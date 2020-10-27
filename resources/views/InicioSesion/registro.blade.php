
    <div class="d-flex align-items-center justify-content-center ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> LDCI <span class="tx-normal">]</span></div>
        <div class="tx-center mg-b-60">LOGISTICA DE CARGA INTERMODAL</div>
        @csrf <!-- esta varible es para TOken, siempre ponerla-->
        <div class="form-group">
          <input type="text" id="txt_usuario" required class="form-control" placeholder="Ingrese Usuario">
        </div><!-- form-group -->
          <div class="form-group">
            <input type="email" id="txt_correo" required class="form-control" placeholder="Ingrese Correo">
          </div><!-- form-group -->
          <div class="form-group">
            <input type="text" id="txt_telefono" name="txt_telefono" onkeypress="return soloNumeros(event,txt_telefono);" required class="form-control" placeholder="Ingrese Telefono" maxlength=" 25">
          </div><!-- form-group -->
        <div class="form-group">
          <input type="password" id="txt_pass" requireds class="form-control" placeholder="Ingrese Contraseña">
        </div><!-- form-group -->
        <button onclick="registrarUsuario();" class="btn btn-info btn-block">Registrarse</button>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

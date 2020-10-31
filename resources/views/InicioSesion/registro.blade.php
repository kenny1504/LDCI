
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
             <input id="phone"  onkeypress="return soloNumeros(event,phone);" name="phone" class="form-control" maxlength="25" type="tel">
          </div><!-- form-group -->
        <div class="form-group">
          <input type="password" id="txt_pass" requireds class="form-control" placeholder="Ingrese Contraseña">
        </div><!-- form-group -->
        <button onclick="registrarUsuario();" class="btn btn-info btn-block">Registrarse</button>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->


    <script>

        var input = document.querySelector("#phone");
        select = window.intlTelInput(input, {
            allowDropdown: true,
            autoHideDialCode: false,
            autoPlaceholder: "off",
            dropdownContainer: document.body,
            formatOnDisplay: false,
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            hiddenInput: "full_number",
            initialCountry: "auto",
            nationalMode: false,
            placeholderNumberType: "MOBILE",
            separateDialCode: true,
            setNumber:351,
            utilsScript: "LDCI/Core/utils.js",
        });

    </script>

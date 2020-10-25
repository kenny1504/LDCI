<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Meta -->
   <meta name="description" content="INTERMODAL LDCI - AGENTE DE CARGA, COURIER Y ADUANA">
   <meta name="author" content="kennysaenz31@gmail.com">

   <title>INTERMODAL LDCI - AGENTE DE CARGA, COURIER Y ADUANA</title>
   <link rel="icon" href="{{asset("assets/bracket/Logo-Intermodal.ico")}}" >

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/font-awesome/css/font-awesome.css")}}" >
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/Ionicons/css/ionicons.css")}}" >

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset("assets/bracket/css/bracket.css")}}" >

     <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset("LDCI/Core/alertify.default.css")}}"  >
    <link rel="stylesheet" href="{{asset("LDCI/Core/alertify.core.css")}}"  >
    <link rel="stylesheet" href="{{asset("LDCI/Core/core.css")}}"  >
    <link rel="stylesheet" href="{{asset("LDCI/Core/jquery-ui.min.css")}}"  >

  </head>

  <body>

         <!--INICIO CONTENEDOR CARGANDO-->
         <div id="loader-wrapper">
          <div id="loader"></div>
          <div class="loader-section section-left"></div>
          <div class="loader-section section-right"></div>
        </div>
        <!--FIN CONTENEDOR CARGANDO-->

    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

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
            <input type="text" id="txt_telefono" required class="form-control" placeholder="Ingrese Telefono" maxlength=" 25">
          </div><!-- form-group -->
        <div class="form-group">
          <input type="password" id="txt_pass" requireds class="form-control" placeholder="Ingrese Contraseña">
        </div><!-- form-group -->
        <button onclick="registrarUsuario();" class="btn btn-info btn-block">Registrarse</button>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->
    <footer class="br-footer">
      <div class="footer-left">
          <div class="mg-b-2">Copyright - 2020. LDCI. All Rights Reserved.</div>
      </div>
  </footer>

    <!-- js Core-->
    <script src="{{asset("LDCI/Core/jquery.min.js")}}" ></script>
    <script src="{{asset("LDCI/Core/jquery.waiting.js")}}" ></script>
    <script src="{{asset("LDCI/Core/jquery-ui.min.js")}}" ></script>

    <script src="{{asset("assets/bracket/lib/popper.js/popper.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/bootstrap/bootstrap.js")}}" ></script>
    
    <script src="{{asset("LDCI/Core/alertify.min.js")}}" ></script>
    <script src="{{asset("LDCI/Core/core.js")}}" ></script>
    <script src="{{asset("LDCI/login.js")}}" ></script>
  

  </body>
</html>

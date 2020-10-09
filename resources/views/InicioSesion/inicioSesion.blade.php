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

    <title>INTERMODAL LDCI - AGENTE DE CARGA, COURIER Y ADUANA</title>

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/font-awesome/css/font-awesome.css")}}" >
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/Ionicons/css/ionicons.css")}}" >

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset("assets/bracket/css/bracket.css")}}" >

  </head>

  <body>

    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> LDCI <span class="tx-normal">]</span></div>
        <div class="tx-center mg-b-60">INTERMODAL LDCI - AGENTE DE CARGA, COURIER Y ADUANA</div>
        @csrf
        <div class="form-group">
          <input type="text" id="user" class="form-control" placeholder="Ingrese su Usuario">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" id="password" class="form-control" placeholder="Ingrese Contraseña">
        </div><!-- form-group -->
        <button type="submit" onclick="login()" class="btn btn-info btn-block">Entrar</button>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="{{asset("assets/bracket/lib/jquery/jquery.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/popper.js/popper.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/bootstrap/bootstrap.js")}}" ></script>
    <script src="{{asset("LDCI/login.js")}}" ></script>

  </body>
</html>

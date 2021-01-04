<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="SISTEMA - LOGISTICA DE CARGA INTERMODAL">
    <meta name="author" content="kennysaenz31@gmail.com">

    <title>SISTEMA - LOGISTICA DE CARGA INTERMODAL</title>
    <link rel="icon" href="{{asset("assets/bracket/Logo-Intermodal.ico")}}" >
    <link rel="stylesheet" href="{{asset("assets/bracket/css/bracket.css")}}" >
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/font-awesome/css/font-awesome.css")}}" >
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/Ionicons/css/ionicons.css")}}"  >
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/perfect-scrollbar/css/perfect-scrollbar.css")}}"  >
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/jquery-switchbutton/jquery.switchButton.css")}}"  >
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/select2/css/select2.min.css")}}"  >

    <!-- Core DATABLE -->
    <link rel="stylesheet" href="{{asset("LDCI/Core/core.css")}}"  >
    <link rel="stylesheet" href="{{asset("LDCI/Core/dataTables.bootstrap.min.css")}}"  >
    <link rel="stylesheet" href="{{asset("LDCI/Core/bootstrap.scss")}}"  >

     <!-- Core CSS -->
      <link rel="stylesheet" href="{{asset("LDCI/Core/alertify.default.css")}}"  >
      <link rel="stylesheet" href="{{asset("LDCI/Core/alertify.core.css")}}"  >
     <link rel="stylesheet" href="{{asset("LDCI/Core/jquery-ui.min.css")}}"  >

      <link rel="stylesheet" href="{{asset("LDCI/Core/intlTelInput.css")}}"  >
      <link rel="stylesheet" href="{{asset("LDCI/Core/demo.css")}}">
      <link rel="stylesheet" href="{{asset("LDCI/Core/avilon.css")}}">
      <link rel="stylesheet" href="{{asset("LDCI/Core/dropzone.min.css")}}">

      <style>
          @media (min-width: 576px)
          {
              .br-sideleft {
                  z-index: 2000!important;
              }
          }

      </style>

  </head>
  <body>
     <!--Inicio Header -->
     @include('InicioSesion.editarUsuario')
     @include('theme.bracket.header')
     @include('theme.bracket.tabPanel')
     <!--Fin-->
     <!--Inicio Aside -->
     @include('theme.bracket.aside')
     <!--Fin -->

     <!--INICIO CONTENEDOR CARGANDO-->
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    <!--FIN CONTENEDOR CARGANDO-->

    <div class="br-mainpanel">
      <div class="br-section-wrapper">
            <div id="principal" class="row"><!-- Agrega contenido desde otra vista-->

                    <section style="margin-top: 3%; width: 100%;" id="features">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 features-img">
                                    <img class="img-fluid" src="LDCI/img/Layout.png" alt="" class="wow fadeInLeft" style="    max-width: 150%!important; margin-left: -30%; padding-top: 50%; visibility: visible; animation-name: fadeInLeft;">
                                </div>
                                <div class="col-md-8" >
                                    <div class="col-md-12" style="margin-left: 10%;">
                                        <div class="section-header wow fadeIn" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeIn;">
                                            <h3 class="section-title">Productos / Servicio</h3>
                                            <span class="section-divider"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-left: 15%;">

                                        <div class="row">

                                            <div class="col-md-6 fadeInRight" style="width: 90%!important;  visibility: visible; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-plane"></i></div>
                                                <h4 class="title"><a href="">Transporte Aéreo</a></h4>
                                                <p class="description">Embarques directos con cualquier línea aérea carguera y pasajero</p>
                                                <p class="description">Carga consolidada desde cualquier origen/destino</p>
                                                <p class="description">Itinerarios, tiempo de tránsito y servicios pre-establecidos</p>
                                                <p class="description"> Tarifas económicas y competitivas</p>
                                            </div>
                                            <div class="col-md-6 fadeInRight" data-wow-delay="0.1s" style="width: 90%!important; visibility: visible; animation-delay: 0.1s; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-model-s"></i></div>
                                                <h4 class="title"><a href="">Transporte Terrestre</a></h4>
                                                <p class="description"> Embarques en camiones completos, furgón, rastras</p>
                                                <p class="description"> Embarques de mercaderías extra-dimensionales y pesadas en equipos Low Boys o plataformas</p>
                                                <p class="description"> Embarques consolidados en Centroamérica, México y Panamá con horarios publicados</p>
                                            </div>
                                            <div class="col-md-6 fadeInRight" data-wow-delay="0.2s" style="width: 90%!important; visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-android-compass"></i></div>
                                                <h4 class="title"><a href="">Transporte Marítimo</a></h4>
                                                <p class="description">Contenedores completos FCL/FCL</p>
                                                <p class="description">Carga consolidada LCL/LCL desde cualquier origen/destino hasta Managua y viceversa</p>
                                                <p class="description">Itinerarios, tiempo de tránsito y servicios pre-establecidos</p>
                                                <p class="description"> Tarifas económicas y competitivas</p>
                                            </div>
                                            <div class="col-md-6 fadeInRight" data-wow-delay="0.3s" style="width: 90%!important; visibility: visible; animation-delay: 0.3s; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-ios-analytics-outline"></i></div>
                                                <h4 class="title"><a href="">Gelpack y Hielo Seco</a></h4>
                                                <p class="description">Tenemos a la venta de Gel Pack como refrigerante para
                                                    mantener la temperatura de su carga perecedera,
                                                    importado directamente de USA</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

            </div>
            <footer class="br-footer">
              <div class="footer-left">
                  <div class="mg-b-2">Copyright - {{date("Y")}}. LDCI. All Rights Reserved.</div>
              </div>
            </footer>
      </div>
    </div><!-- br-mainpanel -->


    <script src="{{asset("assets/bracket/lib/jquery/jquery.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/popper/popper.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/bootstrap/bootstrap.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/moment/moment.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/jquery-ui/jquery-ui.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/jquery-switchbutton/jquery.switchButton.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/peity/jquery.peity.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/select2/js/select2.min.js")}}" ></script>


    <script src="{{asset("assets/bracket/js/bracket.js")}}" ></script>

    <!-- js Core-->
    <script src="{{asset("LDCI/Core/jquery.mask.js")}}" ></script>
    <script src="{{asset("LDCI/Core/alertify.min.js")}}" ></script>
    <script src="{{asset("LDCI/Core/jquery.dataTables.min.js")}}" ></script>
    <script src="{{asset("LDCI/Core/dataTables.bootstrap.min.js")}}" ></script>

    <script src="{{asset("LDCI/Core/intlTelInput.js")}}" ></script>
    <script src="{{asset("LDCI/Core/core.js")}}" ></script>
    <script src="{{asset("LDCI/Core/dropzone.min.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/parsleyjs/parsley.js")}}" ></script>

     @if($tipo==1)
         <script src="{{asset("LDCI/js/reportes.js")}}" ></script>
     @endif

  </body>
</html>

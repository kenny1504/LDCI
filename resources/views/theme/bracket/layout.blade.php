<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
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
    <link rel="stylesheet" href="{{asset("assets/bracket/lib/rickshaw/rickshaw.min.css")}}"  >

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
            <div class="row"><!-- Agrega contenido desde otra vista-->

                    <section style="margin-top: 7%; width: 100%;" id="features">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 features-img">
                                    <img class="img-fluid" src="assets/product-features.png" alt="" class="wow fadeInLeft" style="    max-width: 150%!important; margin-left: -25%; padding-top: 7%; visibility: visible; animation-name: fadeInLeft;">
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
                                                <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident clarida perendo.</p>
                                            </div>
                                            <div class="col-md-6 fadeInRight" data-wow-delay="0.1s" style="width: 90%!important; visibility: visible; animation-delay: 0.1s; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-model-s"></i></div>
                                                <h4 class="title"><a href="">Transporte Terrestre</a></h4>
                                                <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata noble dynala mark.</p>
                                            </div>
                                            <div class="col-md-6 fadeInRight" data-wow-delay="0.2s" style="width: 90%!important; visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-android-compass"></i></div>
                                                <h4 class="title"><a href="">Transporte Marítimo</a></h4>
                                                <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur teleca starter sinode park ledo.</p>
                                            </div>
                                            <div class="col-md-6 fadeInRight" data-wow-delay="0.3s" style="width: 90%!important; visibility: visible; animation-delay: 0.3s; animation-name: fadeInRight;">
                                                <div class="icon"><i class="ion-ios-analytics-outline"></i></div>
                                                <h4 class="title"><a href="">Gelpack y Hielo Seco</a></h4>
                                                <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dinoun trade capsule.</p>
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
                  <div class="mg-b-2">Copyright - 2020. LDCI. All Rights Reserved.</div>
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
    <script src="{{asset("assets/bracket/lib/jquery.sparkline.bower/jquery.sparkline.min.js")}}" ></script>
    <script src="{{asset("assets/bracket/lib/d3/d3.js")}}" ></script>


    <script src="{{asset("assets/bracket/js/bracket.js")}}" ></script>
    <script src="{{asset("assets/bracket/js/ResizeSensor.js")}}" ></script>

    <!-- js Core-->
      <script src="{{asset("LDCI/Core/alertify.min.js")}}" ></script>
      <script src="{{asset("LDCI/Core/jquery.dataTables.min.js")}}" ></script>
      <script src="{{asset("LDCI/Core/dataTables.bootstrap.min.js")}}" ></script>

      <script src="{{asset("LDCI/Core/intlTelInput.js")}}" ></script>
      <script src="{{asset("LDCI/Core/core.js")}}" ></script>

  </body>
</html>

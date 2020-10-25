 <!-- ########## START: HEADER ########## -->
 <div class="br-header">
    <div class="br-header-left">
      <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
      <div class="input-group hidden-xs-down wd-170 transition">
        <input id="searchbox" type="text" class="form-control" placeholder="Search">
        <span class="input-group-btn">
          <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
        </span>
      </div><!-- input-group -->
    </div><!-- br-header-left -->
    <div class="br-header-right">
      <nav class="nav">
        <div class="dropdown">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <span class="logged-name hidden-md-down">{{$nombre}}</span>
            <img src="https://www.flaticon.com/svg/static/icons/svg/1828/1828328.svg" class="wd-32 rounded-circle" alt="">
            <span class="square-10 bg-success"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-header wd-200">
            <ul class="list-unstyled user-profile-nav">
              <li><a onclick="editarUsuario()" data-toggle="modal" data-target="#editar_Usuario" ><i class="icon ion-ios-person"></i> Editar</a></li>
              <li><a onclick="loginOut()"><i class="icon ion-power"></i>Cerrar sesion</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </nav>
      <div class="navicon-right">
        <a id="btnRightMenu" href="" class="pos-relative">
          <i  class="icon ion-ios-calendar-outline tx-24"> </i>
        </a>
      </div>
    </div><!-- br-header-right -->
  </div><!-- br-header -->
  
  <!-- ########## END: HEADER ########## -->
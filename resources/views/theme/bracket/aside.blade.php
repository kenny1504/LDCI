<!-- ########## START: ASIDE ########## -->
<div class="br-logo"><a href="/"><span>[</span>LDCI<span>]</span></a></div>
<div class="br-sideleft overflow-y-auto ps ps--theme_default ps--active-x ps--active-y">
  <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
  <div class="br-sideleft-menu">@csrf

      @if($tipo!=3)

          @if($tipo==1)
            <a href="catalogos.usuarios" class="optionMenu br-menu-link">
              <div class="br-menu-item">
                <i class="menu-item-icon icon ion-person-stalker tx-22"></i>
                <span class="menu-item-label">Usuarios</span>
              </div><!-- menu-item -->
            </a><!-- br-menu-link -->
            <a href="vendedor.vendedor" class="optionMenu br-menu-link">
              <div class="br-menu-item">
                <i class="menu-item-icon icon ion-person tx-24"></i>
                <span class="menu-item-label">Vendedores</span>
              </div><!-- menu-item -->
            </a><!-- br-menu-link -->
          @endif
            <a href="cliente.cliente" class="optionMenu br-menu-link">
              <div class="br-menu-item">
                <i class="menu-item-icon icon ion-man tx-20"></i>
                <span class="menu-item-label">Clientes</span>
              </div><!-- menu-item -->
            </a><!-- br-menu-link -->
            <a href="" class="br-menu-link">
              <div class="br-menu-item">
                <i class="menu-item-icon icon ion-document-text tx-24"></i>
                <span class="menu-item-label">Facturacion</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
              </div><!-- menu-item -->
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub nav flex-column">
              <li class="nav-item"><a href="" class="nav-link">Ver Facturas</a></li>
              <li class="nav-item"><a href="" class="nav-link">Generar factura</a></li>
            </ul>
            <a href="cotizacion.cotizacion" class="optionMenu br-menu-link">
              <div class="br-menu-item">
                <i class="menu-item-icon icon ion-clipboard tx-24"></i>
                <span class="menu-item-label">Cotizaciones</span>
              </div><!-- menu-item -->
            </a><!-- br-menu-link -->
            <a href="rastreo.rastreo" class="optionMenu br-menu-link">
              <div class="br-menu-item">
                <i  class="menu-item-icon icon ion-location tx-20"></i>
                <span class="menu-item-label">Rastreo</span>
              </div><!-- menu-item -->
            </a>
            <a href="" class="br-menu-link">
              <div class="br-menu-item">
                <i class="menu-item-icon fa fa-briefcase tx-24"></i>
                <span class="menu-item-label">Catalogos</span>
                  <i class="menu-item-arrow fa fa-angle-down"></i>
              </div><!-- menu-item -->
            </a><!-- br-menu-link -->
              <ul class="br-menu-sub nav flex-column">
                  <li class="nav-item"><a href="catalogos.tipoTransporte" class="optionMenu nav-link">Tipo Transporte</a></li>
                  <li class="nav-item"><a href="catalogos.tipoMercancia" class="optionMenu nav-link">Tipo Mercancia</a></li>
                  <li class="nav-item"><a href="catalogos.proveedor" class="optionMenu nav-link">Proveedores</a></li>
                  <li class="nav-item"><a href="catalogos.producto" class="optionMenu nav-link">Productos</a></li>
                  <li class="nav-item"><a href="catalogos.tipoModoTransporte" class="optionMenu nav-link">Modo Transporte</a></li>
              </ul>
              @if($tipo==1)
              <a href="" class="br-menu-link">
                  <div class="br-menu-item">
                      <i class="menu-item-icon icon ion-archive tx-20"></i>
                      <span  class=" menu-item-label">Reportes</span>
                      <i class="menu-item-arrow fa fa-angle-down"></i>
                  </div><!-- menu-item -->
              </a>
                  <ul class="br-menu-sub nav flex-column">
                      <li class="nav-item"><a href="/vendedores" target="_blank" class="nav-link">Vendedores</a></li>
                      <li class="nav-item"><a href="" class=" nav-link">Otros</a></li>
                      <li class="nav-item"><a href="" class=" nav-link">Otros</a></li>
                      <li class="nav-item"><a href="" class=" nav-link">Otros</a></li>
                      <li class="nav-item"><a href="" class=" nav-link">Otros</a></li>
                  </ul>
              @endif
      @else
          <a href="catalogos.productoUsuario"  class="optionMenu br-menu-link">
              <div class="br-menu-item">
                  <i class="menu-item-icon icon ion-ios-pricetag tx-22"></i>
                  <span class="menu-item-label">Productos</span>
              </div><!-- menu-item -->
          </a><!-- br-menu-link -->
          <a href="rastreo.rastreo" class="optionMenu br-menu-link">
              <div class="br-menu-item">
                  <i  class="menu-item-icon icon ion-location tx-20"></i>
                  <span class="menu-item-label">Rastreo</span>
              </div><!-- menu-item -->
          </a>
          <a href="" class="br-menu-link">
              <div class="br-menu-item">
                  <i class="menu-item-icon icon ion-clipboard tx-24"></i>
                  <span class="menu-item-label">Cotizaciones</span>
              </div><!-- menu-item -->
          </a><!-- br-menu-link -->
          <a href="" class="br-menu-link">
              <div class="br-menu-item">
                  <i class="menu-item-icon icon ion-document-text tx-24"></i>
                  <span class="menu-item-label">Facturacion</span>
                  <i class="menu-item-arrow fa fa-angle-down"></i>
              </div><!-- menu-item -->
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub nav flex-column">
              <li class="nav-item"><a href="" class="nav-link">Ver Facturas</a></li>
          </ul>
      @endif
  </div><!-- br-sideleft-menu -->

  <br>
</div><!-- br-sideleft -->
<!-- ########## END: ASIDE ########## -->

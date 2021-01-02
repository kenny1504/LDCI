   <style>
       textarea {
           resize: none;
       }

       thead tr th {
           position: sticky;
           color:white;
           background-color:#337ab7;
           text-align: center
         }
       .punteado{
           border-style: dotted;
           border-width: 1px;
           border-color: #660033;
           font-family: verdana, arial;
           font-size: 10pt;
       }
       .precio{
           margin: 0 0 0px 0!important;
           padding: 0!important;
           margin-top: 3%!important;
       }
   </style>

    <div class="col-md-11 col-md-offset-2">
        <div class="row" style="margin-left: 12%;" >
            <div class="box box-success">
                <div class="box-heading">
                    <div class="row"></div>
                </div>
                <div class="box-body">
                    <div class="row" style="margin: 2%">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>
                                        <legend class="text-primary">Cotización</legend>
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">No.cotizacion</label>
                                        <div class="input-group">
                                            <input disabled type="text" id="id_cotizacion" name="id_cotizacion" class="form-control input-md">
                                            <span class="input-group-btn">
                                                <button title="Buscar cotizacion" onclick="listarCotizaciones()" class="btn btn-default" data-toggle="modal" data-target="#ModalCotizaciones"
                                                        id="btnBuscarCotizacion" type="button"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cmb_estado">Estado</label>
                                        <select onchange="changeestado()" name="cmb_estado" id="cmb_estado"  class="form-control input-md">
                                            <option selected disabled value="">Seleccione</option>
                                            <option  value="-1">Rechazada</option>
                                            <option  value="1">Nueva</option>
                                            <option  value="2">Revisada</option>
                                            <option  value="3">Aprobada</option>
                                            <option  value="4">Tramite</option>
                                            <option  value="5">Impresa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 ">
                            <img  class="img-responsive" width="100px"
                                 src="LDCI/img/Logo-Intermodal.png" alt="LDCI">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txt_usuario">Usuario Grabacion</label>
                                <input readonly type="text" id="txt_usuario"  name="txt_usuario" class="form-control input-md">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txt_vendedor">Vendedor Asignado</label>
                                <input readonly type="text" id="txt_vendedor"  name="txt_vendedor" class="form-control input-md">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txt_fecha">Fecha Envio</label>
                                <input readonly type="text" name="txt_fecha"  id="txt_fecha" class="form-control input-md">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txt_destino">Destino</label>
                                <input readonly type="text" name="txt_destino"  id="txt_destino" class="form-control input-md">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txt_origen">Origen</label>
                                <input readonly type="text" name="txt_origen"  id="txt_origen" class="form-control input-md">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cmb_transporte">Transporte</label>
                                <select name="cmb_transporte" id="cmb_transporte"  class="form-control input-md">
                                    <option selected disabled value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 2%">
                        <div class="col-md-12">
                            <h5 >
                                <legend class="text-primary">Informacion Carga</legend>
                            </h5>
                        </div>
                        <div class="col-md-12">
                            <div id="detallesCarga" class="table-responsive">
                                <br>
                                <table class="table table-hover table-striped table-sm"
                                       id="tblDetalleCarga">
                                    <thead>
                                    <tr>
                                        <th class=" text-center" width="5%">UNIDADES</th>
                                        <th class=" text-center" width="5%">NUEVO</th>
                                        <th class=" text-center" width="25%">TIPO MERCANCIA</th>
                                        <th class=" text-center" width="25%">TRANSPORTE</th>
                                        <th class=" text-center" width="25%">DESCRIPCION</th>
                                        <th class=" text-center" width="10%">PRECIO $</th>
                                        <th class=" text-center" width="10%">ACCIÓN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="fila-base">
                                        <td width="5%" class="text-center">
                                            <input required onkeypress="return soloNumeros(event,txtCantidad);"  type="text" name="txtCantidad"  id="txtCantidad" class="cantidad text-center form-control input-sm">
                                        </td>
                                        <td width="5%" class="text-center">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="switch">
                                                        <input style="display: none" id="ckEstado" name="ckEstado" type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="25%" class="text-center">
                                            <select required title="Seleccione" class="form-control input-sm" id="cmb_tipo_mercancia" data-live-search="true">
                                                <option selected disabled value=""> Seleccione</option>
                                            </select>
                                        </td>
                                        <td width="25%" class="text-center">
                                            <select required title="Seleccione " class="form-control input-sm" id="cmb_modo_transporte" data-live-search="true">
                                                <option selected disabled value=""> Seleccione</option>
                                            </select>
                                        </td>
                                        <td width="25%" class="text-center">
                                            <textarea id="txt_observacion" class="form-control"></textarea>
                                        </td>
                                        <td width="5%" class="text-center">
                                            <input title="Ingrese precio"  onFocus="this.oldValue = this.value;" onchange="calcularPresupuesto(this);this.oldValue = this.value;" required onkeypress="return soloNumeros(event,txtprecioCargar);"  type="text" name="txtprecioCargar"  id="txtprecioCargar" class="cantidad text-center form-control input-sm">
                                        </td>
                                        <td width="10%" class="text-center">
                                            <div class="pull-right row form-group">
                                                <button class="btn btn-danger eliminarFila"
                                                        title="Eliminar Carga"
                                                        id="btnEliminarFila">
                                                    <i class=" fa fa-trash"></i></button>
                                                <button class="btn btn-primary"
                                                        data-confirm="" id="btnAdicionarFilaC"
                                                        title="Añadir Carga">
                                                    <i class=" fa fa-plus"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 2%">
                        <div class="col-md-12">
                            <h5 >
                                <legend class="text-primary">Servicios</legend>
                            </h5>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-12">
                                <div id="detallesServicios" class="table-responsive">
                                    <br>
                                    <table class="table table-hover table-striped table-sm"
                                           id="tblDetalleServicios">
                                        <thead>
                                        <tr>
                                            <th class=" text-center" width="80%">SERVICIO</th>
                                            <th class=" text-center" width="10%">PRECIO $</th>
                                            <th class=" text-center" width="10%">ACCIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="fila-base">
                                            <td width="80%" class="text-center">
                                                <select  title="Seleccione" class="form-control input-sm" id="cmb_servicio" data-live-search="true">
                                                    <option selected disabled value=""> Seleccione</option>
                                                </select>
                                            </td>
                                            <td width="10%" class="text-center">
                                                <input title="Ingrese precio" onFocus="this.oldValue = this.value;" onchange="calcularPresupuesto(this);this.oldValue = this.value;" required onkeypress="return soloNumeros(event,txtPrecioServicio);"  type="text" name="txtPrecioServicio"  id="txtPrecioServicio" class="cantidad text-center form-control input-sm">
                                            </td>
                                            <td width="10%" class="text-center">
                                                <div class="pull-right row form-group">
                                                    <button class="btn btn-danger eliminarFila"
                                                            title="Eliminar servicio"
                                                            id="btnEliminarFila">
                                                        <i class=" fa fa-trash"></i></button>
                                                    <button class="btn btn-primary"
                                                            data-confirm="" id="btnAdicionarFilaS"
                                                            title="Añadir servicio">
                                                        <i class=" fa fa-plus"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label >Nota adicional</label>
                                    <textarea readonly class="form-control" id="txt_nota_adicional" name="txt_nota_adicional">
                                </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <br>
                                    <label >Descripcion</label>
                                    <textarea style="height: 70%;" class="form-control" id="txt_descripcion" name="txt_descripcion">
                                </textarea>
                                </div>
                                <div class=" col-md-4">
                                    <br>
                                    <table class="punteado" width=80%  style="text-align: center; margin-top: 3%">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <h6 class="precio">SubTotal: $<label id="txt_subtotal">0.00</label></h6>
                                                <h6 class="precio">Iva: $<label id="txt_iva" >0.00</label></h6>
                                                <h6 class="precio">Total: $<label id="txt_total">0.00</label></h6>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Datos ocultos-->
                        <div hidden class="InfoContacto col-md-12">
                                    <br><br>
                                    <h5 >
                                        <legend class="text-primary">Informacion de Contacto</legend>
                                    </h5>
                                </div>
                        <div hidden class="InfoContacto col-md-6">
                                <div class="col-md-12">
                                    <h6 >
                                        <legend class="text-info">Remitente</legend>
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txt_nombresRemitente">Nombres</label>
                                            <div class="input-group">
                                                <input  type="text" id="txt_nombresRemitente" name="txt_nombresRemitente" class="form-control input-md">
                                                <span class="input-group-btn">
                                                        <button onclick="listarClientesRemitente()"  title="Buscar cliente" onclick="" class="btn btn-default" data-toggle="modal" data-target="#ModalClientes"
                                                                id="btnBuscarCliente" type="button"><i class="fa fa-search"></i></button>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_apellido1Remitente">Apellido 1</label>
                                            <input  type="text" id="txt_apellido1Remitente" name="txt_apellido1Remitente" class="form-control input-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_apellido2Remitente">Apellido 2</label>
                                            <input  type="text" id="txt_apellido2Remitente" name="txt_apellido2Remitente" class="form-control input-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_telefonoRemitente">Telefono</label>
                                            <input onkeypress="return soloNumeros(event,txt_telefonoRemitente);"   type="tel" id="txt_telefonoRemitente" name="txt_telefonoRemitente" class="form-control input-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_CorreoRemitente">Correo</label>
                                            <input  type="text" id="txt_CorreoRemitente" name="txt_CorreoRemitente" class="form-control input-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label >Direccion</label>
                                        <textarea class="form-control" id="txt_direccionRemitente" name="txt_direccionRemitente">
                                    </textarea>
                                    </div>
                                </div>
                            </div>
                        <div hidden class="InfoContacto col-md-6">
                                <div class="col-md-12">
                                    <h6 >
                                        <legend class="text-info">Consignatario</legend>
                                    </h6>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txt_nombres">Nombres</label>
                                            <div class="input-group">
                                                <input  type="text" id="txt_nombresConsignatario" name="txt_nombresConsignatario" class="form-control input-md">
                                                <span class="input-group-btn">
                                                        <button onclick="listarClientesConsignatario()" title="Buscar cliente" onclick="" class="btn btn-default" data-toggle="modal" data-target="#ModalClientes"
                                                                id="btnBuscarCliente" type="button"><i class="fa fa-search"></i></button>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_apellido1Consignatario">Apellido 1</label>
                                            <input  type="text" id="txt_apellido1Consignatario" name="txt_apellido1Consignatario" class="form-control input-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_apellido2Consignatario">Apellido 2</label>
                                            <input  type="text" id="txt_apellido2Consignatario" name="txt_apellido2Consignatario" class="form-control input-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_telefonoConsignatario">Telefono</label>
                                            <input  onkeypress="return soloNumeros(event,txt_telefonoConsignatario);" type="tel" id="txt_telefonoConsignatario" name="txt_telefonoConsignatario" class="form-control input-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txt_correoConsignatario">Correo</label>
                                            <input  type="text" id="txt_correoConsignatario" name="txt_correoConsignatario" class="form-control input-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label >Direccion</label>
                                        <textarea class="form-control" id="txt_direccionConsignatario" name="txt_direccionConsignatario">
                                    </textarea>
                                    </div>
                                </div>
                           </div>

                        <div hidden class="InfoContacto col-md-12">
                            <br><br>
                            <h5 >
                                <legend class="text-primary">Informacion de Proveedor</legend>
                            </h5>
                        </div>
                        <div hidden class="InfoContacto col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="txt_nombresRemitente">Proveedor</label>
                                        <div  class="input-group">
                                            <input disabled type="text" id="txt_id_proveedor" name="txt_id_proveedor" class="form-control input-md">
                                            <span class="input-group-btn">
                                                        <button  onclick="listarProveedores()" title="Buscar Proveedor" onclick="" class="btn btn-default" data-toggle="modal" data-target="#ModalProveedores"
                                                                id="btnBuscarProveedor" type="button"><i class="fa fa-search"></i></button>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="txt_nombresProveedor">Nombre</label>
                                        <input disabled type="text" id="txt_nombresProveedor" name="txt_nombresProveedor" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="txt_correoProveedor">Correo</label>
                                        <input disabled type="text" id="txt_correoProveedor" name="txt_correoProveedor" class="form-control input-md">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="txt_telefonoProveedor">Telefono</label>
                                        <input  disabled type="tel" id="txt_telefonoProveedor" name="txt_telefonoProveedor" class="form-control input-md">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="txt_fecha_llegada">Fecha llegada</label>
                                        <input  type="date" id="txt_fecha_llegada" name="txt_fecha_llegada" class="form-control input-md">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="box-footer text-center">
                    <div class="col-md-12">
                        <button disabled title="Guardar cotizacion" onclick="GuardarSeguimiento()" class="btn btn-success" id="btnGuardar"><i class="fa fa-save"> </i> Guardar</button>
                        <button title="Imprimir cotizacion" onclick="" class="btn btn-info" id="btnimprimir"><i class="fa fa-print"> </i>imprimir</button>
                        <button title="Limpiar formulario" href="cotizacion.seguimiento" class="optionMenu btn btn-warning" ><i class="fa fa-recycle"></i> Limpiar</button>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ModalCotizaciones" class="modal fade" role="document" >
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="align-self: flex-end;" >
                    <a type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="box box-success">
                        <div class="box-heading text-success">
                            <div class="row"></div>
                            <h4 align="center">Busqueda de Registro</h4>
                        </div>
                        <div class="box-body">
                            <div  class="table-responsive">
                                <table class="table" id="tblCotizaciones">
                                    <thead>
                                    <tr>
                                        <th>N.º Cotizacion</th>
                                        <th>Transporte</th>
                                        <th>Destino</th>
                                        <th>Origen</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Creada</th>
                                        <th>Vendedor</th>
                                        <th>Seleccione</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="ModalClientes" class="modal fade" role="document" >
       <div class="modal-dialog modal-lg">
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-header" style="align-self: flex-end;" >
                   <a type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">×</span>
                   </a>
               </div>
               <div class="modal-body">
                   <div class="box box-success">
                       <div class="box-heading text-success">
                           <div class="row"></div>
                           <h4 align="center">Busqueda de Registro</h4>
                       </div>
                       <div class="box-body">
                           <div  class="table-responsive">
                               <table id="tblClientes" class="table table-striped table-bordered">
                                   <thead>
                                   <tr>
                                       <th>No</th>
                                       <th>Nombre</th>
                                       <th>Identificacion</th>
                                       <th>Correo</th>
                                       <th>Telefono</th>
                                       <th>Tipo</th>
                                       <th>Seleccione</th>
                                   </tr>
                                   </thead>
                                   <tbody>

                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

    <div id="ModalProveedores" class="modal fade" role="document" >
       <div class="modal-dialog modal-lg">
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-header" style="align-self: flex-end;" >
                   <a type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">×</span>
                   </a>
               </div>
               <div class="modal-body">
                   <div class="box box-success">
                       <div class="box-heading text-success">
                           <div class="row"></div>
                           <h4 align="center">Busqueda de Registro</h4>
                       </div>
                       <div class="box-body">
                           <div  class="table-responsive">
                               <table id="tblProveedores" class="table table-striped table-bordered">
                                   <thead>
                                   <tr>
                                       <th>No</th>
                                       <th>Nombre</th>
                                       <th>Correo</th>
                                       <th>Telefono</th>
                                       <th>Seleccione</th>
                                   </tr>
                                   </thead>
                                   <tbody>

                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

<!-- js -->
<script src="{{asset("LDCI/js/seguimiento.js")}}" ></script>





<style>
    thead tr th {
        position: sticky;
        color:white;
        background-color:#337ab7;
        text-align: center;
    }
    .punteado{
        border-style: dotted;
        border-width: 1px;
        border-color: #660033;
        font-family: verdana, arial;
        font-size: 10pt;
    }
</style>

<div class="col-md-12">
    <div class="box box-success">
        <div class="box-heading"><legend class="text-primary text-center">Factura/Venta</legend></div>
        <div class="box-body">
            <div class="row" style="margin: 2%">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="id_cotizacion">No.Venta</label>
                                <div class="input-group">
                                    <input name="id_factura" id="id_factura" readonly class="form-control input-sm">
                                    <span class="input-group-btn">
                                        <button title="Buscar venta" onclick="listarVentas()" class="btn btn-default" data-toggle="modal" data-target="#ModalFacturas"
                                                id="btnBuscarVenta" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="txt_codigoFactura">No.Factura</label>
                                <input onchange="validarNoFactura(this)" required name="txt_codigoFactura" id="txt_codigoFactura"  class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label >Común</label>
                            <div class="form-group">
                                <label class="switch">
                                    <input  id="ckComun" type="checkbox">
                                    <span title="Seleccionar si es un cliente comun" class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="cmb_Cliente">Cliente</label>
                                <select required name="cmb_Cliente"  id="cmb_Cliente" class=" form-control input-md">
                                    <option selected disabled value=""> Seleccione</option>
                                </select>                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="cmb_moneda">Moneda</label>
                                <select required onchange="" name="cmb_moneda" id="cmb_moneda"  class="form-control input-md">
                                    <option selected disabled value="">Seleccione</option>
                                    <option  value="1">Dollar</option>
                                    <option  value="2">Cordoba</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="cmb_descuento">Descuento</label>
                                <select required  onchange="changeDescuento(this)" name="cmb_descuento" id="cmb_descuento"  class="form-control input-md">
                                    <option selected disabled value="">Seleccione</option>
                                    <option  value="0">Ninguno</option>
                                    <option  value="0.5">5 %</option>
                                    <option  value="0.10">10 %</option>
                                    <option  value="0.20">20 %</option>
                                    <option  value="0.30">30 %</option>
                                    <option  value="0.40">40 %</option>
                                    <option  value="0.50">50 %</option>
                                    <option  value="0.60">60 %</option>
                                    <option  value="0.70">70 %</option>
                                    <option  value="0.80">80 %</option>
                                    <option  value="0.90">90 %</option>
                                    <option  value="1">100 %</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="cmb_tipo">Tipo</label>
                                <select required onchange="" name="cmb_tipo" id="cmb_tipo"  class="form-control input-md">
                                    <option selected disabled value="">Seleccione</option>
                                    <option  value="1">Contado</option>
                                    <option  value="2">Credito</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txt_termino">Termino</label>
                                <input required type="text" name="txt_termino"  id="txt_termino" class="form-control input-md">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 2%">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="col-md-12">
                                <h5 >
                                    <legend class="text-primary">Productos</legend>
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div id="detallesCarga" class="table-responsive">
                                    <br>
                                    <table class="table table-hover table-striped table-sm"
                                           id="tblDetalleProductos">
                                        <thead>
                                        <tr>
                                            <th class=" text-center" width="10%">Cantidad</th>
                                            <th class=" text-center" width="50%">Producto</th>
                                            <th class=" text-center" width="15%">Precio $</th>
                                            <th class=" text-center" width="15%">Importe $</th>
                                            <th class=" text-center" width="10%">ACCIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="fila-base">
                                            <td width="10%" class="text-center">
                                                <input onblur="validarExistencia(this)" onkeypress="return soloNumeros(event,txt_cantidad);" onFocus="this.oldValue = this.value;"  onchange="importe(event,this);this.oldValue = this.value;"   name="txt_cantidad" id="txt_cantidad"  class="text-center form-control input-sm" type="text">
                                            </td>
                                            <td width="50%" class="text-center">
                                                <select onchange="changeProducto(event,this)" name="cmb_Producto"  id="cmb_Producto" class=" form-control input-md">
                                                    <option selected disabled value=""> Seleccione</option>
                                                </select>
                                            </td>
                                            <td width="15%" class="text-center">
                                                <input readonly name="txt_precio" id="txt_precio" onFocus="this.oldValue = this.value;" onchange="olvaluePrecio(this);this.oldValue = this.value;"  class=" text-center form-control input-sm" type="text">
                                            </td>
                                            <td width="15%" class="text-center">
                                                <input readonly name="txt_importe" id="txt_importe"  class=" text-center form-control input-sm" type="text">
                                            </td>
                                            <td width="10%" class="text-center">
                                                <div class="form-group">
                                                    <button class="btn btn-danger eliminarFila"
                                                            title="Eliminar Producto"
                                                            id="btnEliminarFila">
                                                        <i class=" fa fa-trash"></i></button>
                                                    <button class="btn btn-primary"
                                                            data-confirm="" id="btnAdicionarFila"
                                                            title="Añadir Producto">
                                                        <i class=" fa fa-plus"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th COLSPAN=5 class="text-center"><br><br><h6 class="precio">Total : $<label id="txt_totalPr">0.00</label></h6></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-3">
                            <table class="punteado" width=80%  style="text-align: center; margin-top: 3%">
                                <tbody>
                                <tr>
                                    <td>
                                        <br><br>
                                        <h6 class="precio">SubTotal: $<label id="txt_subtotal">0.00</label></h6>
                                        <h6 class="precio">Descuento: $<label id="txt_descuento" >0.00</label></h6>
                                        <h6 class="precio">Iva: $<label id="txt_iva" >0.00</label></h6>
                                        <h6 class="precio">Total Dollar: $<label id="txt_total">0.00</label></h6>
                                        <h6 class="precio">Total Cordoba: C$<label id="txt_total_corboba">0.00</label></h6>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center">
            <button  title="Generar Factura" onclick="GenerarFactura()" class="btn btn-info btn-sm" id="btnGenerar"><i class="fa fa-print"> </i> Generar</button>
            <button  disabled title="Anular Factura" onclick="" disabled class="remover btn btn-danger btn-sm" id="btnAnularFactura"><i class="fa fa-trash-o"> </i> Anular</button>
            <a href="factura.crearFactura" title="Limpiar formulario" id="btnlimpiar" class="optionMenu btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
        </div>
    </div>
</div>

<div id="ModalFacturas" class="modal fade" role="document" >
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
                            <table class="table" id="tblFacturas">
                                <thead>
                                <tr>
                                    <th>N.º Venta</th>
                                    <th>N.º Factura</th>
                                    <th>Estado</th>
                                    <th>Monto</th>
                                    <th>Fecha Emision</th>
                                    <th>Cliente</th>
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


<script src="{{asset("LDCI/js/crearFactura.js")}}"></script>

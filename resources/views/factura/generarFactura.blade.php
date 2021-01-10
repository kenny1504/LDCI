
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
        <div class="box-heading"><legend class="text-primary text-center">Factura/Cotizacion</legend></div>
        <div class="box-body">
            <div class="row" style="margin: 2%">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="id_cotizacion">No.cotizacion</label>
                                <div class="input-group">
                                    <input name="id_cotizacion" id="id_cotizacion" readonly class="form-control input-sm">
                                    <span class="input-group-btn">
                                        <button title="Buscar cotizacion" onclick="listarCotizaciones()" class="btn btn-default" data-toggle="modal" data-target="#ModalCotizaciones"
                                                id="btnBuscarCotizacion" type="button"><i class="fa fa-search"></i></button>
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="txt_nombreCliente">Cliente</label>
                                <input readonly type="text" id="txt_nombreCliente" name="txt_nombreCliente" class="form-control input-md">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txt_fecha">Fecha Llegada</label>
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
                                <select disabled name="cmb_transporte" id="cmb_transporte"  class="form-control input-md">
                                    <option selected disabled value="">Seleccione</option>
                                </select>
                            </div>
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
                        <div class="col-md-8">
                            <div class="col-md-12">
                                <h5 >
                                    <legend class="text-primary">Cargos Aplicados</legend>
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div id="detallesCarga" class="table-responsive">
                                    <br>
                                    <table class="table table-hover table-striped table-sm"
                                           id="tblDetalleCargos">
                                        <thead>
                                        <tr>
                                            <th class=" text-center" width="70%">Descripcion</th>
                                            <th class=" text-center" width="20%">Monto</th>
                                            <th class=" text-center" width="10%">ACCIÓN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="fila-base">

                                            <td width="70%" class="text-center">
                                                <textarea id="txt_descripcion" class="form-control"></textarea>
                                            </td>
                                            <td width="20%" class="text-center">
                                                <input title="Ingrese precio"  onFocus="this.oldValue = this.value;" onchange="calcularPresupuesto(this);this.oldValue = this.value;" required onkeypress="return soloNumeros(event,txtmonto);"  type="text" name="txtmonto"  id="txtmonto" class="cantidad text-center form-control input-sm">
                                            </td>
                                            <td width="10%" class="text-center">
                                                <div class="form-group">
                                                    <button class="btn btn-danger eliminarFila"
                                                            title="Eliminar Cargo"
                                                            id="btnEliminarFila">
                                                        <i class=" fa fa-trash"></i></button>
                                                    <button class="btn btn-primary"
                                                            data-confirm="" id="btnAdicionarFila"
                                                            title="Añadir Cargo">
                                                        <i class=" fa fa-plus"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th COLSPAN=5 class="text-center"><br><br><h6 class="precio">Total : $<label id="txt_totalMice">0.00</label></h6></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-4">
                            <table class="punteado" width=80%  style="text-align: center; margin-top: 3%">
                                <tbody>
                                <tr>
                                    <td>
                                        <br><br>
                                        <h6 class="precio">SubTotal: $<label id="txt_subtotal">0.00</label></h6>
                                        <h6 class="precio">Descuento: $<label id="txt_descuento" >0.00</label></h6>
                                        <h6 class="precio">Miscelaneos: $<label id="txt_micelaneos">0.00</label></h6>
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
            <button disabled title="Generar Factura" onclick="generar()" class="btn btn-info btn-sm" id="btnGenerar"><i class="fa fa-print"> </i> Generar</button>
            <a href="factura.generarFactura" title="Limpiar formulario" id="btnlimpiar" class="optionMenu btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
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


<script src="{{asset("LDCI/js/generarFactura.js")}}"></script>

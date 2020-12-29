<link rel="stylesheet" href="{{asset("assets/bracket/lib/jquery.steps/jquery.steps.css")}}" xmlns="">

<style>
    .wizard > .content > .body {
        position: relative!important;
    }

     textarea {
         resize: none;
     }

</style>
<script>
    showLoad(true);
</script>

<div id="wizard" class="step-equal-width">
    <h3>Informacion General</h3>
    <section>
        <p>Informacion de cotizacion</p>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Origen <span class="tx-danger">*</span></label>
                            <select title="Seleccione"  name="cmb_destino"  id="cmb_destino" class=" form-control input-md" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Destino <span class="tx-danger">*</span></label>
                            <select title="Seleccione"  name="cmb_origen"  id="cmb_origen" class=" form-control input-md" required>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Tipo transporte <span class="tx-danger">*</span></label>
                            <select name="cmb_tipo_transporte"  id="cmb_tipo_transporte" class="form-control input-md" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">fecha <span class="tx-danger">*</span></label>
                            <input  type="date" id="txt_fecha" name="txt_fecha" class="form-control input-md" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <h3>Informacion Carga</h3>
    <section>
        <div class="row form-group">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div id="detallesCarga" class="table-responsive">
                        <br>
                        <table class="table table-hover table-striped table-sm"
                               id="tblDetalleCarga">
                            <thead>
                            <tr>
                                <th class=" text-center" width="5%">UNIDADES</th>
                                <th class=" text-center" width="5%">NUEVO</th>
                                <th class=" text-center" width="25%">TIPO MERCANCIA</th>
                                <th class=" text-center" width="30%">TRANSPORTE</th>
                                <th class=" text-center" width="30%">DESCRIPCION</th>
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
                                <td width="30%" class="text-center">
                                    <select required title="Seleccione " class="form-control input-sm" id="cmb_modo_transporte" data-live-search="true">
                                        <option selected disabled value=""> Seleccione</option>
                                    </select>
                                </td>
                                <td width="30%" class="text-center">
                                    <textarea id="txt_observacion" class="form-control"></textarea>
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
        </div>
    </section>
    <h3>Servicios adicionales</h3>
    <section>
        <div class="row form-group">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div id="detallesServicios" class="table-responsive">
                        <br>
                        <table class="table table-hover table-striped table-sm"
                               id="tblDetalleServicios">
                            <thead>
                            <tr>
                                <th class=" text-center" width="90%">SERVICIO</th>
                                <th class=" text-center" width="10%">ACCIÓN</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="fila-base">
                                <td width="90%" class="text-center">
                                    <select  title="Seleccione" class="form-control input-sm" id="cmb_servicio" data-live-search="true">
                                        <option selected disabled value=""> Seleccione</option>
                                    </select>
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
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <label >Nota adicional</label>
                        <textarea class="form-control" id="txt_nota_adicional" name="txt_nota_adicional">
                            </textarea>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="text-success text-primary align-top"><h6>Al guardar,Esta cotizacion posee un periodo aproximado de 48 horas para ser contestada </h6></div>
    </section>
</div>


<!-- js -->
<script src="{{asset("assets/bracket/lib/jquery.steps/jquery.steps.js")}}" ></script>
<script src="{{asset("assets/bracket/lib/parsleyjs/parsley.js")}}" ></script>
<script src="{{asset("LDCI/js/cotizacion.js")}}" ></script>

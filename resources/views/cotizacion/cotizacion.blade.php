<link rel="stylesheet" href="{{asset("assets/bracket/lib/jquery.steps/jquery.steps.css")}}" xmlns="">

<style>
    .wizard > .content > .body {
        position: relative!important;
    }
</style>
<script>
    showLoad(true);
</script>

<div id="wizard">
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
                    <div id="detallesSanitario" class="table-responsive">
                        <br>
                        <table class="table table-hover table-striped table-sm"
                               id="tblDetalle">
                            <thead>
                            <tr>
                                <th class=" text-center" width="5%">UNIDADES</th>
                                <th class=" text-center" width="30%">TIPO MERCANCIA</th>
                                <th class=" text-center" width="30%">TRANSPORTE</th>
                                <th class=" text-center" width="30%">DESCRIPCION</th>
                                <th class=" text-center" width="10%">ACCIÓN</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="fila-base">
                                <td width="5%" class="text-center">
                                    <input maxlength="8" onkeypress="return soloNumeros(event,txtCantidad);"  type="text" name="txtCantidad" onblur="calcularTotal(this)" id="txtCantidad"class="cantidad text-center form-control input-sm">
                                </td>
                                <td width="30%" class="text-center">
                                    <select title="Seleccione" class="form-control input-sm" id="cmb_tipo_mercancia" data-live-search="true">
                                        <option selected disabled value=""> Seleccione</option>
                                    </select>
                                </td>
                                <td width="30%" class="text-center">
                                    <select title="Seleccione " class="form-control input-sm" id="cmb_modo_transporte" data-live-search="true">
                                        <option selected disabled value=""> Seleccione</option>
                                    </select>
                                </td>
                                <td width="30%" class="text-center">
                                    <textarea id="txt_observacion" class="form-control"></textarea>
                                </td>

                                <td width="10%" class="text-center">
                                    <button class="btn btn-danger eliminarFila"
                                            title="Eliminar registro"
                                            id="btnEliminarFila">
                                        <i class=" fa fa-trash"></i></button>
                                    <button class="btn btn-primary"
                                            data-confirm="" id="btnAdicionarFila"
                                            title="Adicionar registro">
                                        <i class=" fa fa-plus"></i></button>
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
        <p>The next and previous buttons help you to navigate through your content.</p>
    </section>
    <h3>Informacion Contacto</h3>
    <section>
        <p>The next and previous buttons help you to navigate through your content.</p>
    </section>
</div>


<!-- js -->
<script src="{{asset("assets/bracket/lib/jquery.steps/jquery.steps.js")}}" ></script>
<script src="{{asset("assets/bracket/lib/parsleyjs/parsley.js")}}" ></script>
<script src="{{asset("LDCI/js/cotizacion.js")}}" ></script>

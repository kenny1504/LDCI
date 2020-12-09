<link rel="stylesheet" href="{{asset("assets/bracket/lib/jquery.steps/jquery.steps.css")}}" >


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
                            <select name="cmb_destino"  id="cmb_destino" class="form-control input-md" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Destino <span class="tx-danger">*</span></label>
                            <select name="cmb_origen"  id="cmb_origen" class="form-control input-md" required>
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
        <p>Wonderful transition effects.</p>
        <div class="form-group wd-xs-300">
            <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
            <input id="email" class="form-control" name="email" placeholder="Enter email address" type="email" required>
        </div><!-- form-group -->
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

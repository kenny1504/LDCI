
<style>
    .label {
        color: white;
        padding: 8px;
    }

    .success {background-color: #4CAF50;} /* Green */
    .info {background-color: #2196F3;} /* Blue */
    .warning {background-color: #ff9800;} /* Orange */
    .danger {background-color: #f44336;} /* Red */
    .other {background-color: #e7e7e7; color: black;} /* Gray */
</style>

@csrf
<div class="col-md-1"></div>

<div class="col-md-10 ">
    <div class="box box-success">
        <div class="box-heading ">
            <h4 align="center">Cotizaciones</h4>
            <div class="row">
                <div class="col-md-3 text-right">Estado :</div>
                <div class="col-md-6">
                    <select class="form-control" id="cmb_estados" data-live-search="true">
                        <option selected disabled value="">Seleccione</option>
                        <option value="1">Nueva</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row form-group">
                <div class="col-lg-12">
                    <div class="col-lg-12">
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
                                    <th>Usuario</th>
                                    <th>Acciones</th>
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

<!-- js -->
<script src="{{asset("LDCI/js/verCotizacion.js")}}" ></script>

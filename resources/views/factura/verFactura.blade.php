
@csrf
<div class="col-md-1"></div>

<div class="col-md-10 ">
    <div class="box box-success">
        <div class="box-heading ">
            <h4 align="center">Facturas</h4>
        </div>
        <div class="box-body">
            <div class="row form-group">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <div  class="table-responsive">
                            <table class="table" id="tblFacturas">
                                <thead>
                                    <tr>
                                        <th>N.º Factura</th>
                                        <th>N.º Cotización</th>
                                        <th>Transporte</th>
                                        <th>Destino</th>
                                        <th>Origen</th>
                                        <th>Fecha Emision</th>
                                        <th>Cliente</th>
                                        <th></th>
                                        <th></th>
                                        <th>Accion</th>
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
<script src="{{asset("LDCI/js/verFactura.js")}}" ></script>

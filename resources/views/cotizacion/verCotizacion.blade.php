
@csrf
<div class="col-md-1"></div>

<div class="col-md-10 ">
    <div class="box box-success">
        <div class="box-heading ">
            <h4 align="center">Cotizaciones</h4>
            <div class="row">
                <div class="col-md-3 text-right">Estado :</div>
                <div class="col-md-6">
                    <select onchange="changeEstado()" class="form-control" id="cmb_estado" data-live-search="true">
                        <option selected value="0">Todos</option>
                        <option value="-1">Rechazada</option>
                        <option value="1">Nueva</option>
                        <option value="2">Revisada</option>
                        <option value="3">Aprobada</option>
                        <option value="4">Tramite</option>
                        <option value="5">Impresa</option>
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
                                    <th>Creada</th>
                                    <th>Vendedor</th>
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

<div id="ModalAsignarVendedor" class="modal fade" role="document" >
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="align-self: flex-end;" >
                    <a type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div style="width: 730px" class="box box-success">
                        <div class="box-heading text-success">
                            <div class="row"></div>
                            <h4 align="center"> <a id="lblCotizacion"></a> </h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-center">
                                        <label >Vendedor</label>
                                        <div class="col-md-12">
                                            <select name="selecVendedor"  id="selecVendedor" class="form-control input-md">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-4"><button type="button" class="btn btn-success " onclick="setCotizacion()" id="btnGuardarSustitucion" ><i class="fa fa-user"> </i> Asignar</button></div>
                                        <div class="col-md-4"><button type="button" class="btn btn-danger " class="close" data-dismiss="modal"  ><i class="fa fa-close"> </i> Cancelar</button></div>
                                    </div>
                                </div>
                                <br><br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- js -->
<script src="{{asset("LDCI/js/verCotizacion.js")}}" ></script>

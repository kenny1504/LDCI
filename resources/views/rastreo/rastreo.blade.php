<style>
    .punteado{
        border-style: dotted;
        border-width: 1px;
        border-color: #660033;
        font-family: verdana, arial;
        font-size: 10pt;
    }
    thead tr th {
    position: sticky;
    color:white;
    background-color:#337ab7;
    text-align: center;
    }
</style>
    <div>
        <center>
            <img class="img-responsive" width="60%"
                src="LDCI/img/mapa-mundi.png" alt="">
        </center>
    </div>

    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-heading"><legend class="text-primary text-center">Rastreo</legend></div>
            <div class="box-body">
                <form  method="post" action="{{route('guardarRastreo')}}" accept-charset="utf-8"  enctype="multipart/form-data" class="dropzone dz-clickable" id="image-upload">
                    @csrf
                <div class="row" style="margin: 2%">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="id_cotizacion">No.Cotizacion</label>
                                    <div class="input-group">
                                        <input name="id_cotizacion" id="id_cotizacion" readonly class="form-control input-sm">
                                        <input type="hidden" name="id_flete" id="id_flete" class="form-control input-sm">
                                        <span class="input-group-btn">
                                            <button title="Buscar cotizacion" onclick="listarCotizaciones()" class="btn btn-default" data-toggle="modal" data-target="#ModalCotizaciones"
                                                    id="btnBuscarCotizacion" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="txt_cliente">Cliente</label>
                                    <input readonly type="text" name="txt_cliente"  id="txt_cliente" class="form-control input-md">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fecha_llegada">Fecha llegada</label>
                                    <input readonly type="date" id="fecha_llegada" name="fecha_llegada" class="form-control input-md">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_destino">Destino</label>
                                    <input readonly required type="text" name="txt_destino"  id="txt_destino" class="form-control input-md">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_origen">Origen</label>
                                    <input readonly required type="text" name="txt_origen"  id="txt_origen" class="form-control input-md">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_transporte">Transporte</label>
                                    <input readonly required type="text" name="txt_transporte"  id="txt_transporte" class="form-control input-md">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ocular" style="margin: 2%">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <h5 >
                                        <legend class="text-primary">Eventos</legend>
                                    </h5>
                                </div>
                                <div class="col-md-12">
                                    <div id="rastreo" class="table-responsive">
                                        <br>
                                        <table class="table table-hover table-striped table-sm"
                                                id="tblRastreo">
                                            <thead>
                                            <tr>
                                                <th class=" text-center" width="10%">Fecha</th>
                                                <th class=" text-center" width="32%">Evento</th>
                                                <th class=" text-center" width="48%">Detalle Evento</th>
                                                <th class=" text-center" width="10%">ACCIÓN</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="fila-base" >
                                                <td width="10%" class="text-center">
                                                    <input type="hidden" id="id_detalle" name="id_detalle[]" class="form-control input-md">
                                                    <input type="date" id="fecha_evento" name="fecha_evento[]" class="form-control input-md">
                                                </td>
                                                <td width="32%" class="text-center">
                                                    <select name="txt_evento[]" id="txt_evento"  class="form-control input-md">
                                                        <option selected disabled value="">Seleccione</option>
                                                        <option value="Pendiente">Pendiente</option>
                                                        <option value="Recogido">Recogido</option>
                                                        <option value="En espera">En espera</option>
                                                        <option value="Salir para la entrega">Salir para la entrega</option>
                                                        <option value="En tránsito">En tránsito</option>
                                                        <option value="En Ruta">En Ruta</option>
                                                        <option value="Cancelado">Cancelado</option>
                                                        <option value="Entregado">Entregado</option>
                                                        <option value="Devuelto">Devuelto</option>
                                                        <option value="Retenido por Aduana">Retenido por Aduana</option>
                                                        <option value="En revisión por Aduana">En revisión por Aduana</option>
                                                        <option value="En transito de Entrega">En transito de Entrega</option>
                                                    </select>
                                                </td>
                                                <td width="48%" class="text-center">
                                                    <textarea placeholder="descripcion de evento" name="txt_descripcion_evento[]" id="txt_descripcion_evento" class="form-control"></textarea>
                                                </td>
                                                <td width="10%" class="text-center">
                                                    <div class="form-group">
                                                        <a class="btn btn-danger eliminarFila"
                                                                title="Eliminar Evento"
                                                                id="btnEliminarFila">
                                                            <i class=" fa fa-trash" style="color: ghostwhite"></i></a>
                                                        <a class="btn btn-primary agregarFila"
                                                                id="btnAgregarFila"
                                                                title="Añadir Evento">
                                                            <i class=" fa fa-plus" style="color: ghostwhite"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row ocular" style="margin: 2%">
                    <div class="col-md-12">
                        <table class="punteado" width=100% align="center">
                            <tr>
                                <td>
                                    <div class="dz-default dz-message">
                                        <span > Arrastre aqui imagen</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
            <div class="box-footer text-center">
                <button readonly type="submit" class="btn btn-success btn-sm" id="btnGuardarRastreo">
                    <i class="fa fa-refresh"> </i> Actualizar
                </button>
                <a href="rastreo.rastreo" title="Limpiar formulario" id="btnlimpiar" class="optionMenu btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
            </div>
        </div>
    </div>


    <div id="ModalCotizaciones" class="modal fade" role="document" >
        <div class="modal-dialog modal-lg ">
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
                            <h4 align="center">Cotizaciones</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive" >
                                <table id="tblCotizaciones" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>N.º Cotización</th>
                                            <th>Cliente</th>
                                            <th>Transporte</th>
                                            <th>Destino</th>
                                            <th>Origen</th>
                                            <th>Fecha Llegada</th>
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

<script src="{{asset("LDCI/js/rastreo.js")}}" ></script>




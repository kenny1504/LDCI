
@csrf
<div class="col-md-4">
    <div class="box box-success">
        <div class="box-heading"><h5 class="text-center">Catálogo Modo Transporte</h5></div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_TipoModoTransporte">Código</label>
                        <input name="id_TipoModoTransporte" id="id_TipoModoTransporte" readonly class="form-control input-sm">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="txt_nombre">Nombre</label>
                        <input name="txt_nombre" id="txt_nombre" class="form-control input-sm" type="text" maxlength="50">
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-right">

            <button onclick="guardar()" class="btn btn-success btn-sm" id="btnGuardarTipoModoTransporte">
                <i class="fa fa-save"> </i> Guardar
            </button>
            <button onclick="eliminar()" disabled class="btn btn-danger btn-sm" id="btnEliminarTipoModoTransporte">
                <i class="fa fa-trash-o"> </i> Eliminar
            </button>
            <a onclick="resetForm()" class="btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="box box-success">
        <div class="box-heading">
            <div class="row"></div>
        </div>
        <div class="box-body">
            <div class="row form-group">
                <div class="col-lg-12">
                    <div id="results" class="table-responsive">
                        <table class="table" id="tblTipoModoTransporte">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre</th>
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
<!-- js -->
<script src="{{asset("LDCI/js/tipoModoTransporte.js")}}" ></script>

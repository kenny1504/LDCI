@extends("theme.$theme.layout")  <!--extiendo del layout "pagina inicio" -->

<!--agrega titulo a la pagina-->
@section('titulo')  
    Usuarios
@endsection

@section('contenido')  <!--agrega codigo a la seccion contenido del layout-->

<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-heading"><h5 class="text-center">Catálogo de Usuarios</h5></div>
        <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_parcela">Código</label>
                            <input name="id_parcela" id="id_parcela" readonly class="form-control input-sm">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" id="nombre" class="form-control input-sm" type="text" maxlength="40">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Finca</label>
                            <select id="selecFinca" name="selecFinca" class="form-control">
                                <option value ="" >Seleccione</option>
                                    <option value ="">
                                    </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Tipo Cobertura</label>
                            <select id="selecTipoCobertura" name="selecTipoCobertura" class="form-control">
                                <option value ="" >Seleccione</option>
                                    <option value ="">
                                    </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label >Tipo Suelo</label>
                            <select id="selecTipoSuelo" name="selecTipoSuelo" class="form-control">
                                <option value ="" >Seleccione</option>
                                    <option value ="">
                                    </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="manzanasParcela">Manzanas</label>
                            <input name="manzanasParcela" id="manzanasParcela" class="form-control input-sm" type="text">
                        </div>
                    </div>
                </div>
        </div>
        <div class="box-footer text-right">
            <button class="btn btn-success btn-sm" id="btnGuardarParcela">
                <i class="fa fa-save"> </i> Guardar
            </button>
            <button class="btn btn-danger btn-sm" id="btnEliminarParcela">
                <i class="fa fa-recycle"> </i> Eliminar
            </button>
            <a onclick="resetForm()" class="btn btn-md btn-warning btn-sm optionMenu" ><i class="fa fa-recycle"></i> Limpiar</a>
        </div>
    </div>
</div>

<div class="col-md-7">
    <div class="box box-success">
        <div class="box-heading">
            <div class="row"></div>
        </div>
        <div class="box-body">
            <div class="row form-group">
                    <div class="col-lg-12">
                        <div id="results" class="table-responsive">
                            <table class="table table-hover" id="tblParcela">
                                <thead>
                                <tr>
                                    <th>Codigo parcela</th>
                                    <th>No</th>
                                    <th>Nombre Parcela</th>
                                    <th>Codigo Finca</th>
                                    <th>Finca</th>
                                    <th>Codigo Cobertura</th>
                                    <th>Tipo Cobertura</th>
                                    <th>Codigo Tipo Suelo</th>
                                    <th>Tipo Suelo</th>
                                    <th>No Manzanas</th>
                                    <th>Alquilada</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
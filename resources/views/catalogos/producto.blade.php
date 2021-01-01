
<style>

    .punteado{
        border-style: dotted;
        border-width: 1px;
        border-color: #660033;
        font-family: verdana, arial;
        font-size: 10pt;
    }

</style>

<div class="col-md-4">
    <div class="box box-success">
        <div class="box-heading"><h5 class="text-center">Catálogo Productos</h5></div>
        <div class="box-body">
            <form  method="post" action="{{route('guardarProducto')}}" accept-charset="utf-8"  enctype="multipart/form-data" class="dropzone dz-clickable" id="image-upload">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_Producto">Código</label>
                            <input name="id_Producto" id="id_Producto" readonly class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label >Servicio</label>
                        <div title="Dar check si es un servicio" class="form-group">
                            <label class="switch">
                                <input name="cktipo" id="cktipo" type="checkbox">
                                <span class="slider round"></span>
                            </label>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txt_precio">Precio</label>
                            <input onkeypress="return soloNumeros(event,txt_precio);" name="txt_precio" id="txt_precio"  class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label >Existencia</label>
                        <input onkeypress="return soloNumeros(event,txt_existencia);" name="txt_existencia" id="txt_existencia"  class="form-control input-sm">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_descripcion">Descripcion</label>
                            <textarea class="form-control input-sm" id="txt_descripcion" name="txt_descripcion" > </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
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
            </form>
        </div>
        <div class="box-footer text-right">

            <button type="submit" class="btn btn-success btn-sm" id="btnGuardarProducto">
                <i class="fa fa-save"> </i> Guardar
            </button>
            <button onclick="eliminar()" disabled class="btn btn-danger btn-sm" id="btnEliminarProducto">
                <i class="fa fa-trash-o"> </i> Eliminar
            </button>
            <a href="catalogos.producto" title="Limpiar formulario" id="btnlimpiar" class="optionMenu btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="box box-success">
        <div class="box-heading">
            <div class="row"></div>
        </div>
        <div class="box-body">
            <div class="row form-group">
                <div class="col-lg-12">
                    <div id="results" class="table-responsive">
                        <table class="table" id="tblProducto">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Existencia</th>
                                <th>Tipo</th>
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
<script src="{{asset("LDCI/js/producto.js")}}" ></script>



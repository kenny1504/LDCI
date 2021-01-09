<style>
    thead tr th {
    position: sticky;
    color:white;
    background-color:#337ab7;
    text-align: center;
    }
    .punteado{
        border-style: dotted;
        border-width: 1px;
        border-color: #660033;
        font-family: verdana, arial;
        font-size: 10pt;
    }
</style>

<div class="col-md-12">
    <div class="box box-success">
    <div class="box-heading"><legend class="text-primary text-center">Entrada</legend></div>
        <div class="box-body">
            <div class="row" style="margin: 2%">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="id_Entrada">Código de Entrada</label>
                                <div class="input-group">
                                    <input name="id_Entrada" id="id_Entrada" readonly class="form-control input-sm">
                                    <span class="input-group-btn">
                                        <button title="Mostrar Entradas" onclick="listarEntradas()" class="btn btn-default" data-toggle="modal" data-target="#ModalEntradas"
                                                id="btnMostrarEntrada" type="button"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_entrada">Fecha Entrada</label>
                                <input type="date" id="fecha_entrada" name="fecha_entrada" class="form-control input-md deshabilitar">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cmb_Proveedor">Proveedor</label>
                                <select required title="Seleccione"  id="cmb_Proveedor" class="deshabilitar form-control input-md" data-live-search="true">
                                    <option selected disabled value=""> Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="form-control-label">Producto</label>
                                <button title="Agregar Nuevo Producto" onclick="agregarProductoEntrada()" class="deshabilitar btn btn-oblong btn-primary btn-icon"
                                    data-toggle="modal" data-target="#ModalAddProducto" id="btnAgregarProducto" type="button">
                                    <div><i class="fa fa-plus"></i></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin: 1%">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div id="Entrada" class="table-responsive">
                                <br>
                                <table class="table table-hover table-striped table-sm" id="tblEntrada">
                                    <thead>
                                        <tr>
                                            <th class=" text-center" width="5%">UNIDADES</th>
                                            <th class=" text-center" width="35%">PRODUCTO</th>
                                            <th class=" text-center" width="10%">PRECIO UNITARIO $</th>
                                            <th class=" text-center" width="10%">IMPORTE $</th>
                                            <th class=" text-center" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="fila-base">
                                            <td width="5%" class="text-center">
                                                <input onkeypress="return soloNumeros(event,txt_cantidad);" onFocus="this.oldValue = this.value;"  onkeyup="precio_total(event,this);this.oldValue = this.value;"   name="txt_cantidad" id="txt_cantidad"  class="deshabilitar text-center form-control input-sm" type="text">
                                            </td>
                                            <td width="35%" class="text-center">
                                                <select name="cmb_Producto"  id="cmb_Producto" class="deshabilitar form-control input-md">
                                                    <option selected disabled value=""> Seleccione</option>
                                                </select>
                                            </td>
                                            <td width="10%" class="text-center">
                                                <input onkeypress="return soloNumeros(event,txt_precio);" onFocus="this.oldValue = this.value;" onkeyup="precio_total(event,this);this.oldValue = this.value;" name="txt_precio" id="txt_precio"  class="deshabilitar text-center form-control input-sm" type="text">
                                            </td>
                                            <td width="10%" class="Sub_precio text-center">
                                                <input readonly prevvalue="this.oldValue = this.value;" onkeypress="return soloNumeros(event,txt_Sub_precio);" name="txt_Sub_precio" id="txt_Sub_precio"  class="text-center form-control input-sm " type="text">
                                            </td>
                                            <td width="10%" class="text-center">
                                                <button class="btn btn-danger eliminarFila deshabilitar"
                                                    title="Eliminar Entrada"
                                                    id="btnEliminarFila">
                                                    <i class=" fa fa-trash"></i></button>
                                                <button class="btn btn-primary deshabilitar"
                                                <button class="btn btn-primary deshabilitar"
                                                    data-confirm="" id="btnAgregarFila"
                                                    title="Añadir Entrada">
                                                    <i class=" fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th COLSPAN=5 class="text-center"><br><br><h6 class="precio">Total Entrada: $<label id="txt_totalEntrada">0.00</label></h6></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center">
            <button title="Guardar Entrada" onclick="GuardarEntrada()" class="deshabilitar btn btn-success btn-sm" id="btnGuardarEntrada">
                <i class="fa fa-save"> </i> Guardar
            </button>
            <button onclick="anularEntrada()" disabled class="remover btn btn-danger btn-sm" id="btnEliminarEntrada">
                <i class="fa fa-trash-o"> </i> Anular
            </button>
            <a href="entrada.entrada" title="Limpiar formulario" id="btnlimpiar" class="optionMenu btn btn-md btn-warning btn-sm" ><i class="fa fa-recycle"></i> Limpiar</a>
        </div>
    </div>
</div>

<div id="ModalEntradas" class="modal fade" role="document" >
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
                        <h4 align="center">Registro de Entradas</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive" >
                            <table id="tblEntradas" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Proveedor</th>
                                        <th>Monto</th>
                                        <th>Fecha Entrada</th>
                                        <th>Estado</th>
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

<div id="ModalAddProducto" class="modal fade" role="document" >
    <div class="modal-dialog modal-lg ">
        <!-- Modal content-->
        <div class="modal-content ">
                <div class="modal-header" style="align-self: flex-end;" >
                    <a type="button" class="close mg-t-15 mg-r-20" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </a>
                </div>
                <div class="modal-body ">
                     <div class="box box-success">
                        <div class="box-heading text-info">
                            <div class="row"></div>
                            <h5 class="text-center"><legend> Nuevo Producto</legend></h5>
                        </div>
                        <div class="box-body ">
                            <form  method="post" action="{{route('guardarProductoEntrada')}}" accept-charset="utf-8"  enctype="multipart/form-data" class="dropzone dz-clickable" id="image-upload">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="txt_nombre_p_entrada">Nombre</label>
                                            <input name="txt_nombre_p_entrada" id="txt_nombre_p_entrada" class="form-control input-sm" type="text" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txt_precio_p_entrada">Precio</label>
                                            <input onkeypress="return soloNumeros(event,txt_precio);" name="txt_precio_p_entrada" id="txt_precio_p_entrada"  class="form-control input-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txt_descripcion_p_entrada">Descripcion</label>
                                            <textarea class="form-control input-sm" id="txt_descripcion_p_entrada" name="txt_descripcion_p_entrada" > </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="punteado" width=100%>
                                            <tr>
                                                <td>
                                                        <div class="text-center dz-default dz-message">
                                                        <span > Arrastre aqui imagen</span>
                                                        </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                     </div>
                     <div class="box-footer text-center">
                        <button type="submit" class="btn btn-success btn-sm" id="btnGuardarProductoEntrada">
                            <i class="fa fa-save"> </i> Guardar
                        </button>
                        <button title="Cerrar Ventana" id="btn_close_ventana" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-sm">
                            <i class="fa fa-close"> </i> Cerrar
                        </button>
                    </div>
              </div>
         </div>
        </div>
    </div>


<script src="{{asset("LDCI/js/entrada.js")}}"></script>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="charset=utf-8"/>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <title >LOGISTICA DE CARGA INTERMODAL</title>
        <style>

            @page {
                margin: 0cm 0cm;
            }

            body {
                margin: 3cm 0.5cm 0.5cm;
            }

            main{
                font-weight: normal;
                text-align: center;
            }
            header {
                position: fixed;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                text-align: center;
                line-height:0pt;
            }
            #logo{
                position: absolute;
                margin-top: 2%;
                height: 110%;
                width: 15%;
                left: 90px;
                z-index: -1;
            }
            td{
                font-size:11px !important;
                padding: 1px !important;
            }
            .td-1{
                width: 9%;
            }
            .th-2{
                width: 20%;
            }
            th{
                font-size: 11px !important;
                padding: 1px !important;
            }
            .th_ancho_grande{
                font-size: 11px !important;
                padding: 1px !important;
                height: 8.9%;
                width: 5px;
            }

            .table-borde_2 > thead > tr > th{
                border-right: 1px solid rgb(0, 0, 0);
                border-bottom: 1px solid rgb(0, 0, 0);
                border-color: #717D7E;
            }
            .table-borde_2 > tbody > tr > th,
            .table-borde_2 > tbody > tr > td {
                border-left: 1px solid rgb(0, 0, 0);
                border-color: #717D7E;

            }
            .div_borde{
                border: 1px solid rgb(0, 0, 0);
                border-color: #717D7E;
                background-color: #F2F3F4;
                padding: 5px 0px;
                border-radius: 5px 5px 10px 10px;
            }
            .table-borde_3 {
                border: 1px solid rgb(0, 0, 0);
                border-color: #717D7E;
            }
            .table-borde_3 th,
            .table-borde_3 td {
                border-right: 1px solid rgb(0, 0, 0);
                border-color: #717D7E;
                background-color: #F2F3F4;
            }
            .table-borde_4 {
                border: 1px solid rgb(0, 0, 0);
                border-color: #717D7E;
                background-color: #F2F3F4;
            }
            .table-borde_4 th,
            .table-borde_4 td {
                background-color: #F2F3F4;
            }
            .tbl_tamano{
                width: 23%;
                position: absolute;
                right: 15px;
                margin-top: -34%;
                z-index: -1;
            }
            .tbl_tamano_2{
                width: 30%;
                position: absolute;
                margin-top: -15%;
                right: -3.2px;
                z-index: -1;
            }
            .tbl_tamano_5{
                width: 70%;
                margin-top: 1%;
                margin-left: -1px;
            }
            .tbl_tamano_6{
                width: 49.8%;
                margin-left: 0px;
                margin-top: -2.1%;
            }
            .tbl_tamano_6A{
                width: 49.8%;
                position: absolute;
                margin-top: 7.1%;
                right: 0px;
                z-index: -1;
            }
            .table-borde_6 {
            }
            .table-borde_6 th,
            .table-borde_6 td {
                border-color: #717D7E;
                background-color: #F2F3F4;
            }
            .alinear{
                text-align: center;
            }
            .alinear_2{
                text-align: left;
            }
            .alinear_3{
                text-align: left;
                margin-top: -1%;
            }
            .tamano_fuente_1{
                font-size:12px !important ;
            }
            .tamano_fuente_2{
                font-size:14px !important;
                font-style: italic !important;
                margin-left: 4px !important;
            }
            .tamano_fuente_3{
                font-size:13px !important;
                font-style: italic !important;
            }
            .ancho_celda{
                height: 1.7%;
            }
            .ancho_celda_2{
                height: 2.07%;
            }
            .largo_celda_2
            {
                width: 50%;
            }
            .largo_celda_info{
                width: 25%;
            }
            .ancho_tabla{
                width: 100% !important;
            }
            .ancho_columna{
                width: 37% !important;
                height: 2.1%;
            }
            .alto_detalle{
                width: 100%;
                height: 50%;
                min-height: 64%;
            }
            .text_color{
                color: #717D7E ;
            }
            .text_color_c{
                color: #1A5276 ;
            }
            .loc_remitente{
                position: absolute;
                margin-top: 5%;
                right: 260px;
                z-index: -1;
            }
        </style>
    </head>

    <body>
        <header>
            <img id="logo" src="images/Logo-Intermodal.png">
            <h3>LOGISTICA DE CARGA INTERMODAL</h3>
            <h5>BAC LAS PALMAS 70 MTS AL OESTE, MANAGUA, NICARAGUA</h5>
            <h6>Telefonos +(505) 2220 7707 / +1 (347) 298 6449</h6>
        </header>

        <main>
            @foreach($Informacion as $informacion)
            <h3 class="text_color_c">Factura</h3>
            <table class="tbl_tamano">
                    <tr>
                        <th class="tamano_fuente_1 text_color_c largo_celda_2">N° Factura:</th>
                        <td class="tamano_fuente_1 text_color ">{{$informacion->codigo}} </td>
                    </tr>
                    <tr>
                        <th class="tamano_fuente_1 text_color_c">Fecha:</th>
                        <td class="tamano_fuente_1 text_color ">{{$informacion->fecha_factura}}</td>
                    </tr>
            </table>
            <h4 class=" text_color_c loc_remitente">Consignatario:</h4>
            <table class="table-responsive tbl_tamano_6A table-borde_6">
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">{{$informacion->consignatario}}</th>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">Dir: {{$informacion->direccionc}}</th>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">Tel: +{{$Consig}} {{$informacion->telefonoc}}</th>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">Correo: {{$informacion->correoc}}</th>
                </tr>
            </table>

            <h4 class="text-left text_color_c" style="margin-top: 5%">Remitente:</h4>
            <table class="table-responsive tbl_tamano_6 table-borde_6">
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">{{$informacion->cliente}}</th>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">Dir: {{$informacion->direccioncl}}</th>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">Tel: +{{$codCliente}} {{$informacion->telefonocl}} </th>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color ancho_celda_2">Correo: {{$informacion->correocl}}</th>
                </tr>
            </table>
            <h4 class=" text_color_c " style="margin-top: 0%">Informacion</h4>
            <table class="table-responsive ancho_tabla table-borde_6" style="margin-top: -1.2%">
                <thead>
                    <tr>
                        <th class="text_color_c largo_celda_info">Origen</th>
                        <th class="text_color_c largo_celda_info">Destino</th>
                        <th class="text_color_c " style="width: 15%">Transporte</th>
                        <th class="text_color_c " style="width: 11%">Fecha de Envio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text_color ancho_celda">{{$informacion->c_origen}}</th>
                        <th class="text_color ancho_celda">{{$informacion->c_destino}}</th>
                        <th class="text_color">{{$informacion->t_transporte}}</th>
                        <th class="text_color">{{$informacion->fecha_envio}}</th>
                    </tr>
                </tbody>
            </table>
            <table class="table-responsive ancho_tabla table-borde_6">
                <thead>
                    <tr>
                        <th class="text_color_c largo_celda_info">Terminos</th>
                        <th class="text_color_c largo_celda_info " style="width: 15%">Vendedor</th>
                        <th class="text_color_c " style="width: 15%">Moneda</th>
                        <th class="text_color_c " style="width: 11%">Fecha llegada</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text_color ancho_celda">{{$informacion->terminos}}</th>
                        <th class="text_color ancho_celda"></th>
                        <th class="text_color">{{$informacion->moneda}}</th>
                        <th class="text_color">{{$informacion->fecha_entrega}}</th>
                    </tr>
                </tbody>
            </table>

            <h4 class=" text_color_c " style="margin-top: 0.5%">Detalle</h4>
            <div class="div_borde alto_detalle" style="margin-top: -1%">
                <table class="ancho_tabla table-borde_2">
                    <thead>
                        <tr>
                            <th class="alinear ancho_celda text_color_c">Itm</th>
                            <th class="alinear td-1 text_color_c">Cod. Prod</th>
                            <th class="th-2 text_color_c alinear">Carga y Servicio</th>
                            <th class="text_color_c alinear">Descripción</th>
                            <th class="alinear text_color_c">Cantidad</th>
                            <th class="th-2 text_color_c alinear">Modo Transporte</th>
                            <th class="text_color_c alinear">Precio</th>
                            <th class="text_color_c alinear">Dto.%</th>
                            <th class="text_color_c alinear">Imp.Monto</th>
                            <th class="text_color_c alinear">Importe</th>
                        </tr>
                    </thead>
                    <tbody >
                    @foreach ($Detalle as $detalle)
                        <tr >
                            <td class="text_color ancho_celda alinear">{{$detalle->no}}</td>
                            <td class="text_color alinear">{{$detalle->codigo}}</td>
                            <td class="text_color">{{$detalle->carga}}</td>
                            <td class="text_color">{{$detalle->descripcion}}</td>
                            <td class="text_color alinear">{{$detalle->cantidad}}</td>
                            <td class="text_color">{{$detalle->transporte}}</td>
                            <td class="text_color alinear">{{$detalle->precio}}</td>
                            <td class="text_color alinear">{{$detalle->dto}}</td>
                            <td class="text_color alinear">{{$detalle->iva}}</td>
                            <td class="text_color alinear">{{$detalle->total}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

                <table class="table-borde_4 table-responsive tbl_tamano_5">
                    <tr>
                        <th class="text_color_c alinear_3 th_ancho_grande tamano_fuente_2" valign="top">Nota Adicional:</th>
                        <td class="text_color alinear_3 tamano_fuente_3"  valign="top">{{$informacion->nota}}</td>
                    </tr>
                </table>

                <table class=" table-borde_3 table-responsive tbl_tamano_2">
                    <tr>
                        <th class="text_color_c alinear_2 ancho_celda_2 tamano_fuente_1">Subtotal</th>
                        <td class="text_color ancho_columna alinear_2 tamano_fuente_1">$ {{$informacion->subtotal}}</td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda_2 alinear_2 tamano_fuente_1 ">Descuento</th>
                        <td class="text_color alinear_2 tamano_fuente_1">$ {{$informacion->descuento}}</td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda_2 alinear_2 tamano_fuente_1">Miscelaneos</th>
                        <td class="text_color alinear_2 tamano_fuente_1">$ {{$informacion->micelaneos}}</td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda_2 alinear_2 tamano_fuente_1">Iva</th>
                        <td class="text_color alinear_2 tamano_fuente_1">$ {{$informacion->iva}}</td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda_2 alinear_2 tamano_fuente_1"><strong>Total</strong></th>
                        <td class="text_color alinear_2 tamano_fuente_1">{{$informacion->total}}</td>
                    </tr>
                </table>
            @endforeach
        </main>
        <footer>
            <script type="text/php">
                date_default_timezone_set("America/Managua");
                    if ( isset($pdf) ) {
                        $pdf->page_script('
                            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                            $pdf->text(220, 805, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
                            $pdf->text(50, 805, date("d-m-Y H:i:s"), $font, 10);
                            $pdf->text(370, 805, "https://ldci.cargologisticsintermodal.com", $font, 10);
                        ');
                    }
                </script>
        </footer>
    </body>
</html>

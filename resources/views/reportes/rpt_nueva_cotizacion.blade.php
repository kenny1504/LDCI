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
            .td-3{
                width: 30%;
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
            .mg1{
                margin-top: 10px;
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
                z-index: -1;
            }
            .tbl_tamano_2{
                width: 30%;
                position: absolute;
                margin-top: -15%;
                right: -3.2px;
                z-index: -1;
            }
            .tbl_tamano_3{
                width: 50%;
                margin-left: -1px;
            }
            .tbl_tamano_4{
                width: 50%;
                position: absolute;
                margin-top: 5.67%;
                right: -3.2px;
                z-index: -1;
            }
            .tbl_tamano_5{
                width: 70%;
                margin-top: 1%;
                margin-left: -1px;
            }
            .alinear{
                text-align: center;
            }
            .alinear_2{
                text-align: right;
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
            .largo_celda_2
            {
                width: 50%;
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
                height: 64%;
            }
            .text_color{
                color: #717D7E ;
            }
            .text_color_c{
                color: #1A5276 ;
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
            <table class="tbl_tamano">
                    <tr>
                        <th class="tamano_fuente_1 text_color_c largo_celda_2">N° Cotización:</th>
                        <td class="tamano_fuente_1 text_color ">{{$informacion->n_cotizacion}}</td>
                    </tr>
                    <tr>
                        <th class="tamano_fuente_1 text_color_c">Fecha:</th>
                        <td class="tamano_fuente_1 text_color ">{{$informacion->fecha_creacion}}</td>
                    </tr>
            </table>
            <br>

            <table class="table-responsive tbl_tamano_4">
                <tr>
                    <th class="tamano_fuente_1 text_color_c td-3 alinear_2 td-3 ">Origen:</th>
                    <td class="tamano_fuente_1 text_color">{{$informacion->c_origen}}</td>
                </tr>
                <tr>
                    <th class="tamano_fuente_1 text_color_c td-3 alinear_2">Destino:</th>
                    <td class="tamano_fuente_1 text_color">{{$informacion->c_destino}}</td>
                </tr>
        </table>
            <h3 class="text_color_c">Cotización</h3>
            <table class="table-responsive tbl_tamano_3 mg1">
                    <tr>
                        <th class="tamano_fuente_1 text_color_c td-3 alinear_2">Usuario:</th>
                        <td class="tamano_fuente_1 text_color">{{$informacion->usuario_crea}}</td>
                    </tr>
                    <tr>
                        <th class="tamano_fuente_1 text_color_c td-3 alinear_2">Fecha de Envio:</th>
                        <td class="tamano_fuente_1 text_color">{{$informacion->fecha}}</td>
                    </tr>
                    <tr>
                        <th class="tamano_fuente_1 text_color_c alinear_2">Transporte:</th>
                        <td class="tamano_fuente_1 text_color">{{$informacion->t_transporte}}</td>
                    </tr>
            </table>
            @endforeach


            <div class="div_borde alto_detalle mg1 sombra">
                <table class="ancho_tabla table-borde_2   ">
                    <thead>
                        <tr>
                            <th class="alinear ancho_celda text_color_c">Itm</th>
                            <th class="alinear td-1 text_color_c">Cod. Prod</th>
                            <th class="th-2 text_color_c">Carga y Servicio</th>
                            <th class="text_color_c">Descripción</th>
                            <th class="alinear text_color_c">Cantidad</th>
                            <th class="th-2 text_color_c">Modo Transporte</th>
                            <th class="text_color_c">Precio</th>
                            <th class="text_color_c">Dto.%</th>
                            <th class="text_color_c">Imp.Monto</th>
                            <th class="text_color_c">Importe</th>
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
                                <td class="text_color">{{$detalle->dto}}</td>
                                <td class="text_color"></td>
                                <td class="text_color"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


                <table class="table-borde_4 table-responsive tbl_tamano_5">
                    <tr>
                        <th class="text_color_c alinear_3 th_ancho_grande tamano_fuente_2" valign="top">Nota Adicional:</th>
                        <td class="text_color alinear_3 tamano_fuente_3"  valign="top"> {{$informacion->nota}}</td>
                    </tr>
                </table>



                <table class=" table-borde_3 table-responsive tbl_tamano_2">
                    <tr>
                        <th class="text_color_c ancho_celda alinear_2 tamano_fuente_1 "></th>
                        <td class="text_color ancho_columna alinear_2 tamano_fuente_1"></td>
                    </tr>
                    <tr>
                        <th class="text_color_c alinear_2 ancho_celda tamano_fuente_1">Subtotal</th>
                        <td class="text_color ancho_columna alinear_2 tamano_fuente_1"></td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda alinear_2 tamano_fuente_1 ">Descuento</th>
                        <td class="text_color alinear_2 tamano_fuente_1"></td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda alinear_2 tamano_fuente_1">Miscelaneos</th>
                        <td class="text_color alinear_2 tamano_fuente_1"></td>
                    </tr>
                    <tr>
                        <th class="text_color_c ancho_celda alinear_2 tamano_fuente_1"><strong>TOTAL</strong></th>
                        <td class="text_color alinear_2 tamano_fuente_1"></td>
                    </tr>
                </table>
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

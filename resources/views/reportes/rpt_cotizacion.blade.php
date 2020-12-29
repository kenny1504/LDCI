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
            .td-table{
                height: 300px;padding: 34px;
            }
            .td-1{
                width: 10%;
            }
            .th-2{
                width: 20%;
            }
            .td-3{
                width: 30%;
            }
            .td-4{
                width: 25%;
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
            .th_ancho_pequeno{
                font-size: 11px !important;
                padding: 1px !important;
                height: 2.75%;
                width: 5px;
            }
            .th_1{
                font-size: 13px !important;
                padding: 4px !important;
            }
            .th_2{
                font-size: 13px !important;
                padding: 1.3px !important;
                padding-left: 3px;
            }
            .mg{
                margin: -1px;
            }
            .table-borde_1{
                border: 1px solid rgb(0, 0, 0);
            }
            .table-borde_1 > thead > tr > th,
            .table-borde_1 > tbody > tr > th,
            .table-borde_1 > tbody > tr > td{
                border: 1px solid rgb(0, 0, 0);
            }
            .table-borde_1 > thead > tr > th,
            .table-borde_1 > thead > tr > td {
                border-bottom-width: 1px;
            }
            .table-borde_2 > thead > tr > th{
                border: 1px solid rgb(0, 0, 0);
            }
            .table-borde_2 > tbody > tr > th,
            .table-borde_2 > tbody > tr > td {
                border-left: 1px solid rgb(0, 0, 0);
                border-right: 1px solid rgb(0, 0, 0);
            }
            .div_borde{
                border: 1px solid rgb(0, 0, 0);
            }
            .table-borde_3 {
                border: 1px solid rgb(0, 0, 0);
            }
            .table-borde_3 th,
            .table-borde_3 td {
                border-right: 1px solid rgb(0, 0, 0);
            }
            .table-borde_4 {
                border: 1px solid rgb(0, 0, 0);
                border-radius: 20px;
            }
            .table-borde_5 {
                border: 1px solid rgb(0, 0, 0);
            }
            .tbl_tamano{
                height: 23%;
                width: 23%;
                position: absolute;
                margin-top: 0%;
                right: 15px;
                z-index: -1;
            }
            .tbl_tamano_2{
                width: 30.5%;
                position: absolute;
                margin-top: -15%;
                right: -3.2px;
                z-index: -1;
            }
            .tbl_tamano_3{
                width: 50.16%;
                margin-left: -1px;
            }
            .tbl_tamano_4{
                width: 50.29%;
                position: absolute;
                margin-top: 8.67%;
                right: -3.2px;
                z-index: -1;
            }
            .tbl_tamano_5{
                width: 70%;
                margin-top: 1%;
                margin-left: -1px;
            }
            .titulo{
                position: absolute;
                margin-top: 5.96%;
                right: 298px;
                z-index: -1;
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
            .position_text{
                margin: 0%;
                padding: 0;
            }
            .espacio{
                padding-top: 1% !important;
            }
            .ancho_celda{
                height: 1.7%;
            }
            .largo_celda
            {
                width: 35.4%;
            }
            .ancho_celda_2{
                height: 1.75%;
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
                height: 52%;
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
            <table class="table table-borde_1 tbl_tamano">
               <tr>
                    <th class="alinear" COLSPAN=2>Cotización</th>
                    <tr>
                        <th>Numero</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Página</th>
                        <td></td>
                    </tr>
               </tr>
            </table>
            <br>

            <h4 class=" titulo">Enviar a:</h4>
            <table class="table-borde_4 table-responsive tbl_tamano_4">
                <tr>
                    <th class="ancho_celda_2 th_2 alinear_3"></th>
                </tr>
                <tr>
                    <th class="ancho_celda_2 th_2 alinear_3"></th>
                </tr>
                <tr>
                    <th class="ancho_celda_2 th_2 alinear_3"></th>
                </tr>
                <tr>
                    <th class="ancho_celda_2 th_2 alinear_3"></th>
                </tr>
            </table>

            <h3>Cotizacion</h3>
            <h4 class="alinear_3 espacio">Presentado a:</h4>
            <table class="table-borde_4 table-responsive tbl_tamano_3">
                <tr>
                    <th class="ancho_celda th_1 alinear_3"></th>
                </tr>
                <tr>
                    <th class="ancho_celda th_1 alinear_3"></th>
                </tr>
                <tr>
                    <th class="ancho_celda th_1 alinear_3"></th>
                </tr>
            </table>

            <table class="table table-borde_1 table-responsive mg">
                <thead>
                    <tr>
                        <th class="td-4">Código Cliente</th>
                        <th class="td-4">RUC</th>
                        <th class="td-4">Referencia</th>
                        <th class="td-4">Terminos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ancho_celda"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-borde_1 table-responsive mg">
                <thead>
                    <tr>
                        <th>Vendedor</th>
                        <th>Moneda</th>
                        <th class="td-3">Emite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ancho_celda largo_celda"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <div class="div_borde alto_detalle mg">
                <table class="ancho_tabla table-borde_2   ">
                    <thead>
                        <tr>
                            <th class="ancho_celda">Itm</th>
                            <th class="td-1">Cod. Prod</th>
                            <th class="th-2">Descripcion Producto</th>
                            <th>Bodg</th>
                            <th>Cantidad</th>
                            <th>Unid.</th>
                            <th>Precio</th>
                            <th>Dto.%</th>
                            <th>Imp.%</th>
                            <th>Imp.Monto</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr >
                                <td class="ancho_celda"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <table class="table-responsive tbl_tamano_5 table-borde_5">
                <tr>
                    <th class=" alinear_3 th_ancho_grande tamano_fuente_2" valign="top">Aviso:</th>
                    <td class="alinear_3 tamano_fuente_3"  valign="top"></td>
                </tr>
                <tr>
                    <th class="alinear_3 th_ancho_pequeno tamano_fuente_2">Firma:</th>
                    <td class="alinear_3 tamano_fuente_3"></td>
                </tr>
            </table>

            <table class="table-borde_3 table-responsive tbl_tamano_2">
                <tr>
                    <th class=" alinear_2">Subtotal</th>
                    <td class="ancho_columna alinear_2 tamano_fuente_1"></td>
                </tr>
                <tr>
                    <th class="ancho_celda alinear_2">Descuento Parcial</th>
                    <td class=" alinear_2 tamano_fuente_1"></td>
                </tr>
                <tr>
                    <th class="ancho_celda alinear_2">Descuento Global</th>
                    <td class=" alinear_2 tamano_fuente_1"></td>
                </tr>
                <tr>
                    <th class="ancho_celda alinear_2 ">Miscelaneos</th>
                    <td class=" alinear_2 tamano_fuente_1"></td>
                </tr>
                <tr>
                    <th class="ancho_celda alinear_2">Impuesto</th>
                    <td class=" alinear_2 tamano_fuente_1"></td>
                </tr>
                <tr>
                    <th class="ancho_celda alinear_2"><strong>TOTAL</strong></th>
                    <td class=" alinear_2 tamano_fuente_1"></td>
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

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
                margin: 3cm 2cm 2cm;
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
                font-size:12px !important;
                padding: 1 !important;
            }
            th{
                font-size:12px !important;
                padding: 1 !important;
            }
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                color: white;
                text-align: center;
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
            <h4>Listado de Productos y Servicios</h4>
            <br>
            <table id="tblProductos" class="table table-responsive table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Existencia</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td> {{$producto->no}}</td>
                            <td> {{$producto->nombre_producto}}</td>
                            <td> {{$producto->tipo}}</td>
                            <td> {{$producto->existencia}}</td>
                            <td> {{$producto->precio}}</td>
                            <td> {{$producto->descripcion}}</td>
                        </tr>
                    @endforeach
                </tbody>
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

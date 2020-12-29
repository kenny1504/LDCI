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
                position:absolute;
                margin-top: 2%;
                height: 110%;
                width: 15%;
                left: 160px;
                z-index: -1;
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
            <h2>LOGISTICA DE CARGA INTERMODAL</h2>
            <h5>BAC LAS PALMAS 70 MTS AL OESTE, MANAGUA, NICARAGUA</h5>
            <h6>Telefonos +(505) 2220 7707 / +1 (347) 298 6449</h6>
        </header>

        <main>
            <h4>Listado de Clientes</h4>
            <br>
            <table id="tblClientes" class="table table-responsive table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nombre</th>
                        <th>Identificación</th>
                        <th>Tipo</th>
                        <th>Ciudadanía</th>
                        <th>Teléfono Empresa</th>
                        <th>Teléfono Contacto</th>
                        <th>Giro del Negocio</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td> {{$cliente->no}}</td>
                            <td> {{$cliente->nombre}}</td>
                            <td> {{$cliente->identificacion}}</td>
                            <td> {{$cliente->tipo}}</td>
                            <td> {{$cliente->ciudadania}}</td>
                            <td> {{$cliente->telefono_empresarial}}</td>
                            <td> {{$cliente->telefono_contacto}}</td>
                            <td> {{$cliente->giro_negocio}}</td>
                            <td> {{$cliente->correo}}</td>
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
                            $pdf->text(320, 560, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
                            $pdf->text(50, 560, date("d-m-Y H:i:s"), $font, 10);
                            $pdf->text(620, 560, "https://ldci.cargologisticsintermodal.com", $font, 10);
                        ');
                    }
                </script>
        </footer>
    </body>
</html>

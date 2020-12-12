<!DOCTYPE html>
<html>
<head>
    <title >LOGISTICA DE CARGA INTERMODAL</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
        table {
            width: 100%;
        }
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
        h5{
            position:fixed;
            font-weight: normal;
            color: black;
            top: 7.5%;
            left: 12%;
        }
        h2{
            margin-top: 5%;
            color: blue;
        }
    </style>
</head>

<body>

<header>
    <img id="logo" src="images/Logo-Intermodal.png">
    <h2>LOGISTICA DE CARGA INTERMODAL</h2>
    <h5>BAC LAS PALMAS 70 MTS AL OESTE, MANAGUA, NICARAGUA</h5>
</header>

<main>
    <h3>Listado de Vendedores</h3>
    <br>
    <table id="tblVendedores" class="table table-striped table-hover table-responsive cell-border">
        <thead>
        <tr>
            <th>No</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Identificacion</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Tipo</th>
            <th>Direccion</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</main>

<footer>
    <script type="text/php">
        date_default_timezone_set("America/Managua");
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(270, 560, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
                    $pdf->text(50, 560, date("d-m-Y H:i:s"), $font, 10);
                ');
            }

         </script>
</footer>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>RESULTADOS DEL DIAGNÓSTICO</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 190px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #FFF;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url('https://www.ccsm.org.co/templates/shaper_helix3/images/menubackred.jpg');
        }

        #project {
            float: left;
            margin-bottom: 30px;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 86px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-top: 80px;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .col1,
        table .col2 {
            text-align: left;
        }

        table td {
            padding: 20px;
            text-align: left;
        }

        table td.col1,
        table td.col2 {
            vertical-align: top;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
            margin-left: 20px;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }

        footer {
            color: #000;
            width: 100%;
            border-top: 1px solid #2a0927;
            padding: 8px 0;
            text-align: center;
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            line-height: 35px;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="https://www.ccsm.org.co/images/logo.png">
    </div>
    <h1>RESULTADOS DEL DIAGNÓSTICO</h1>
</header>
<main>
    <div id="project">
        <div><span>REALIZADO POR:</span> {{ $diagnosticoREALIZADO_POR }}</div>
        <div><span>FECHA:</span> {{ $diagnosticoFECHA }}</div>
        <div><span>RESULTADO:</span> {{ number_format($diagnosticoRESULTADO, 0) }}%</div>
        <div><span>NIVEL:</span> {{ $diagnosticoNIVEL }}</div>
    </div>
    <table>
        <tbody>
        <tr>
            <td class="col1">Ahora estás aquí</td>
            <td class="desc">{{ $diagnosticoMENSAJE }}</td>
        </tr>
        <tr>
            <td class="col1">A partir de ahora necesitas</td>
            <td class="col2">{{ $diagnosticoMENSAJE2 }}</td>
        </tr>
        <tr>
            <td class="col1">Para lograrlo necesitas</td>
            <td class="col2">{{ $diagnosticoMENSAJE4 }}</td>
        </tr>
        <tr>
            <td class="col1">¡ATENCIÓN! Debes tener cuidado:</td>
            <td class="col2">{{ $diagnosticoMENSAJE3 }}</td>
        </tr>
        </tbody>
    </table>
    <div id="notices">
        <div class="notice">Puedes revisar la ruta para mejorar en <a target="_blank" href="https://rutadecrecimiento.com">rutadecrecimiento.com</a></div>
    </div>
</main>
<footer>
    Cámara de Comercio de Santa Marta para el Magdalena - Calle 24 # 2 -66, Barrio Bellavista - (575) 4 20 99 09
</footer>
</body>
</html>

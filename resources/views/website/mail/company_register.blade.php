<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #outlook a {
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            color: #333;
            margin: 0;
        }

        a {
            color: #333;
            text-decoration: none;
        }
    </style>
    <!--[if mso]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--[if lte mso 11]>
    <style>
        .mj-outlook-group-fix { width:100% !important; }
    </style>
    <![endif]-->
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
        p, ul {
            font-family:Ubuntu, Helvetica, Arial, sans-serif;
        }
    </style>
    <!--<![endif]-->
</head>
<body style="background-color:#f2f2f2; padding: 30px 0">
<table style="width: 600px; background: #fff; margin: 0 auto; text-align: center">
    <tr>
        <td style="padding: 20px 40px; background: #f2f2f2;">
            <img style="width: 70%" src="https://rutadecrecimiento.com/img/commons/logo-mail.jpg" alt="Ruta de crecimiento">
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px;">
            <p style="padding-top: 40px; font-size: 16px; color: #0c1892; font-weight: bold; text-transform: uppercase">
                Bienvenido al sistema de Ruta de crecimiento
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px">
            <p style="padding-top: 20px; font-size: 16px">
                Se ha recibido en nuestro sistema una solicitud de registro. Recomendamos validar que esta acción haya sido generada por personal de la compañía.
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 40px;">
            <hr style="border: none; border-bottom: 1px solid #ccc; margin: 0" />
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px">
            <p style="font-size: 14px; font-weight: bold; text-align: left; color: #0c1892">
                Los datos de acceso fueron:
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px">
            <ul style="text-align: left; margin: 0; padding: 20px 0 0 20px; color: #333; font-size: 14px; line-height: 25px">
                <li>Empresa: {{ $data->business_name }}</li>
                <li>Nit: {{ $data->nit}}</li>
                <li>Persona de contacto: {{ $data->contact_person }}</li>
                <li>Mail registrado: {{ $data->user->email }}</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="padding: 40px 0 20px 40px;">
            <hr style="border: none; border-bottom: 1px solid #ccc; margin: 0" />
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px;">
            <p style="font-size: 13px; line-height: 20px">
                Si no reconoce esta acción y desea reportar este caso, se puede comunicar a:
                <br />
                {{App\helpers::getSettingValue(0)}}
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 40px 40px 40px;">
            <hr style="border: none; border-bottom: 1px solid #ccc; margin: 0" />
        </td>
    </tr>
    <tr>
        <td style="padding: 0 40px;">
            <p style="font-size: 13px; line-height: 20px">
                Gracias por usar nuestro sistema de Ruta C
                <br />
                <a href="https://www.rutadecrecimiento.com" style="color: #0c1892; font-weight: bold">www.rutadecrecimiento.com</a>
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px"></td>
    </tr>
</table>
</body>
</html>

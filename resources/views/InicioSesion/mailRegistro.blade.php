<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <div id=":nx" class="a3s aiL ">
        <table border="0" cellspacing="0" cellpadding="0" style="max-width:600px">
            <tbody>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td align="left">
                                    </td>
                                    <td align="right">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr height="16">
                </tr>
                <tr>
                    <td>
                        <table bgcolor="#4184F3" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:332px;max-width:600px;border:1px solid #e0e0e0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px">
                            <tbody>
                                <tr>
                                    <td height="72px" colspan="3"></td>
                                </tr>
                                <tr>
                                    <td width="32px"></td>
                                    <td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:24px;color:#ffffff;line-height:1.25">
                                        Código de verificación de LDCI
                                    </td>
                                    <td width="32px"></td>
                                </tr>
                                <tr><td height="18px" colspan="3"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table bgcolor="#FAFAFA" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px">
                            <tbody>
                                <tr height="16px">
                                    <td width="32px" rowspan="3"></td>
                                    <td></td>
                                    <td width="32px" rowspan="3"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Hola {{ $name }}, gracias por registrarte en <strong>LOGISTICA DE CARGA INTERMODAL</strong> !</p>
                                        <br><br>
                                        <p>Hemos recibido una solicitud para acceder a nuestro sistema</p>
                                        <p>Por favor confirma tu correo electrónico.</p>
                                        <p>Para ello simplemente debes hacer click en el siguiente enlace:</p>
                                            <div style="text-align:center">
                                                <p dir="ltr">
                                                    <strong style="text-align:center;font-size:24px;font-weight:bold">
                                                        <a href="{{ url('/registro/vericar/' . $confirmation_code) }}">
                                                        Clic para confirmar tu email
                                                        </a>
                                                    </strong>
                                                </p>
                                            </div>
                                            <p>Atentamente,</p>
                                            <p>El equipo de LDCI</p>
                                        </td>
                                </tr>
                                <tr height="32px"></tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr height="16"></tr>
                <tr>
                    <td style="max-width:600px;font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#bcbcbc;line-height:1.5">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#666666;line-height:18px;padding-bottom:10px">
                                            <tbody>
                                                <tr>
                                                    <td>Este correo electrónico no puede recibir respuestas. Para obtener más información, accede sitio
                                                        <a href="https://cargologisticsintermodal.com/" style="text-decoration:none;color:#4d90fe" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://support.google.com/accounts/troubleshooter/2402620?ref_topic%3D2364467&amp;source=gmail&amp;ust=1602993676511000&amp;usg=AFQjCNHtHmFe4PLZr2anGgUxMPXjF36QXw">
                                                            LOGISTICA DE CARGA INTERMODAL
                                                        </a>.
                                                        <br>Copyright - {{date("yy")}}. LDCI. All Rights Reserved.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>



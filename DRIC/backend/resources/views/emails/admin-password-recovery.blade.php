<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva contrasena temporal - Panel DRIC</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, Helvetica, sans-serif; color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f1f5f9; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px; overflow:hidden; border-radius:24px; background:#ffffff; box-shadow:0 24px 80px rgba(15,23,42,0.12);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#164194 0%,#071126 70%,#b5121b 100%); padding:34px 36px; color:#ffffff;">
                            <p style="margin:0 0 12px; font-size:12px; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:rgba(255,255,255,0.72);">
                                Panel DRIC
                            </p>
                            <h1 style="margin:0; font-size:30px; line-height:1.2; font-weight:700;">
                                Nueva contrasena temporal
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px 36px;">
                            <p style="margin:0 0 18px; font-size:16px; line-height:1.7; color:#334155;">
                                Hola {{ $user->name ?? 'usuario' }}, recibimos una solicitud para recuperar el acceso al Panel DRIC.
                            </p>

                            <p style="margin:0 0 10px; font-size:13px; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#64748b;">
                                Tu nueva contrasena
                            </p>

                            <div style="margin:0 0 24px; padding:18px 22px; border-radius:18px; background:#eef2ff; color:#0f2f6f; font-size:34px; font-weight:800; letter-spacing:0.18em; text-align:center;">
                                {{ $temporaryPassword }}
                            </div>

                            <p style="margin:0 0 24px; font-size:15px; line-height:1.7; color:#475569;">
                                Ingresa al panel con esta contrasena temporal. Luego puedes cambiarla desde tu perfil.
                            </p>

                            <p style="margin:0;">
                                <a href="{{ $loginUrl }}" style="display:inline-block; padding:13px 18px; border-radius:14px; background:#164194; color:#ffffff; font-size:14px; font-weight:700; text-decoration:none;">
                                    Ingresar al panel
                                </a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:22px 36px; background:#020617; color:rgba(255,255,255,0.66); font-size:12px; line-height:1.6;">
                            Si no solicitaste este cambio, avisa a Direccion para revisar el acceso de tu cuenta.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

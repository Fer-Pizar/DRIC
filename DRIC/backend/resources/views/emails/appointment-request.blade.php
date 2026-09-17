<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <title>{{ $subjectLine }}</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:Arial, Helvetica, sans-serif; color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f1f5f9; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px; overflow:hidden; border-radius:24px; background:#ffffff; box-shadow:0 24px 80px rgba(15,23,42,0.12);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#003770 0%,#071126 58%,#E30613 100%); padding:34px 36px; color:#ffffff;">
                            <p style="margin:0 0 12px; font-size:12px; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:rgba(255,255,255,0.72);">
                                {{ $locale === 'en' ? 'DRIC appointment request' : 'Solicitud de cita DRIC' }}
                            </p>
                            <h1 style="margin:0; font-size:30px; line-height:1.2; font-weight:700;">
                                {{ $appointment['name'] }}
                            </h1>
                            <p style="margin:14px 0 0; font-size:16px; line-height:1.6; color:rgba(255,255,255,0.82);">
                                {{ $appointment['topic'] }}
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px 36px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding:0 0 18px;">
                                        <p style="margin:0; font-size:12px; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:#64748b;">
                                            {{ $locale === 'en' ? 'Contact details' : 'Datos de contacto' }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate; border-spacing:0 10px;">
                                <tr>
                                    <td style="width:38%; padding:14px 16px; border-radius:14px 0 0 14px; background:#f8fafc; color:#64748b; font-size:13px; font-weight:700;">
                                        {{ $locale === 'en' ? 'Email' : 'Correo electrónico' }}
                                    </td>
                                    <td style="padding:14px 16px; border-radius:0 14px 14px 0; background:#f8fafc; font-size:14px;">
                                        <a href="mailto:{{ $appointment['email'] }}" style="color:#003770; text-decoration:none;">{{ $appointment['email'] }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:38%; padding:14px 16px; border-radius:14px 0 0 14px; background:#f8fafc; color:#64748b; font-size:13px; font-weight:700;">
                                        {{ $locale === 'en' ? 'Phone / WhatsApp' : 'Teléfono / WhatsApp' }}
                                    </td>
                                    <td style="padding:14px 16px; border-radius:0 14px 14px 0; background:#f8fafc; font-size:14px;">
                                        {{ $appointment['phone'] ?? ($locale === 'en' ? 'Not provided' : 'No indicado') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:38%; padding:14px 16px; border-radius:14px 0 0 14px; background:#f8fafc; color:#64748b; font-size:13px; font-weight:700;">
                                        {{ $locale === 'en' ? 'Suggested date' : 'Fecha sugerida' }}
                                    </td>
                                    <td style="padding:14px 16px; border-radius:0 14px 14px 0; background:#f8fafc; font-size:14px;">
                                        {{ $appointment['date'] ?? ($locale === 'en' ? 'Not provided' : 'No indicada') }}
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top:28px; padding:24px; border:1px solid #e2e8f0; border-radius:20px; background:#ffffff;">
                                <p style="margin:0 0 12px; font-size:12px; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:#E30613;">
                                    {{ $locale === 'en' ? 'Request' : 'Consulta' }}
                                </p>
                                <p style="margin:0; white-space:pre-line; font-size:15px; line-height:1.75; color:#334155;">{{ $appointment['message'] }}</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:22px 36px; background:#020617; color:rgba(255,255,255,0.66); font-size:12px; line-height:1.6;">
                            {{ $locale === 'en'
                                ? 'This message was sent from the DRIC appointment form.'
                                : 'Este mensaje fue enviado desde el formulario de agenda de citas de la DRIC.' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

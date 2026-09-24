<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
        style="background-color:#f4f4f5; padding: 30px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="background-color:#2e7d32; padding: 24px; text-align:center;">
                            <img src="{{ asset('images/logo.jpg') }}" alt="ENEF" style="max-height:80px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin-top:0; color:#1a1a1a;">{{ $greeting }}</h2>

                            @foreach ($lines as $line)
                                <p style="color:#333333; font-size:15px; line-height:1.6;">{{ $line }}</p>
                            @endforeach

                            {{-- Bloc d'informations (optionnel) : ex. identifiants de connexion, affiché si $details est fourni --}}
                            @if (!empty($details))
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="margin: 20px 0;">
                                    <tr>
                                        <td
                                            style="background-color:#f4f8f4; border:1px solid #cfe2d1; border-left:4px solid #2e7d32; padding:16px 20px;">
                                            @foreach ($details as $label => $value)
                                                <p
                                                    style="margin:0 0 4px 0; color:#2e7d32; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:0.5px;">
                                                    {{ $label }}
                                                </p>
                                                <p
                                                    style="margin:0 0 {{ $loop->last ? '0' : '14px' }} 0; color:#1a1a1a; font-size:18px; font-weight:bold; font-family:'Courier New', Courier, monospace; word-break:break-all;">
                                                    {{ $value }}
                                                </p>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            {{-- Bloc de contact (optionnel) : affiché seulement si $contactPhone est fourni --}}
                            @if (!empty($contactPhone))
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="margin: 20px 0;">
                                    <tr>
                                        <td
                                            style="background-color:#e8f5e9; border-left:4px solid #2e7d32; padding:16px 20px;">
                                            <p
                                                style="margin:0 0 6px 0; color:#2e7d32; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:0.5px;">
                                                {{ $contactLabel ?? 'Contact' }}
                                            </p>
                                            <a href="tel:{{ preg_replace('/[^\d+]/', '', $contactPhone) }}"
                                                style="color:#1a1a1a; font-size:20px; font-weight:bold; text-decoration:none;">
                                                Tél. : {{ $contactPhone }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            @if (isset($actionText) && isset($actionUrl))
                                <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
                                    <tr>
                                        <td style="border-radius:6px; background-color:#2e7d32;">
                                            <a href="{{ $actionUrl }}" target="_blank"
                                                style="display:inline-block; padding:12px 28px; color:#ffffff; text-decoration:none; font-weight:bold; border-radius:6px;">{{ $actionText }}</a>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            {{-- Lien de secours (optionnel) : utile si le bouton est bloqué par le client mail --}}
                            @if (!empty($showFallbackLink) && isset($actionUrl))
                                <p style="color:#666666; font-size:12px; line-height:1.5; word-break:break-all;">
                                    Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br>
                                    <a href="{{ $actionUrl }}" style="color:#2e7d32;">{{ $actionUrl }}</a>
                                </p>
                            @endif

                            <p style="color:#333333; font-size:15px;">
                                {{ $salutation ?? "Cordialement, l'équipe ENEF" }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color:#2e7d32; padding:20px; text-align:center; font-size:12px; color:#ffffff;">
                            {{ date('Y') }} ENEF. Tous droits réservés.<br>
                            École Nationale des Eaux et Forêts — Burkina Faso
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

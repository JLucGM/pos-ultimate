<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 30px;
        }
        .info-row {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #7c3aed;
            margin-bottom: 5px;
        }
        .value {
            color: #4b5563;
        }
        .message-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #7c3aed;
            margin-top: 10px;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 Nuevo Mensaje de Contacto</h1>
        </div>
        
        <div class="content">
            <p>Has recibido un nuevo mensaje desde el formulario de contacto de Kubre:</p>
            
            <div class="info-row">
                <div class="label">Nombre:</div>
                <div class="value">{{ $name }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Email:</div>
                <div class="value"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
            </div>
            
            @if($phone)
            <div class="info-row">
                <div class="label">Teléfono:</div>
                <div class="value">{{ $phone }}</div>
            </div>
            @endif
            
            @if($company)
            <div class="info-row">
                <div class="label">Empresa:</div>
                <div class="value">{{ $company }}</div>
            </div>
            @endif
            
            <div class="info-row">
                <div class="label">Mensaje:</div>
                <div class="message-box">
                    {{ $user_message }}
                </div>
            </div>
            
            <div class="info-row">
                <div class="label">Fecha:</div>
                <div class="value">{{ date('d/m/Y H:i:s') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Este mensaje fue enviado desde el formulario de contacto de <strong>Kubre</strong></p>
            <p>Para responder, simplemente responde a este email o contacta directamente a: {{ $email }}</p>
        </div>
    </div>
</body>
</html>

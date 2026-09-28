<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? 'es' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>403 - Acceso Denegado | {{ config('app.name', 'AudazPOS') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-dark: #070913;
            --surface-card: rgba(15, 23, 42, 0.75);
            --surface-border: rgba(255, 255, 255, 0.08);
            --primary: #FB4C0A;
            --primary-glow: rgba(251, 76, 10, 0.35);
            --danger: #EF4444;
            --text-main: #FFFFFF;
            --text-muted: #94A3B8;
            --text-dim: #64748B;
            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 14px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
            position: relative;
        }

        .bg-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(239, 68, 68, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 80% 80%, rgba(251, 76, 10, 0.15) 0%, transparent 50%),
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 50px 50px, 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        .error-header {
            position: relative;
            z-index: 10;
            padding: 24px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo img {
            max-height: 42px;
            width: auto;
        }

        .brand-fallback-name {
            font-size: 22px;
            font-weight: 800;
            color: #FFFFFF;
        }

        .brand-fallback-name span { color: var(--primary); }

        .system-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: #F87171;
            backdrop-filter: blur(12px);
        }

        .main-container {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 24px 40px;
            flex: 1;
        }

        .error-card {
            background: var(--surface-card);
            border: 1px solid var(--surface-border);
            backdrop-filter: blur(28px);
            border-radius: var(--radius-xl);
            padding: clamp(32px, 5vw, 56px);
            max-width: 680px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #EF4444, var(--primary), transparent);
        }

        .error-code-glitch {
            font-size: clamp(80px, 15vw, 120px);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #FFFFFF 30%, #EF4444 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 16px;
        }

        .error-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #F87171;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        .error-title {
            font-size: clamp(24px, 4vw, 32px);
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 12px;
        }

        .error-desc {
            font-size: clamp(15px, 2vw, 17px);
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 500px;
            margin: 0 auto 32px;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #FB4C0A, #E03E00);
            color: #FFFFFF;
            padding: 14px 28px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 25px var(--primary-glow);
            transition: all 0.25s ease;
        }

        .btn-secondary-custom {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: #FFFFFF;
            padding: 14px 24px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--surface-border);
            cursor: pointer;
        }

        .error-footer {
            position: relative;
            z-index: 10;
            padding: 20px 40px;
            text-align: center;
            color: var(--text-dim);
            font-size: 13px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }
    </style>
</head>
<body>
    <div class="bg-mesh"></div>

    <header class="error-header">
        <a href="{{ url('/') }}" class="brand-logo">
            @if(file_exists(public_path('img/logo_v2_full.png')))
                <img src="{{ asset('img/logo_v2_full.png') }}" alt="{{ config('app.name', 'AudazPOS') }}">
            @else
                <div class="brand-fallback-name">Audaz<span>POS</span></div>
            @endif
        </a>
        <div class="system-badge">
            <i class="fa-solid fa-lock"></i>
            <span>Error 403 &bull; Restricción de Seguridad</span>
        </div>
    </header>

    <main class="main-container">
        <div class="error-card">
            <div class="error-badge-pill">
                <i class="fa-solid fa-shield-halved"></i> Permisos Insuficientes
            </div>
            <div class="error-code-glitch">403</div>
            <h1 class="error-title">Acceso Denegado</h1>
            <p class="error-desc">
                No dispones de los permisos o roles requeridos por el administrador para visualizar este módulo o realizar esta acción.
            </p>
            <div class="action-buttons">
                <a href="{{ url('/home') }}" class="btn-primary-custom">
                    <i class="fa-solid fa-house"></i> Ir al Dashboard
                </a>
                <button type="button" onclick="window.history.back();" class="btn-secondary-custom">
                    <i class="fa-solid fa-arrow-left"></i> Volver Atrás
                </button>
            </div>
        </div>
    </main>

    <footer class="error-footer">
        &copy; {{ date('Y') }} {{ config('app.name', 'AudazPOS') }} &bull; Todos los derechos reservados.
    </footer>
</body>
</html>

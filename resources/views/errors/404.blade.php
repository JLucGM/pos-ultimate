<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? 'es' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>404 - Página No Encontrada | {{ config('app.name', 'AudazPOS') }}</title>
    <meta name="description" content="Página no encontrada - 404">
    
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
            --primary-hover: #E03E00;
            --accent-emerald: #10B981;
            --accent-indigo: #6366F1;
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

        /* Dynamic Mesh Background */
        .bg-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(251, 76, 10, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 80% 80%, rgba(99, 102, 241, 0.16) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.1) 0%, transparent 60%),
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 50px 50px, 50px 50px;
            pointer-events: none;
            z-index: 0;
        }

        /* Ambient Glowing Orbs */
        .glow-orb-1 {
            position: fixed;
            top: 10%;
            left: 5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(251, 76, 10, 0.25) 0%, transparent 70%);
            filter: blur(80px);
            border-radius: 50%;
            pointer-events: none;
            animation: floatSlow 12s ease-in-out infinite alternate;
            z-index: 0;
        }

        .glow-orb-2 {
            position: fixed;
            bottom: 10%;
            right: 5%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
            filter: blur(90px);
            border-radius: 50%;
            pointer-events: none;
            animation: floatSlow 15s ease-in-out infinite alternate-reverse;
            z-index: 0;
        }

        @keyframes floatSlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(40px, 30px) scale(1.1); }
        }

        /* Header Navigation */
        .error-header {
            position: relative;
            z-index: 10;
            padding: 24px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-logo img {
            max-height: 42px;
            width: auto;
            object-fit: contain;
        }

        .brand-fallback-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #FFFFFF;
        }

        .brand-fallback-name span {
            color: var(--primary);
        }

        .system-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--surface-border);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            backdrop-filter: blur(12px);
        }

        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #EF4444;
            box-shadow: 0 0 10px #EF4444;
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.3); }
        }

        /* Main Content Container */
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
            -webkit-backdrop-filter: blur(28px);
            border-radius: var(--radius-xl);
            padding: clamp(32px, 5vw, 56px);
            max-width: 720px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .error-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--accent-indigo), transparent);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* 404 Hero Visual */
        .error-code-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .error-code-glitch {
            font-size: clamp(80px, 15vw, 130px);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -4px;
            background: linear-gradient(135deg, #FFFFFF 30%, #FB4C0A 75%, #F97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(251, 76, 10, 0.25);
            position: relative;
            user-select: none;
        }

        .error-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(251, 76, 10, 0.12);
            border: 1px solid rgba(251, 76, 10, 0.3);
            color: #FB4C0A;
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
            letter-spacing: -0.5px;
        }

        .error-desc {
            font-size: clamp(15px, 2vw, 17px);
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 520px;
            margin: 0 auto 32px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }

        .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            border: none;
            cursor: pointer;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(251, 76, 10, 0.55);
            color: #FFFFFF;
        }

        .btn-secondary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.06);
            color: #FFFFFF;
            padding: 14px 24px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--surface-border);
            transition: all 0.25s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        .btn-secondary-custom:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: #FFFFFF;
        }

        /* Quick Links Grid */
        .quick-links-section {
            border-top: 1px solid var(--surface-border);
            padding-top: 28px;
            text-align: left;
        }

        .quick-links-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-dim);
            margin-bottom: 16px;
            text-align: center;
        }

        .quick-links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 10px;
        }

        .quick-link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 14px 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-md);
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .quick-link-item i {
            font-size: 18px;
            color: var(--primary);
            transition: transform 0.2s ease;
        }

        .quick-link-item:hover {
            background: rgba(251, 76, 10, 0.08);
            border-color: rgba(251, 76, 10, 0.3);
            color: #FFFFFF;
            transform: translateY(-2px);
        }

        .quick-link-item:hover i {
            transform: scale(1.15);
        }

        /* Footer */
        .error-footer {
            position: relative;
            z-index: 10;
            padding: 20px 40px;
            text-align: center;
            color: var(--text-dim);
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        @media (max-width: 640px) {
            .error-header {
                padding: 16px 20px;
            }
            .error-card {
                padding: 28px 20px;
            }
            .error-footer {
                padding: 16px 20px;
                flex-direction: column;
                justify-content: center;
            }
            .quick-links-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="bg-mesh"></div>
    <div class="glow-orb-1"></div>
    <div class="glow-orb-2"></div>

    <!-- Header -->
    <header class="error-header">
        <a href="{{ url('/') }}" class="brand-logo" title="{{ config('app.name', 'AudazPOS') }}">
            @if(file_exists(public_path('img/logo_v2_full.png')))
                <img src="{{ asset('img/logo_v2_full.png') }}" alt="{{ config('app.name', 'AudazPOS') }}">
            @elseif(file_exists(public_path('img/logo-audaz.png')))
                <img src="{{ asset('img/logo-audaz.png') }}" alt="{{ config('app.name', 'AudazPOS') }}">
            @else
                <div class="brand-fallback-name">Audaz<span>POS</span></div>
            @endif
        </a>

        <div class="system-badge">
            <span class="live-dot"></span>
            <span>Error 404 &bull; Recurso No Encontrado</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <div class="error-card">
            <div class="error-badge-pill">
                <i class="fa-solid fa-triangle-exclamation"></i> Enlace no disponible
            </div>

            <div class="error-code-wrapper">
                <div class="error-code-glitch">404</div>
            </div>

            <h1 class="error-title">¡Ups! Página No Encontrada</h1>
            
            <p class="error-desc">
                La dirección a la que intentas acceder no existe en el sistema, fue modificada o no tienes los privilegios necesarios para visualizarla.
            </p>

            <!-- Buttons -->
            <div class="action-buttons">
                <a href="{{ url('/home') }}" class="btn-primary-custom">
                    <i class="fa-solid fa-house"></i> Ir al Dashboard
                </a>
                <button type="button" onclick="window.history.back();" class="btn-secondary-custom">
                    <i class="fa-solid fa-arrow-left"></i> Página Anterior
                </button>
                <a href="{{ url('/pos/create') }}" class="btn-secondary-custom" title="Punto de Venta Directo">
                    <i class="fa-solid fa-cash-register"></i> Terminal POS
                </a>
            </div>

            <!-- Accesos Rápidos -->
            <div class="quick-links-section">
                <div class="quick-links-title">Accesos Rápidos del Sistema</div>
                <div class="quick-links-grid">
                    <a href="{{ url('/sells') }}" class="quick-link-item">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Ventas</span>
                    </a>
                    <a href="{{ url('/products') }}" class="quick-link-item">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <span>Productos</span>
                    </a>
                    <a href="{{ url('/contacts?type=customer') }}" class="quick-link-item">
                        <i class="fa-solid fa-users"></i>
                        <span>Clientes</span>
                    </a>
                    <a href="{{ url('/reports/profit-loss') }}" class="quick-link-item">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Reportes</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="error-footer">
        <div>
            &copy; {{ date('Y') }} {{ config('app.name', 'AudazPOS') }} &bull; Todos los derechos reservados.
        </div>
        <div class="footer-links">
            <a href="javascript:void(0)" onclick="location.reload();"><i class="fa-solid fa-rotate-right"></i> Recargar</a>
            <a href="{{ url('/login') }}"><i class="fa-solid fa-user-lock"></i> Iniciar Sesión</a>
        </div>
    </footer>
</body>
</html>

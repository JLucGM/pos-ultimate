<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? 'es' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Portal en Mantenimiento | {{ config('app.name', 'AudazPOS') }}</title>
    <meta name="description" content="Sistema en mantenimiento programado. Volveremos muy pronto.">
    
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
            --surface-card: rgba(15, 23, 42, 0.8);
            --surface-border: rgba(255, 255, 255, 0.08);
            --primary: #FB4C0A;
            --primary-glow: rgba(251, 76, 10, 0.4);
            --primary-hover: #E03E00;
            --accent-amber: #F59E0B;
            --accent-emerald: #10B981;
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

        /* Dynamic Grid & Mesh Ambient Background */
        .bg-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 20%, rgba(251, 76, 10, 0.22) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(245, 158, 11, 0.18) 0%, transparent 50%),
                radial-gradient(circle at 50% 40%, rgba(16, 185, 129, 0.1) 0%, transparent 60%),
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 48px 48px, 48px 48px;
            pointer-events: none;
            z-index: 0;
        }

        /* Ambient Glowing Spheres */
        .glow-orb-1 {
            position: fixed;
            top: -5%;
            left: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(251, 76, 10, 0.25) 0%, transparent 70%);
            filter: blur(90px);
            border-radius: 50%;
            pointer-events: none;
            animation: pulseGlow 8s ease-in-out infinite alternate;
            z-index: 0;
        }

        .glow-orb-2 {
            position: fixed;
            bottom: -5%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.2) 0%, transparent 70%);
            filter: blur(100px);
            border-radius: 50%;
            pointer-events: none;
            animation: pulseGlow 10s ease-in-out infinite alternate-reverse;
            z-index: 0;
        }

        @keyframes pulseGlow {
            0% { transform: scale(1) translate(0, 0); opacity: 0.7; }
            100% { transform: scale(1.15) translate(30px, 20px); opacity: 1; }
        }

        /* Header Navigation */
        .maintenance-header {
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
            max-height: 44px;
            width: auto;
            object-fit: contain;
        }

        .brand-fallback-name {
            font-size: 24px;
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
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.35);
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            color: #FBBF24;
            backdrop-filter: blur(12px);
        }

        .live-dot-amber {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #F59E0B;
            box-shadow: 0 0 10px #F59E0B;
            animation: pulseDotAmber 1.8s infinite;
        }

        @keyframes pulseDotAmber {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.4); }
        }

        /* Main Container */
        .main-container {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 24px 40px;
            flex: 1;
        }

        .maintenance-card {
            background: var(--surface-card);
            border: 1px solid var(--surface-border);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-radius: var(--radius-xl);
            padding: clamp(32px, 5vw, 56px);
            max-width: 780px;
            width: 100%;
            text-align: center;
            box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.05);
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .maintenance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), #F59E0B, transparent);
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

        /* Animated Gear / Portal Visual */
        .visual-icon-wrap {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-pulse-ring {
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 2px dashed rgba(251, 76, 10, 0.4);
            animation: rotateClockwise 20s linear infinite;
        }

        .icon-pulse-inner {
            position: absolute;
            inset: 6px;
            border-radius: 50%;
            border: 1px solid rgba(245, 158, 11, 0.3);
            animation: rotateCounter 15s linear infinite;
        }

        .icon-center-badge {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(251, 76, 10, 0.25), rgba(245, 158, 11, 0.15));
            border: 1px solid rgba(251, 76, 10, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            color: #FB4C0A;
            box-shadow: 0 0 35px var(--primary-glow);
        }

        @keyframes rotateClockwise {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes rotateCounter {
            from { transform: rotate(360deg); }
            to { transform: rotate(0deg); }
        }

        .maintenance-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(251, 76, 10, 0.12);
            border: 1px solid rgba(251, 76, 10, 0.3);
            color: #FB4C0A;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        .maintenance-title {
            font-size: clamp(26px, 4.5vw, 36px);
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 14px;
            letter-spacing: -0.6px;
        }

        .maintenance-subtitle {
            font-size: clamp(15px, 2vw, 17px);
            color: var(--text-muted);
            line-height: 1.6;
            max-width: 580px;
            margin: 0 auto 32px;
        }

        /* Status Grid Feature Cards */
        .status-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 14px;
            margin-bottom: 34px;
            text-align: left;
        }

        .status-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--surface-border);
            border-radius: var(--radius-md);
            padding: 18px;
            transition: all 0.25s ease;
        }

        .status-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(251, 76, 10, 0.3);
            transform: translateY(-2px);
        }

        .status-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .status-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(251, 76, 10, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 14px;
        }

        .status-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #FFFFFF;
        }

        .status-card-desc {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .btn-retry {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #FB4C0A, #E03E00);
            color: #FFFFFF;
            padding: 14px 30px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 25px var(--primary-glow);
            transition: all 0.25s ease;
            border: none;
            cursor: pointer;
        }

        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(251, 76, 10, 0.6);
            color: #FFFFFF;
        }

        .btn-support {
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

        .btn-support:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: #FFFFFF;
        }

        /* Auto Refresh Banner */
        .autorefresh-banner {
            font-size: 13px;
            color: var(--text-dim);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .autorefresh-counter {
            color: var(--primary);
            font-weight: 700;
        }

        /* Footer */
        .maintenance-footer {
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

        @media (max-width: 640px) {
            .maintenance-header {
                padding: 16px 20px;
            }
            .maintenance-card {
                padding: 28px 20px;
            }
            .maintenance-footer {
                padding: 16px 20px;
                flex-direction: column;
                justify-content: center;
            }
            .status-features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="bg-mesh"></div>
    <div class="glow-orb-1"></div>
    <div class="glow-orb-2"></div>

    <!-- Header -->
    <header class="maintenance-header">
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
            <span class="live-dot-amber"></span>
            <span>Mantenimiento en Progreso</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <div class="maintenance-card">
            <div class="maintenance-pill">
                <i class="fa-solid fa-screwdriver-wrench"></i> Mejoras en el Servidor
            </div>

            <!-- Animated High-Tech Gear / Radar -->
            <div class="visual-icon-wrap">
                <div class="icon-pulse-ring"></div>
                <div class="icon-pulse-inner"></div>
                <div class="icon-center-badge">
                    <i class="fa-solid fa-gears"></i>
                </div>
            </div>

            <h1 class="maintenance-title">Portal en Mantenimiento</h1>
            
            <p class="maintenance-subtitle">
                Estamos realizando optimizaciones programadas en nuestros servidores para ofrecerte mayor velocidad, estabilidad y seguridad en tu gestión diaria.
            </p>

            <!-- Cards de Estado / Procesos en Curso -->
            <div class="status-features-grid">
                <div class="status-card">
                    <div class="status-card-header">
                        <div class="status-card-icon"><i class="fa-solid fa-server"></i></div>
                        <div class="status-card-title">Optimización</div>
                    </div>
                    <div class="status-card-desc">Actualización y respaldo seguro de bases de datos.</div>
                </div>

                <div class="status-card">
                    <div class="status-card-header">
                        <div class="status-card-icon"><i class="fa-solid fa-shield-halved"></i></div>
                        <div class="status-card-title">Seguridad</div>
                    </div>
                    <div class="status-card-desc">Implementación de parches y estabilidad de red.</div>
                </div>

                <div class="status-card">
                    <div class="status-card-header">
                        <div class="status-card-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div class="status-card-title">Rendimiento</div>
                    </div>
                    <div class="status-card-desc">Mayor fluidez en POS, facturación y reportes.</div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="action-buttons">
                <button type="button" onclick="triggerRefresh(this)" class="btn-retry" id="btnRetry">
                    <i class="fa-solid fa-rotate-right" id="refreshIcon"></i> Reintentar Conexión
                </button>
                <a href="mailto:soporte@audazpos.com" class="btn-support">
                    <i class="fa-solid fa-envelope"></i> Soporte Técnico
                </a>
            </div>

            <!-- Auto-reintento con contador -->
            <div class="autorefresh-banner">
                <i class="fa-regular fa-clock"></i> Comprobación automática en <span class="autorefresh-counter" id="countdown">60</span>s
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="maintenance-footer">
        <div>
            &copy; {{ date('Y') }} {{ config('app.name', 'AudazPOS') }} &bull; Todos los derechos reservados.
        </div>
        <div>
            <span style="color: var(--primary);"><i class="fa-solid fa-circle-check"></i></span> Tus datos e inventario están 100% protegidos
        </div>
    </footer>

    <script>
        // Contador regresivo para reintento automático
        let timeLeft = 60;
        const countdownEl = document.getElementById('countdown');

        const interval = setInterval(() => {
            timeLeft--;
            if (countdownEl) countdownEl.innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(interval);
                location.reload();
            }
        }, 1000);

        function triggerRefresh(btn) {
            const icon = document.getElementById('refreshIcon');
            if (icon) {
                icon.classList.add('fa-spin');
            }
            btn.setAttribute('disabled', 'true');
            btn.style.opacity = '0.7';
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    </script>
</body>
</html>

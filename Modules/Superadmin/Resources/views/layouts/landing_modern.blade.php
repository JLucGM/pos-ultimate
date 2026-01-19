<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema POS') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    
    <style>
        :root {
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --primary-light: #8b5cf6;
            --dark: #1e0a3c;
            --dark-2: #2d1b4e;
            --dark-3: #4a2c7c;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: var(--gray-900);
            background: var(--white);
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .container-fluid {
            width: 100%;
            padding: 0 40px;
        }

        .container-full {
            width: 100%;
            padding: 0;
        }

        /* Navigation */
        .navbar-modern {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 20px 0;
            transition: all 0.3s ease;
            background: transparent;
        }

        .navbar-modern.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-modern {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-size: 24px;
            font-weight: 800;
            color: var(--dark);
        }

        .logo-modern img {
            height: 55px;
            width: auto;
            transition: all 0.3s ease;
            filter: brightness(0) invert(1);
        }

        .navbar-modern.scrolled .logo-modern img {
            height: 48px;
            filter: none;
        }

        .nav-menu-modern {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-link-modern {
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s;
        }

        .nav-link-modern:hover {
            color: var(--primary);
        }

        .navbar-modern.scrolled .nav-link-modern {
            color: var(--gray-700);
        }

        .navbar-modern .nav-link-modern {
            color: rgba(255, 255, 255, 0.9);
        }

        .navbar-modern.scrolled .nav-link-modern {
            color: var(--gray-700);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--gray-700);
            cursor: pointer;
        }

        .navbar-modern .mobile-menu-btn {
            color: var(--white);
        }

        .navbar-modern.scrolled .mobile-menu-btn {
            color: var(--gray-700);
        }

        /* Hero Section */
        .hero-modern {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 0 80px;
            overflow: hidden;
            background: linear-gradient(135deg, #1e0a3c 0%, #2d1b4e 50%, #4a2c7c 100%);
            width: 100%;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #7c3aed 0%, transparent 70%);
            top: -200px;
            left: -200px;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #8b5cf6 0%, transparent 70%);
            bottom: -150px;
            right: -150px;
            animation-delay: -10s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #a78bfa 0%, transparent 70%);
            top: 50%;
            left: 50%;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .hero-content-wrapper {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .hero-title-modern {
            font-size: 56px;
            font-weight: 900;
            line-height: 1.1;
            color: var(--white);
            margin-bottom: 24px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #a78bfa 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 18px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 32px;
        }

        .hero-cta-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 48px;
        }

        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            white-space: nowrap;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: var(--white);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);
        }

        .btn-outline-modern {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-outline-modern:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .hero-trust-badges {
            display: flex;
            gap: 32px;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 500;
        }

        .trust-item i {
            color: #a78bfa;
            font-size: 18px;
        }

        /* Dashboard Mockup */
        .dashboard-mockup {
            position: relative;
            max-width: 80%;
            margin: 0 auto;
        }

        .mockup-window {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .window-header {
            background: var(--gray-100);
            padding: 12px 16px;
            display: flex;
            gap: 8px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--gray-300);
        }

        .window-content {
            background: var(--gray-50);
        }

        .dashboard-img {
            width: 100%;
            height: auto;
            display: block;
        }

        .floating-stat {
            position: absolute;
            background: var(--white);
            padding: 16px 20px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 200px;
        }

        .stat-1 { top: 10%; right: -15%; }
        .stat-2 { bottom: 30%; left: -15%; }
        .stat-3 { bottom: 10%; right: 5%; }

        .stat-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 20px;
        }

        .bg-gradient-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .bg-gradient-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .bg-gradient-purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .bg-gradient-orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .bg-gradient-red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .bg-gradient-teal { background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); }

        .stat-info {
            display: flex;
            flex-direction: column;
            min-width: 100px;
        }

        .stat-label {
            font-size: 12px;
            color: var(--gray-500);
            font-weight: 500;
            white-space: nowrap;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
            white-space: nowrap;
        }

        /* Features Section */
        .features-modern {
            padding: 100px 0;
            background: var(--white);
            width: 100%;
        }

        .section-header-modern {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .section-badge-modern {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(124, 58, 237, 0.1);
            color: var(--primary);
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .section-title-modern {
            font-size: 42px;
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: 16px;
        }

        .section-subtitle-modern {
            font-size: 18px;
            color: var(--gray-600);
        }

        .features-grid-modern {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .feature-card-modern {
            padding: 32px;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 30px;
            transition: all 0.3s;
        }

        .feature-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .feature-icon-modern {
            width: 64px;
            height: 64px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 28px;
            margin-bottom: 20px;
        }

        .feature-card-modern h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 12px;
        }

        .feature-card-modern p {
            font-size: 15px;
            color: var(--gray-600);
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .feature-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: gap 0.2s;
        }

        .feature-link:hover {
            gap: 10px;
        }

        /* Stats Section */
        .stats-modern {
            padding: 80px 0;
            background: linear-gradient(135deg, #1e0a3c 0%, #2d1b4e 50%, #4a2c7c 100%);
            width: 100%;
        }

        .stats-grid-modern {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 48px;
        }

        .stat-item-modern {
            text-align: center;
        }

        .stat-number-modern {
            font-size: 48px;
            font-weight: 900;
            color: var(--white);
            margin-bottom: 8px;
        }

        .stat-label-modern {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Pricing Section */
        .pricing-modern {
            padding: 100px 0;
            background: var(--gray-50);
            width: 100%;
        }

        .pricing-grid-modern {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .pricing-card-modern {
            background: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 20px;
            padding: 40px;
            transition: all 0.3s;
            position: relative;
        }

        .pricing-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .featured-modern {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(124, 58, 237, 0.2);
        }

        .popular-badge-modern {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: var(--white);
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .pricing-header-modern {
            text-align: center;
            margin-bottom: 32px;
        }

        .pricing-header-modern h3 {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 16px;
        }

        .price-modern {
            display: flex;
            align-items: baseline;
            justify-content: center;
            margin-bottom: 8px;
        }

        .price-modern .currency {
            font-size: 24px;
            font-weight: 700;
            color: var(--gray-600);
        }

        .price-modern .amount {
            font-size: 56px;
            font-weight: 900;
            color: var(--gray-900);
        }

        .price-modern .period {
            font-size: 18px;
            color: var(--gray-500);
        }

        .pricing-description {
            color: var(--gray-600);
            font-size: 14px;
        }

        .pricing-features-modern {
            list-style: none;
            margin-bottom: 32px;
        }

        .pricing-features-modern li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            color: var(--gray-700);
            font-size: 15px;
        }

        .pricing-features-modern i {
            color: var(--primary);
            font-size: 18px;
        }

        .w-full {
            width: 100%;
            justify-content: center;
        }

        /* CTA Section */
        .cta-modern {
            padding: 100px 0;
            background: linear-gradient(135deg, #1e0a3c 0%, #2d1b4e 50%, #4a2c7c 100%);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .cta-content-modern {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .cta-content-modern h2 {
            font-size: 48px;
            font-weight: 900;
            color: var(--white);
            margin-bottom: 16px;
        }

        .cta-content-modern p {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
        }

        .cta-buttons-modern {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .btn-white-modern {
            background: var(--white);
            color: var(--primary);
        }

        .btn-white-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }

        .btn-outline-white-modern {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-outline-white-modern:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .btn-lg {
            padding: 16px 32px;
            font-size: 18px;
        }

        /* Footer */
        .footer-modern {
            background: var(--gray-900);
            color: var(--gray-400);
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }

        .footer-section h4 {
            color: var(--white);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 12px;
        }

        .footer-section a {
            color: var(--gray-400);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-section a:hover {
            color: var(--white);
        }

        .footer-bottom {
            border-top: 1px solid var(--gray-800);
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
        }

        /* WhatsApp Float */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            z-index: 999;
            transition: all 0.3s;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-content-wrapper {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .hero-visual-content {
                order: -1;
            }

            .dashboard-mockup {
                max-width: 90%;
            }

            .features-grid-modern {
                grid-template-columns: repeat(2, 1fr);
            }

            .pricing-grid-modern {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }

            .stats-grid-modern {
                grid-template-columns: repeat(2, 1fr);
            }

            .container-fluid {
                padding: 0 24px;
            }
        }

        @media (max-width: 768px) {
            .nav-menu-modern {
                display: none;
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: var(--white);
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                gap: 16px;
            }

            .nav-menu-modern.active {
                display: flex;
            }

            .navbar-modern .nav-menu-modern {
                background: var(--dark);
            }

            .navbar-modern.scrolled .nav-menu-modern {
                background: var(--white);
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero-title-modern {
                font-size: 36px;
            }

            .dashboard-mockup {
                max-width: 100%;
            }

            .section-title-modern {
                font-size: 32px;
            }

            .features-grid-modern {
                grid-template-columns: 1fr;
            }

            .pricing-card-modern {
                padding: 30px 20px;
                margin-bottom: 20px;
            }

            .pricing-grid-modern {
                padding: 0;
                gap: 20px;
            }

            .btn-modern {
                font-size: 15px;
                padding: 12px 24px;
            }

            .w-full {
                display: inline-flex;
                width: 100%;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }

            .cta-content-modern h2 {
                font-size: 32px;
            }

            .cta-buttons-modern {
                flex-direction: column;
            }

            .floating-stat {
                display: none;
            }

            .container-fluid {
                padding: 0 20px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar-modern" id="navbar">
        <div class="container-fluid">
            <div class="nav-container">
                <a href="/" class="logo-modern">
                    <img src="{{ asset('img/logo-audaz.png') }}" alt="{{ config('app.name') }}">
                </a>
                
                <div class="nav-menu-modern" id="navMenu">
                    <a href="/#features" class="nav-link-modern">Características</a>
                    <a href="/#pricing" class="nav-link-modern">Precios</a>
                    <a href="/#stats" class="nav-link-modern">Estadísticas</a>
                    @guest
                        <a href="{{ route('login') }}" class="nav-link-modern">Iniciar Sesión</a>
                        <a href="{{ route('business.getRegister') }}" class="btn-modern btn-primary-modern">
                            Registrarse
                        </a>
                    @else
                        <a href="{{ url('/home') }}" class="btn-modern btn-primary-modern">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @endguest
                </div>
                
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-modern">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>{{ config('app.name') }}</h4>
                    <p>Sistema POS completo para pequeñas y medianas empresas. Gestiona tu negocio desde cualquier lugar.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Producto</h4>
                    <ul>
                        <li><a href="{{ route('pricing') }}">Precios</a></li>
                        <li><a href="#">Características</a></li>
                        <li><a href="#">Integraciones</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Soporte</h4>
                    <ul>
                        <li><a href="#">Centro de Ayuda</a></li>
                        <li><a href="#">Documentación</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Términos</a></li>
                        <li><a href="#">Privacidad</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/584242909870?text=Hola!%20Estoy%20interesado%20en%20el%20sistema%20POS" 
       class="whatsapp-float" 
       target="_blank"
       rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });
        }

        // Smooth scroll para links internos
        document.addEventListener('DOMContentLoaded', function() {
            var internalLinks = document.querySelectorAll('a[href^="#"], a[href^="/#"]');
            
            internalLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var href = this.getAttribute('href');
                    
                    // Extraer el hash
                    var hash = href.includes('#') ? href.split('#')[1] : '';
                    
                    // Ignorar # vacío
                    if (!hash || hash === '!') {
                        return;
                    }
                    
                    var target = document.getElementById(hash);
                    if (target) {
                        e.preventDefault();
                        var offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 80;
                        
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                        
                        // Cerrar menú móvil si está abierto
                        if (navMenu && navMenu.classList.contains('active')) {
                            navMenu.classList.remove('active');
                            if (mobileMenuBtn) {
                                mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                                mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                            }
                        }
                    }
                });
            });
        });
    </script>
    
    @yield('javascript')
</body>
</html>

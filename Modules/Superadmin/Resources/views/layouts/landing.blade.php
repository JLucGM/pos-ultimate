<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema POS para Pequeñas Empresas')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v={{ time() }}">
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container nav-container">
            <a href="/" class="logo logo-only">
                <img src="{{ asset('img/logo-audaz.png') }}" alt="{{ config('app.name', 'POS System') }}" class="logo-img">
            </a>
            
            <div class="nav-menu" id="navMenu">
                <a href="{{ url('/#features') }}" class="nav-link">Características</a>
                <a href="{{ route('pricing') }}" class="nav-link">Precios</a>
                <a href="{{ url('/#testimonials') }}" class="nav-link">Testimonios</a>
                <a href="{{ url('/#faq') }}" class="nav-link">FAQ</a>
                
                @guest
                    <a href="{{ route('login') }}" class="nav-link">Iniciar Sesión</a>
                    <a href="{{ route('business.getRegister') }}" class="btn btn-accent btn-sm">Registrarse</a>
                @else
                    <a href="{{ url('/home') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @endguest
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="{{ asset('img/logo-audaz.png') }}" alt="{{ config('app.name', 'POS System') }}" class="logo-img">
                    </div>
                    <p>Sistema POS completo para pequeñas y medianas empresas. Gestiona tu negocio desde cualquier lugar.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Producto</h4>
                    <ul>
                        <li><a href="#features">Características</a></li>
                        <li><a href="{{ route('pricing') }}">Precios</a></li>
                        <li><a href="#">Integraciones</a></li>
                        <li><a href="#">Actualizaciones</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Empresa</h4>
                    <ul>
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Carreras</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Soporte</h4>
                    <ul>
                        <li><a href="#">Centro de Ayuda</a></li>
                        <li><a href="#">Documentación</a></li>
                        <li><a href="#">Tutoriales</a></li>
                        <li><a href="#">Estado del Sistema</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Términos de Producto</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                        <li><a href="#">Política de Cookies</a></li>
                        <li><a href="#">GDPR</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
                <div class="footer-links">
                    <a href="#">Términos</a>
                    <a href="#">Privacidad</a>
                    <a href="#">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Flotante -->
    <a href="https://wa.me/584242909870?text=Hola!%20Estoy%20interesado%20en%20el%20sistema%20POS" 
       class="whatsapp-float" 
       target="_blank"
       rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-text">¿Necesitas ayuda?</span>
    </a>

    <!-- Modal de Pago -->
    <div id="paymentModal" class="payment-modal">
        <div class="payment-modal-content">
            <span class="payment-modal-close">&times;</span>
            <h2 class="payment-modal-title">Completar Pago</h2>
            
            <div class="payment-package-info">
                <h3 id="modalPackageName"></h3>
                <div class="payment-price">
                    <span id="modalPackagePrice"></span>
                </div>
            </div>

            <form id="paymentForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="packageId" name="package_id">
                
                <div class="form-group">
                    <label>Nombre del Negocio *</label>
                    <input type="text" name="business_name" required class="form-control">
                </div>

                <div class="form-group">
                    <label>Nombre de Contacto *</label>
                    <input type="text" name="contact_name" required class="form-control">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="tel" name="phone" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Método de Pago *</label>
                    <select name="payment_method" id="paymentMethod" required class="form-control">
                        <option value="">Selecciona un método</option>
                        <option value="transferencia">Transferencia Bancaria</option>
                        <option value="binance">Binance Pay</option>
                        <option value="paypal">PayPal</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div id="paymentInfo" class="payment-info-box" style="display: none;">
                    <div class="payment-info-content"></div>
                </div>

                <div class="form-group">
                    <label>Número de Referencia / ID de Transacción *</label>
                    <input type="text" name="reference_number" required class="form-control" placeholder="Ej: TRX123456789">
                </div>

                <div class="form-group">
                    <label>Comprobante de Pago (Imagen)</label>
                    <input type="file" name="payment_proof" accept="image/*" class="form-control">
                    <small>Formatos: JPG, PNG. Máximo 5MB</small>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closePaymentModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Enviar Solicitud
                    </button>
                </div>
            </form>

            <div id="paymentSuccess" style="display: none;" class="payment-success">
                <i class="fas fa-check-circle"></i>
                <h3>¡Solicitud Enviada!</h3>
                <p>Hemos recibido tu solicitud de pago. Te contactaremos pronto para confirmar tu suscripción.</p>
                <button class="btn btn-primary" onclick="closePaymentModal()">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/landing.js') }}"></script>
    
    @yield('javascript')
    
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
        
        mobileMenuBtn.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = navMenu.contains(event.target) || mobileMenuBtn.contains(event.target);
            if (!isClickInside && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                mobileMenuBtn.querySelector('i').classList.remove('fa-times');
            }
        });

        // Smooth scroll para links internos
        document.addEventListener('DOMContentLoaded', function() {
            var internalLinks = document.querySelectorAll('a[href^="#"]');
            
            internalLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var href = this.getAttribute('href');
                    
                    // Ignorar # vacío
                    if (href === '#' || href === '#!') {
                        e.preventDefault();
                        return;
                    }
                    
                    var target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        var offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 80;
                        
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                        
                        // Cerrar menú móvil si está abierto
                        if (navMenu.classList.contains('active')) {
                            navMenu.classList.remove('active');
                            mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                            mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                        }
                    } else {
                        // Si la sección no existe, redirigir a la página principal con el hash
                        if (window.location.pathname !== '/') {
                            window.location.href = '/' + href;
                        }
                    }
                });
            });
            
            // Si llegamos con un hash en la URL, hacer scroll a esa sección
            if (window.location.hash) {
                setTimeout(function() {
                    var target = document.querySelector(window.location.hash);
                    if (target) {
                        var offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }
        });

        // Payment Modal Functions
        window.openPaymentModal = function(packageId, packageName, packagePrice) {
            document.getElementById('packageId').value = packageId;
            document.getElementById('modalPackageName').textContent = packageName;
            document.getElementById('modalPackagePrice').textContent = packagePrice;
            document.getElementById('paymentModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        // WhatsApp Float - Mostrar tooltip después de 3 segundos
        setTimeout(function() {
            var whatsappBtn = document.querySelector('.whatsapp-float');
            if (whatsappBtn && !sessionStorage.getItem('whatsapp_tooltip_shown')) {
                whatsappBtn.style.animation = 'bounce 1s ease 3';
                sessionStorage.setItem('whatsapp_tooltip_shown', 'true');
            }
        }, 3000);
        
        // Animación de rebote
        var style = document.createElement('style');
        style.textContent = `
            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
        `;
        document.head.appendChild(style);

        window.closePaymentModal = function() {
            document.getElementById('paymentModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('paymentForm').reset();
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentForm').style.display = 'block';
        };

        // Close modal on click outside
        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentModal();
            }
        });

        // Close button
        document.querySelector('.payment-modal-close').addEventListener('click', closePaymentModal);

        // Payment method change
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const method = this.value;
            const infoBox = document.getElementById('paymentInfo');
            const infoContent = infoBox.querySelector('.payment-info-content');
            
            if (method) {
                fetch('/payment-info/' + document.getElementById('packageId').value)
                    .then(response => response.json())
                    .then(data => {
                        if (data.payment_methods[method]) {
                            infoContent.innerHTML = '<strong>' + data.payment_methods[method].name + '</strong><br>' + data.payment_methods[method].info;
                            infoBox.style.display = 'block';
                        }
                    });
            } else {
                infoBox.style.display = 'none';
            }
        });

        // Form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
            
            fetch('/payment-request', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('paymentForm').style.display = 'none';
                    document.getElementById('paymentSuccess').style.display = 'block';
                } else {
                    alert('Error: ' + (data.message || 'Ocurrió un error'));
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Solicitud';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al enviar la solicitud');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Solicitud';
            });
        });
    </script>
</body>
</html>

# 🎁 Funcionalidades Extra para tu Landing Page

## 📧 1. Newsletter / Suscripción por Email

### Agregar formulario de newsletter

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Agrega antes del footer:

```blade
<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-box" data-aos="zoom-in">
            <div class="newsletter-content">
                <i class="fas fa-envelope-open-text"></i>
                <h3>Mantente Informado</h3>
                <p>Recibe tips, actualizaciones y ofertas exclusivas</p>
            </div>
            <form id="newsletterForm" class="newsletter-form">
                @csrf
                <input type="email" name="email" placeholder="tu@email.com" required>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Suscribirse
                </button>
            </form>
        </div>
    </div>
</section>
```

**Archivo:** `public/css/landing.css`

```css
.newsletter-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.newsletter-box {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 60px;
    text-align: center;
    color: white;
}

.newsletter-content i {
    font-size: 48px;
    margin-bottom: 20px;
}

.newsletter-content h3 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 12px;
}

.newsletter-form {
    display: flex;
    gap: 12px;
    max-width: 500px;
    margin: 30px auto 0;
}

.newsletter-form input {
    flex: 1;
    padding: 16px 24px;
    border-radius: 12px;
    border: none;
    font-size: 16px;
}

.newsletter-form button {
    white-space: nowrap;
}

@media (max-width: 768px) {
    .newsletter-form {
        flex-direction: column;
    }
}
```

**Archivo:** `public/js/landing.js`

```javascript
// Newsletter form submission
document.getElementById('newsletterForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = this.querySelector('input[name="email"]').value;
    const button = this.querySelector('button');
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    
    try {
        const response = await fetch('/api/newsletter/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email })
        });
        
        if (response.ok) {
            showNotification('¡Gracias por suscribirte!', 'success');
            this.reset();
        } else {
            showNotification('Error al suscribirse. Intenta de nuevo.', 'error');
        }
    } catch (error) {
        showNotification('Error de conexión', 'error');
    } finally {
        button.disabled = false;
        button.innerHTML = originalText;
    }
});
```

## 🎥 2. Modal de Video Demo

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Agrega al final, antes de `@endsection`:

```blade
<!-- Video Modal -->
<div id="videoModal" class="video-modal">
    <div class="video-modal-content">
        <span class="video-modal-close">&times;</span>
        <div class="video-wrapper">
            <iframe id="demoVideo" width="100%" height="500" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>
```

Cambia el botón "Ver Demo" en el hero:

```blade
<a href="#" class="btn btn-outline btn-lg" data-video="https://www.youtube.com/embed/TU_VIDEO_ID">
    <i class="fas fa-play-circle"></i> Ver Demo
</a>
```

**Archivo:** `public/css/landing.css`

```css
.video-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    animation: fadeIn 0.3s;
}

.video-modal-content {
    position: relative;
    margin: 5% auto;
    width: 90%;
    max-width: 900px;
}

.video-modal-close {
    position: absolute;
    top: -40px;
    right: 0;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.video-modal-close:hover {
    color: #f59e0b;
}

.video-wrapper {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    border-radius: 12px;
}

.video-wrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
```

**Archivo:** `public/js/landing.js`

```javascript
// Video modal functionality
document.querySelectorAll('[data-video]').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const videoUrl = this.getAttribute('data-video');
        const modal = document.getElementById('videoModal');
        const iframe = document.getElementById('demoVideo');
        
        iframe.src = videoUrl + '?autoplay=1';
        modal.style.display = 'block';
    });
});

document.querySelector('.video-modal-close')?.addEventListener('click', function() {
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('demoVideo');
    
    modal.style.display = 'none';
    iframe.src = '';
});

window.addEventListener('click', function(e) {
    const modal = document.getElementById('videoModal');
    if (e.target === modal) {
        modal.style.display = 'none';
        document.getElementById('demoVideo').src = '';
    }
});
```

## 💬 3. Formulario de Contacto Completo

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Agrega nueva sección:

```blade
<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Contacto</span>
            <h2 class="section-title">¿Tienes Preguntas? Contáctanos</h2>
            <p class="section-subtitle">Estamos aquí para ayudarte</p>
        </div>
        
        <div class="contact-grid">
            <div class="contact-info" data-aos="fade-right">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4>Email</h4>
                        <p>{{ config('landing.contact.email') }}</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h4>Teléfono</h4>
                        <p>{{ config('landing.contact.phone') }}</p>
                    </div>
                </div>
                
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4>Dirección</h4>
                        <p>{{ config('landing.contact.address') }}</p>
                    </div>
                </div>
                
                @if(config('landing.contact.whatsapp'))
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <h4>WhatsApp</h4>
                        <a href="https://wa.me/{{ config('landing.contact.whatsapp') }}" target="_blank">
                            Enviar mensaje
                        </a>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="contact-form-wrapper" data-aos="fade-left">
                <form id="contactForm" class="contact-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre *</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="tel" name="phone">
                        </div>
                        <div class="form-group">
                            <label>Empresa</label>
                            <input type="text" name="company">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Mensaje *</label>
                        <textarea name="message" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        <i class="fas fa-paper-plane"></i> Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
```

**Archivo:** `public/css/landing.css`

```css
.contact-section {
    padding: 100px 0;
    background: #f8fafc;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 60px;
    margin-top: 60px;
}

.contact-item {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    flex-shrink: 0;
}

.contact-item h4 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--dark);
}

.contact-item p,
.contact-item a {
    color: var(--gray);
    text-decoration: none;
}

.contact-item a:hover {
    color: var(--primary);
}

.contact-form-wrapper {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--dark);
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
```

**Archivo:** `public/js/landing.js`

```javascript
// Contact form submission
document.getElementById('contactForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    
    try {
        const response = await fetch('/contact', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(data.message, 'success');
            this.reset();
        } else {
            showNotification('Error al enviar el mensaje', 'error');
        }
    } catch (error) {
        showNotification('Error de conexión', 'error');
    } finally {
        button.disabled = false;
        button.innerHTML = originalText;
    }
});
```

## 🎯 4. Botón Flotante de WhatsApp

**Archivo:** `Modules/Superadmin/Resources/views/layouts/landing.blade.php`

Antes de `</body>`:

```blade
@if(config('landing.contact.whatsapp'))
<!-- WhatsApp Float Button -->
<a href="https://wa.me/{{ config('landing.contact.whatsapp') }}?text=Hola,%20me%20interesa%20el%20sistema%20POS" 
   class="whatsapp-float" 
   target="_blank"
   title="Chatea con nosotros">
    <i class="fab fa-whatsapp"></i>
</a>
@endif
```

**Archivo:** `public/css/landing.css`

```css
.whatsapp-float {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: #25D366;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
    z-index: 999;
    transition: all 0.3s;
    animation: pulse 2s infinite;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6);
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
    }
    50% {
        box-shadow: 0 4px 30px rgba(37, 211, 102, 0.8);
    }
}

@media (max-width: 768px) {
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 28px;
    }
}
```

## 🎨 5. Comparador de Planes Interactivo

**Archivo:** `Modules/Superadmin/Resources/views/pricing/modern.blade.php`

Agrega después de la tabla de comparación:

```blade
<!-- Interactive Plan Selector -->
<section class="plan-selector-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Encuentra tu Plan Ideal</h2>
            <p class="section-subtitle">Responde estas preguntas para recomendarte el mejor plan</p>
        </div>
        
        <div class="plan-quiz" data-aos="fade-up" data-aos-delay="100">
            <div class="quiz-question active" data-question="1">
                <h3>¿Cuántas sucursales tienes?</h3>
                <div class="quiz-options">
                    <button class="quiz-option" data-value="1">1 sucursal</button>
                    <button class="quiz-option" data-value="2-3">2-3 sucursales</button>
                    <button class="quiz-option" data-value="4+">4 o más</button>
                </div>
            </div>
            
            <div class="quiz-question" data-question="2">
                <h3>¿Cuántos empleados usarán el sistema?</h3>
                <div class="quiz-options">
                    <button class="quiz-option" data-value="1-3">1-3 personas</button>
                    <button class="quiz-option" data-value="4-10">4-10 personas</button>
                    <button class="quiz-option" data-value="10+">Más de 10</button>
                </div>
            </div>
            
            <div class="quiz-question" data-question="3">
                <h3>¿Qué tipo de negocio tienes?</h3>
                <div class="quiz-options">
                    <button class="quiz-option" data-value="retail">Tienda/Retail</button>
                    <button class="quiz-option" data-value="restaurant">Restaurante</button>
                    <button class="quiz-option" data-value="service">Servicios</button>
                </div>
            </div>
            
            <div class="quiz-result" style="display: none;">
                <div class="result-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Te recomendamos el plan:</h3>
                <div class="recommended-plan"></div>
                <button class="btn btn-primary btn-lg" onclick="location.reload()">
                    Volver a empezar
                </button>
            </div>
        </div>
    </div>
</section>
```

**Archivo:** `public/css/landing.css`

```css
.plan-selector-section {
    padding: 80px 0;
    background: white;
}

.plan-quiz {
    max-width: 600px;
    margin: 0 auto;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.quiz-question {
    display: none;
    text-align: center;
}

.quiz-question.active {
    display: block;
    animation: fadeIn 0.5s;
}

.quiz-question h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 30px;
    color: var(--dark);
}

.quiz-options {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.quiz-option {
    padding: 20px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.quiz-option:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

.quiz-result {
    text-align: center;
}

.result-icon {
    font-size: 64px;
    color: var(--secondary);
    margin-bottom: 20px;
}

.quiz-result h3 {
    font-size: 24px;
    margin-bottom: 30px;
}

.recommended-plan {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 12px;
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 30px;
}
```

**Archivo:** `public/js/landing.js`

```javascript
// Plan quiz functionality
let quizAnswers = {};
let currentQuestion = 1;

document.querySelectorAll('.quiz-option').forEach(option => {
    option.addEventListener('click', function() {
        const question = this.closest('.quiz-question');
        const questionNum = question.getAttribute('data-question');
        const value = this.getAttribute('data-value');
        
        quizAnswers[questionNum] = value;
        
        question.classList.remove('active');
        
        const nextQuestion = document.querySelector(`[data-question="${parseInt(questionNum) + 1}"]`);
        
        if (nextQuestion) {
            nextQuestion.classList.add('active');
        } else {
            showQuizResult();
        }
    });
});

function showQuizResult() {
    const result = document.querySelector('.quiz-result');
    const recommendedPlan = document.querySelector('.recommended-plan');
    
    // Lógica simple de recomendación
    let plan = 'Básico';
    
    if (quizAnswers['1'] === '4+' || quizAnswers['2'] === '10+') {
        plan = 'Empresarial';
    } else if (quizAnswers['1'] === '2-3' || quizAnswers['2'] === '4-10' || quizAnswers['3'] === 'restaurant') {
        plan = 'Profesional';
    }
    
    recommendedPlan.textContent = `Plan ${plan}`;
    result.style.display = 'block';
}
```

## 🏆 6. Badges de Confianza

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Agrega después del hero:

```blade
<!-- Trust Badges -->
<section class="trust-badges">
    <div class="container">
        <div class="badges-grid">
            <div class="badge-item" data-aos="fade-up" data-aos-delay="0">
                <i class="fas fa-shield-alt"></i>
                <span>Datos Seguros</span>
            </div>
            <div class="badge-item" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-lock"></i>
                <span>SSL Encriptado</span>
            </div>
            <div class="badge-item" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-headset"></i>
                <span>Soporte 24/7</span>
            </div>
            <div class="badge-item" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-sync-alt"></i>
                <span>Backups Diarios</span>
            </div>
            <div class="badge-item" data-aos="fade-up" data-aos-delay="400">
                <i class="fas fa-award"></i>
                <span>Garantía 30 días</span>
            </div>
        </div>
    </div>
</section>
```

**Archivo:** `public/css/landing.css`

```css
.trust-badges {
    padding: 60px 0;
    background: white;
    border-bottom: 1px solid #e2e8f0;
}

.badges-grid {
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
}

.badge-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--gray);
    font-weight: 600;
}

.badge-item i {
    font-size: 24px;
    color: var(--primary);
}

@media (max-width: 768px) {
    .badges-grid {
        flex-direction: column;
    }
}
```

## 📊 7. Contador de Visitantes en Tiempo Real

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Agrega en el hero o donde prefieras:

```blade
<div class="live-visitors">
    <span class="pulse-dot"></span>
    <span id="visitorCount">127</span> personas viendo esto ahora
</div>
```

**Archivo:** `public/css/landing.css`

```css
.live-visitors {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
}

.pulse-dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
    }
}
```

**Archivo:** `public/js/landing.js`

```javascript
// Simular contador de visitantes
function updateVisitorCount() {
    const counter = document.getElementById('visitorCount');
    if (counter) {
        const min = 80;
        const max = 200;
        const count = Math.floor(Math.random() * (max - min + 1)) + min;
        counter.textContent = count;
    }
}

// Actualizar cada 10 segundos
setInterval(updateVisitorCount, 10000);
```

---

## 🚀 Implementación

Para agregar cualquiera de estas funcionalidades:

1. Copia el código correspondiente
2. Pega en los archivos indicados
3. Limpia la caché: `php artisan cache:clear`
4. Recarga la página

¡Disfruta de tu landing page mejorada! 🎉

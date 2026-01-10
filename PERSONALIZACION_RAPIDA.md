# 🎨 Guía de Personalización Rápida

## ⚡ Cambios Rápidos (5 minutos)

### 1. Cambiar Título Principal

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

```blade
<!-- Busca la línea 11 y cambia: -->
<h1 class="hero-title" data-aos="fade-up">
    Gestiona tu Negocio con el <span class="text-gradient">Tu Nombre Aquí</span>
</h1>
```

### 2. Cambiar Colores del Sitio

**Archivo:** `public/css/landing.css`

```css
/* Busca las líneas 2-10 y cambia: */
:root {
    --primary: #6366f1;        /* Tu color principal */
    --secondary: #10b981;      /* Tu color secundario */
    --accent: #f59e0b;         /* Color de acento */
}
```

**Colores sugeridos:**
- Azul profesional: `#2563eb`
- Verde moderno: `#059669`
- Morado elegante: `#7c3aed`
- Naranja vibrante: `#ea580c`

### 3. Actualizar Información de Contacto

**Archivo:** `.env`

```bash
CONTACT_EMAIL=tuempresa@ejemplo.com
CONTACT_PHONE="+52 55 1234 5678"
CONTACT_ADDRESS="Av. Principal 123, Ciudad"
WHATSAPP_NUMBER=5215512345678
```

### 4. Agregar Redes Sociales

**Archivo:** `.env`

```bash
FACEBOOK_URL=https://facebook.com/tuempresa
TWITTER_URL=https://twitter.com/tuempresa
INSTAGRAM_URL=https://instagram.com/tuempresa
LINKEDIN_URL=https://linkedin.com/company/tuempresa
```

### 5. Cambiar Estadísticas del Hero

**Archivo:** `config/landing.php`

```php
'stats' => [
    [
        'number' => '1000+',      // Tu número
        'label' => 'Clientes Felices',  // Tu texto
    ],
    [
        'number' => '100K+',
        'label' => 'Ventas Procesadas',
    ],
    [
        'number' => '24/7',
        'label' => 'Soporte',
    ],
],
```

## 🎯 Personalización Intermedia (15 minutos)

### 6. Personalizar Características

**Archivo:** `config/landing.php`

```php
'features' => [
    [
        'icon' => 'fas fa-rocket',           // Icono de Font Awesome
        'color' => 'blue',                   // blue, green, purple, orange, red, teal
        'title' => 'Tu Característica',
        'description' => 'Descripción de tu característica única.',
    ],
    // Agrega más características...
],
```

**Iconos populares de Font Awesome:**
- `fas fa-rocket` - Cohete
- `fas fa-shield-alt` - Escudo
- `fas fa-bolt` - Rayo
- `fas fa-heart` - Corazón
- `fas fa-star` - Estrella
- `fas fa-check-circle` - Check
- Ver más en: https://fontawesome.com/icons

### 7. Modificar Testimonios

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Busca la sección de testimonios (línea ~200) y modifica:

```blade
<div class="testimonial-card" data-aos="fade-up">
    <div class="stars">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
    </div>
    <p>"Tu testimonio real de un cliente satisfecho aquí."</p>
    <div class="testimonial-author">
        <img src="{{ asset('images/landing/tu-avatar.jpg') }}" alt="Nombre">
        <div>
            <strong>Nombre del Cliente</strong>
            <span>Cargo, Empresa</span>
        </div>
    </div>
</div>
```

### 8. Actualizar Preguntas Frecuentes

**Archivo:** `config/landing.php`

```php
'faq' => [
    [
        'question' => '¿Tu pregunta aquí?',
        'answer' => 'Tu respuesta detallada aquí.',
    ],
    // Agrega más preguntas...
],
```

### 9. Personalizar Call to Action

**Archivo:** `config/landing.php`

```php
'cta' => [
    'title' => '¿Listo para Comenzar?',
    'subtitle' => 'Únete a miles de empresas exitosas',
    'primary_button' => 'Prueba Gratis 14 Días',
    'secondary_button' => 'Ver Demo',
],
```

## 🚀 Personalización Avanzada (30 minutos)

### 10. Agregar Nueva Sección

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Agrega antes del footer:

```blade
<!-- Nueva Sección -->
<section class="mi-seccion-personalizada">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Mi Sección</span>
            <h2 class="section-title">Título de Mi Sección</h2>
            <p class="section-subtitle">Subtítulo descriptivo</p>
        </div>
        
        <div class="contenido" data-aos="fade-up" data-aos-delay="100">
            <!-- Tu contenido aquí -->
        </div>
    </div>
</section>
```

**Archivo:** `public/css/landing.css`

Agrega al final:

```css
.mi-seccion-personalizada {
    padding: 100px 0;
    background: #f8fafc;
}

.mi-seccion-personalizada .contenido {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}
```

### 11. Cambiar Fuente Tipográfica

**Archivo:** `Modules/Superadmin/Resources/views/layouts/landing.blade.php`

Busca la línea 10 y cambia:

```html
<!-- Fuente actual: Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Opciones populares: -->

<!-- Poppins (moderna y limpia) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Montserrat (profesional) -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Roboto (clásica) -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
```

Luego en `public/css/landing.css`:

```css
body {
    font-family: 'Poppins', sans-serif;  /* Cambia 'Inter' por tu fuente */
}
```

### 12. Agregar Video de Presentación

**Archivo:** `Modules/Superadmin/Resources/views/landing/index.blade.php`

Reemplaza la imagen del hero con un video:

```blade
<div class="hero-image" data-aos="fade-left" data-aos-delay="400">
    <!-- Video de YouTube -->
    <div class="video-container">
        <iframe 
            width="100%" 
            height="400" 
            src="https://www.youtube.com/embed/TU_VIDEO_ID" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>
</div>
```

**Archivo:** `public/css/landing.css`

```css
.video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
```

### 13. Agregar Chat Widget (Tawk.to)

**Archivo:** `Modules/Superadmin/Resources/views/layouts/landing.blade.php`

Antes de `</body>`:

```blade
@if(config('landing.features_enabled.chat_widget'))
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/TU_TAWK_ID/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
@endif
```

Activa en `.env`:

```bash
ENABLE_CHAT_WIDGET=true
```

### 14. Agregar Google Analytics

**Archivo:** `.env`

```bash
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

**Archivo:** `Modules/Superadmin/Resources/views/layouts/landing.blade.php`

Antes de `</head>`:

```blade
@if(config('landing.analytics.google_analytics_id'))
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('landing.analytics.google_analytics_id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ config('landing.analytics.google_analytics_id') }}');
</script>
@endif
```

### 15. Personalizar Gradientes

**Archivo:** `public/css/landing.css`

```css
/* Gradiente del Hero */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    /* Cambia por: */
    background: linear-gradient(135deg, #TU_COLOR_1 0%, #TU_COLOR_2 100%);
}

/* Gradientes sugeridos: */

/* Azul océano */
background: linear-gradient(135deg, #2E3192 0%, #1BFFFF 100%);

/* Atardecer */
background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 90%, #2BFF88 100%);

/* Bosque */
background: linear-gradient(135deg, #0F2027 0%, #203A43 50%, #2C5364 100%);

/* Fuego */
background: linear-gradient(135deg, #F2994A 0%, #F2C94C 100%);

/* Noche */
background: linear-gradient(135deg, #000428 0%, #004e92 100%);
```

Generador de gradientes: https://cssgradient.io/

## 📱 Optimización para Móviles

### 16. Ajustar Tamaños de Texto en Móvil

**Archivo:** `public/css/landing.css`

Busca la sección `@media (max-width: 768px)` y ajusta:

```css
@media (max-width: 768px) {
    .hero-title {
        font-size: 32px;  /* Ajusta según necesites */
    }
    
    .hero-subtitle {
        font-size: 16px;
    }
    
    .section-title {
        font-size: 28px;
    }
}
```

## 🎨 Paletas de Colores Sugeridas

### Profesional (Azul)
```css
--primary: #2563eb;
--secondary: #10b981;
--accent: #f59e0b;
```

### Moderno (Morado)
```css
--primary: #7c3aed;
--secondary: #ec4899;
--accent: #f59e0b;
```

### Energético (Naranja)
```css
--primary: #ea580c;
--secondary: #84cc16;
--accent: #0ea5e9;
```

### Elegante (Negro)
```css
--primary: #1e293b;
--secondary: #6366f1;
--accent: #f59e0b;
```

### Fresco (Verde)
```css
--primary: #059669;
--secondary: #0ea5e9;
--accent: #f59e0b;
```

## 🔧 Herramientas Útiles

- **Colores:** https://coolors.co/
- **Gradientes:** https://cssgradient.io/
- **Iconos:** https://fontawesome.com/icons
- **Fuentes:** https://fonts.google.com/
- **Imágenes:** https://unsplash.com/
- **Placeholders:** https://placehold.co/
- **Avatares:** https://ui-avatars.com/
- **Optimizar imágenes:** https://tinypng.com/

## 📋 Checklist de Personalización

- [ ] Cambiar título y descripción principal
- [ ] Actualizar colores de marca
- [ ] Agregar logo personalizado
- [ ] Configurar información de contacto
- [ ] Agregar enlaces de redes sociales
- [ ] Personalizar características
- [ ] Agregar testimonios reales
- [ ] Actualizar FAQ con preguntas relevantes
- [ ] Agregar imágenes reales del producto
- [ ] Configurar Google Analytics
- [ ] Probar en móvil y tablet
- [ ] Verificar todos los enlaces
- [ ] Optimizar imágenes
- [ ] Configurar paquetes de precios
- [ ] Agregar chat widget (opcional)

## 🚀 Después de Personalizar

1. **Limpia la caché:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

2. **Prueba en diferentes dispositivos:**
   - Desktop (Chrome, Firefox, Safari)
   - Tablet (iPad, Android)
   - Móvil (iPhone, Android)

3. **Verifica velocidad:**
   - https://pagespeed.web.dev/

4. **Prueba SEO:**
   - https://search.google.com/test/mobile-friendly

5. **Lanza y promociona:**
   - Comparte en redes sociales
   - Envía a tu lista de correo
   - Configura anuncios (Google Ads, Facebook Ads)

---

**¿Necesitas más ayuda?** Consulta el archivo `LANDING_PAGE_README.md` para documentación completa.

# 🔍 Diagnóstico y Solución FAQ

## 🧪 Prueba Rápida

1. **Abre el archivo de prueba:**
   - Abre `test-faq.html` en tu navegador
   - Si funciona aquí, el problema es de integración

2. **Verifica en la consola del navegador:**
   - Abre tu landing page
   - Presiona F12 (o Cmd+Option+I en Mac)
   - Ve a la pestaña "Console"
   - Haz clic en una pregunta del FAQ
   - ¿Ves algún error o mensaje?

## 🔧 Soluciones por Problema

### Problema 1: jQuery no está cargado
**Síntoma:** Error en consola: "$ is not defined"

**Solución:**
Verifica que jQuery esté antes del script del FAQ en el layout.

### Problema 2: El JavaScript no se ejecuta
**Síntoma:** No aparece "Landing page JavaScript loaded" en consola

**Solución:**
```bash
# Limpiar caché
php artisan view:clear
php artisan cache:clear

# En el navegador
Ctrl + Shift + R (forzar recarga)
```

### Problema 3: Los estilos no se aplican
**Síntoma:** El FAQ no tiene estilos o se ve raro

**Solución:**
Verifica que `landing.css` esté cargando:
- Abre DevTools (F12)
- Ve a Network
- Recarga la página
- Busca `landing.css`
- Debe aparecer con status 200

## 🚀 Solución Alternativa (Sin jQuery)

Si jQuery está causando problemas, usa esta versión en vanilla JavaScript:

```javascript
@section('javascript')
<script>
    // Versión sin jQuery
    window.addEventListener('load', function() {
        console.log('FAQ Script loaded');
        
        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(function(question) {
            question.addEventListener('click', function() {
                var item = this.closest('.faq-item');
                var isActive = item.classList.contains('active');
                
                console.log('FAQ clicked:', this.querySelector('h4').textContent);
                
                // Cerrar todos
                document.querySelectorAll('.faq-item').forEach(function(i) {
                    i.classList.remove('active');
                });
                
                // Abrir si no estaba activo
                if (!isActive) {
                    item.classList.add('active');
                    console.log('FAQ opened');
                } else {
                    console.log('FAQ closed');
                }
            });
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (href === '#' || href === '#!') return;
                
                var target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    var offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    console.log('Scrolled to:', href);
                }
            });
        });
    });
</script>
@endsection
```

## 📋 Checklist de Verificación

Marca lo que ya verificaste:

- [ ] jQuery está cargado (ver en consola)
- [ ] No hay errores en consola
- [ ] El CSS de landing.css está cargando
- [ ] Los IDs de las secciones existen (#faq, #features, etc.)
- [ ] El archivo test-faq.html funciona correctamente
- [ ] La caché está limpia (php artisan view:clear)
- [ ] El navegador está actualizado (Ctrl+Shift+R)

## 🎯 Comandos para Aplicar Cambios

```bash
# En local
git add .
git commit -m "fix: Mejorar FAQ con jQuery y transiciones"
git push origin main

# En servidor
cd /home/audaz.site/public_html
git pull origin main
php artisan view:clear
php artisan cache:clear
chmod 644 public/css/landing.css
chmod 644 public/js/landing.js
```

## 🔍 Debug en Vivo

Agrega esto temporalmente al inicio de la sección @javascript:

```javascript
<script>
    console.log('=== DEBUG FAQ ===');
    console.log('jQuery loaded:', typeof jQuery !== 'undefined');
    console.log('FAQ items found:', document.querySelectorAll('.faq-item').length);
    console.log('FAQ questions found:', document.querySelectorAll('.faq-question').length);
</script>
```

Luego abre la consola y verifica qué números aparecen.

## 💡 Si Nada Funciona

Prueba esta versión super simple directamente en el HTML:

```html
<!-- Al final de landing/index.blade.php, antes de @endsection -->
<script>
document.querySelectorAll('.faq-question').forEach(q => {
    q.onclick = function() {
        this.parentElement.classList.toggle('active');
    };
});
</script>
```

Esta versión es la más básica posible y DEBE funcionar.

## 📞 Información para Debug

Cuando pruebes, anota:
1. ¿Qué navegador usas?
2. ¿Qué errores aparecen en consola?
3. ¿El test-faq.html funciona?
4. ¿Qué números aparecen en el debug?

Con esa info puedo ayudarte mejor.

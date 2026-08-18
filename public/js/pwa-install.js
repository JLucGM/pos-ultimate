/**
 * Kubre - PWA Installation & Service Worker Registration Manager
 */

(function () {
    'use strict';

    let deferredPrompt = null;

    // Register & Update Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js')
                .then(function (registration) {
                    registration.update();
                    console.log('Kubre PWA ServiceWorker registrado y actualizado:', registration.scope);
                })
                .catch(function (error) {
                    console.warn('Error al registrar ServiceWorker:', error);
                });
        });
    }

    // Capture beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        showPwaInstallPrompt();
    });

    function showPwaInstallPrompt() {
        // Check if user previously dismissed banner in last 7 days
        const dismissedAt = localStorage.getItem('kubre_pwa_dismissed');
        if (dismissedAt && (Date.now() - parseInt(dismissedAt, 10)) < 7 * 24 * 60 * 60 * 1000) {
            return;
        }

        // Check if banner already exists
        if (document.getElementById('kubre-pwa-banner')) {
            return;
        }

        // Create sleek floating bottom banner for mobile/desktop
        const banner = document.createElement('div');
        banner.id = 'kubre-pwa-banner';
        banner.className = 'audaz-pwa-banner';
        banner.innerHTML = `
            <div class="audaz-pwa-banner-content">
                <img src="/img/icons/icon-192x192.png" alt="Kubre" class="audaz-pwa-banner-icon">
                <div class="audaz-pwa-banner-text">
                    <div class="audaz-pwa-banner-title">Instalar Kubre</div>
                    <div class="audaz-pwa-banner-sub">Úsalo en pantalla completa como una App nativa</div>
                </div>
            </div>
            <div class="audaz-pwa-banner-actions">
                <button type="button" id="pwa-install-btn" class="audaz-pwa-btn-install">
                    <i class="fas fa-download"></i> Instalar
                </button>
                <button type="button" id="pwa-dismiss-btn" class="audaz-pwa-btn-dismiss" title="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

        document.body.appendChild(banner);

        // Bind install button
        document.getElementById('pwa-install-btn').addEventListener('click', function () {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(function (choiceResult) {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('El usuario aceptó la instalación de Kubre');
                    }
                    deferredPrompt = null;
                    banner.remove();
                });
            }
        });

        // Bind dismiss button
        document.getElementById('pwa-dismiss-btn').addEventListener('click', function () {
            localStorage.setItem('kubre_pwa_dismissed', Date.now().toString());
            banner.remove();
        });
    }

    // App installed event
    window.addEventListener('appinstalled', function () {
        console.log('Kubre instalado como aplicación nativa.');
        const banner = document.getElementById('kubre-pwa-banner');
        if (banner) {
            banner.remove();
        }
    });
})();

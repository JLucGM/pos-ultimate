/**
 * Audaz POS - PWA Installation & Service Worker Registration Manager
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
                    console.log('Audaz PWA ServiceWorker registrado y actualizado:', registration.scope);
                })
                .catch(function (error) {
                    console.warn('Error al registrar ServiceWorker:', error);
                });
        });
    }

    // Capture beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', function (e) {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;

        // Show install button or banner
        showPwaInstallPrompt();
    });

    function showPwaInstallPrompt() {
        // Check if user previously dismissed banner in last 7 days
        const dismissedAt = localStorage.getItem('audaz_pwa_dismissed');
        if (dismissedAt && (Date.now() - parseInt(dismissedAt, 10)) < 7 * 24 * 60 * 60 * 1000) {
            return;
        }

        // Check if banner already exists
        if (document.getElementById('audaz-pwa-banner')) {
            return;
        }

        // Create sleek floating bottom banner for mobile/desktop
        const banner = document.createElement('div');
        banner.id = 'audaz-pwa-banner';
        banner.className = 'audaz-pwa-banner';
        banner.innerHTML = `
            <div class="audaz-pwa-banner-content">
                <img src="/img/icons/icon-192x192.png" alt="Audaz POS" class="audaz-pwa-banner-icon">
                <div class="audaz-pwa-banner-text">
                    <div class="audaz-pwa-banner-title">Instalar Audaz POS</div>
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
                        console.log('El usuario aceptó la instalación de Audaz POS');
                    }
                    deferredPrompt = null;
                    banner.remove();
                });
            }
        });

        // Bind dismiss button
        document.getElementById('pwa-dismiss-btn').addEventListener('click', function () {
            localStorage.setItem('audaz_pwa_dismissed', Date.now().toString());
            banner.remove();
        });
    }

    // App installed event
    window.addEventListener('appinstalled', function () {
        console.log('Audaz POS instalado como aplicación nativa.');
        const banner = document.getElementById('audaz-pwa-banner');
        if (banner) {
            banner.remove();
        }
    });
})();

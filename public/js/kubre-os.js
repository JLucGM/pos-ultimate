/**
 * Kubre OS - ERP Modern Desktop & Mobile UI Framework
 * Interactive Dock Controller, Instant Sub-Docks, Pin/Unpin Engine & Universal Search
 */

(function() {
    'use strict';

    const STORAGE_KEY = 'kubre_os_unpinned_modules';

    // 1. Storage Helpers for Dock Customization
    function getUnpinnedModules() {
        try {
            const stored = localStorage.getItem(STORAGE_KEY);
            return stored ? JSON.parse(stored) : [];
        } catch (e) {
            return [];
        }
    }

    function saveUnpinnedModules(modules) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(modules));
        } catch (e) {
            console.error('Error saving dock preferences', e);
        }
    }

    function initKubreOS() {
        // Elements
        const launchpadOverlay = document.getElementById('kubre-launchpad-overlay');
        const launchpadSearch = document.getElementById('kubre-launchpad-search');
        const launchpadClose = document.getElementById('kubre-launchpad-close');
        const launcherBtns = document.querySelectorAll('.kubre-open-launchpad');
        const appCards = document.querySelectorAll('.kubre-app-card');
        const quickBtns = document.querySelectorAll('.kubre-quick-btn');
        const subdockItems = document.querySelectorAll('.kubre-has-subdock');
        const subdockLinks = document.querySelectorAll('.kubre-subdock-link, .kubre-subdock-mainlink');
        
        // Customizer Elements
        const customizerModal = document.getElementById('kubre-dock-customizer-modal');
        const customizerClose = document.getElementById('kubre-customizer-close');
        const customizerDoneBtn = document.getElementById('kubre-done-dock-btn');
        const customizerResetBtn = document.getElementById('kubre-reset-dock-btn');
        const openCustomizerBtns = document.querySelectorAll('.kubre-open-customizer');
        const dockToggles = document.querySelectorAll('.kubre-dock-toggle[data-app]');
        const unpinBtns = document.querySelectorAll('.kubre-subdock-unpin-btn[data-unpin]');
        const pinToggleBtns = document.querySelectorAll('.kubre-app-pin-btn[data-pin-toggle]');

        let subdockTimer = null;

        // 2. Apply Dock Preferences (Pin / Unpin state)
        function applyDockPreferences() {
            const unpinned = getUnpinnedModules();
            
            // A. Update Dock Items visibility
            const dockItems = document.querySelectorAll('.kubre-dock-item[data-dock-app]');
            dockItems.forEach(item => {
                const appId = item.getAttribute('data-dock-app');
                if (unpinned.includes(appId)) {
                    item.classList.add('is-unpinned');
                } else {
                    item.classList.remove('is-unpinned');
                }
            });

            // B. Update Customizer Modal Switches
            dockToggles.forEach(toggle => {
                const appId = toggle.getAttribute('data-app');
                toggle.checked = !unpinned.includes(appId);
            });

            // C. Update Launchpad App Pin Badges
            pinToggleBtns.forEach(btn => {
                const appId = btn.getAttribute('data-pin-toggle');
                const isPinned = !unpinned.includes(appId);
                if (isPinned) {
                    btn.classList.add('is-pinned');
                    btn.setAttribute('title', 'Desanclar del Dock');
                } else {
                    btn.classList.remove('is-pinned');
                    btn.setAttribute('title', 'Fijar en el Dock');
                }
            });
        }

        // 3. Pin & Unpin Actions
        function unpinModule(appId) {
            if (!appId) return;
            let unpinned = getUnpinnedModules();
            if (!unpinned.includes(appId)) {
                unpinned.push(appId);
                saveUnpinnedModules(unpinned);
                applyDockPreferences();
                closeAllSubdocks();
            }
        }

        function pinModule(appId) {
            if (!appId) return;
            let unpinned = getUnpinnedModules();
            if (unpinned.includes(appId)) {
                unpinned = unpinned.filter(id => id !== appId);
                saveUnpinnedModules(unpinned);
                applyDockPreferences();
            }
        }

        function togglePinModule(appId) {
            if (!appId) return;
            let unpinned = getUnpinnedModules();
            if (unpinned.includes(appId)) {
                pinModule(appId);
            } else {
                unpinModule(appId);
            }
        }

        function resetDockPreferences() {
            saveUnpinnedModules([]);
            applyDockPreferences();
        }

        // Apply initial preferences immediately
        applyDockPreferences();

        // 4. Customizer Modal Controls
        function openCustomizerModal() {
            closeAllSubdocks();
            if (customizerModal) {
                customizerModal.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeCustomizerModal() {
            if (customizerModal) {
                customizerModal.classList.remove('is-open');
                if (!launchpadOverlay || !launchpadOverlay.classList.contains('is-open')) {
                    document.body.style.overflow = '';
                }
            }
        }

        openCustomizerBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openCustomizerModal();
            });
        });

        if (customizerClose) {
            customizerClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeCustomizerModal();
            });
        }

        if (customizerDoneBtn) {
            customizerDoneBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeCustomizerModal();
            });
        }

        if (customizerResetBtn) {
            customizerResetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                resetDockPreferences();
            });
        }

        if (customizerModal) {
            customizerModal.addEventListener('click', function(e) {
                if (e.target === customizerModal) {
                    closeCustomizerModal();
                }
            });
        }

        // Switch toggles inside customizer modal
        dockToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const appId = this.getAttribute('data-app');
                if (this.checked) {
                    pinModule(appId);
                } else {
                    unpinModule(appId);
                }
            });
        });

        // Unpin buttons in Subdock headers
        unpinBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const appId = this.getAttribute('data-unpin');
                unpinModule(appId);
            });
        });

        // Pin/Unpin buttons on Launchpad app cards
        pinToggleBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const appId = this.getAttribute('data-pin-toggle');
                togglePinModule(appId);
            });
        });

        // 5. Sub-dock Open/Close Controls
        function closeAllSubdocks() {
            if (subdockTimer) {
                clearTimeout(subdockTimer);
                subdockTimer = null;
            }
            subdockItems.forEach(item => {
                item.classList.remove('has-subdock-open');
            });
        }

        function openSubdock(item) {
            if (subdockTimer) {
                clearTimeout(subdockTimer);
                subdockTimer = null;
            }
            subdockItems.forEach(other => {
                if (other !== item) {
                    other.classList.remove('has-subdock-open');
                }
            });
            item.classList.add('has-subdock-open');
        }

        // Direct navigation on subdock link click (ZERO lag, 1st click guaranteed)
        subdockLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.stopPropagation();
                const href = this.getAttribute('href');
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    window.location.href = href;
                }
            });
        });

        // Sub-dock click & hover handling on dock items
        subdockItems.forEach(item => {
            // Click Handler on dock icon
            item.addEventListener('click', function(e) {
                // If clicked inside the subdock panel/links/unpin buttons, do not toggle dock
                if (e.target.closest('.kubre-subdock-deck')) {
                    return;
                }

                e.preventDefault();
                e.stopPropagation();

                const isOpen = item.classList.contains('has-subdock-open');
                if (isOpen) {
                    closeAllSubdocks();
                } else {
                    openSubdock(item);
                }
            });

            // Smooth Hover (Mouseenter)
            item.addEventListener('mouseenter', function() {
                if (subdockTimer) {
                    clearTimeout(subdockTimer);
                    subdockTimer = null;
                }
                const anyOpen = document.querySelector('.kubre-has-subdock.has-subdock-open');
                if (anyOpen && anyOpen !== item) {
                    openSubdock(item);
                }
            });

            // Mouseleave with grace period
            item.addEventListener('mouseleave', function() {
                if (item.classList.contains('has-subdock-open')) {
                    subdockTimer = setTimeout(() => {
                        item.classList.remove('has-subdock-open');
                    }, 350);
                }
            });
        });

        // Close sub-docks on clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.kubre-has-subdock') && !e.target.closest('#kubre-dock-customizer-modal')) {
                closeAllSubdocks();
            }
        });

        if (!launchpadOverlay) return;

        // 6. Launchpad Open/Close Controls
        function openLaunchpad() {
            closeAllSubdocks();
            closeCustomizerModal();
            launchpadOverlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            if (launchpadSearch) {
                setTimeout(() => {
                    launchpadSearch.focus();
                    launchpadSearch.select();
                }, 100);
            }
        }

        function closeLaunchpad() {
            launchpadOverlay.classList.remove('is-open');
            if (!customizerModal || !customizerModal.classList.contains('is-open')) {
                document.body.style.overflow = '';
            }
            if (launchpadSearch) {
                launchpadSearch.value = '';
                filterItems('');
            }
        }

        function toggleLaunchpad() {
            if (launchpadOverlay.classList.contains('is-open')) {
                closeLaunchpad();
            } else {
                openLaunchpad();
            }
        }

        // Attach Click Events to Launcher Buttons & Top Global Search Bar
        launcherBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleLaunchpad();
            });
        });

        const globalSearchBar = document.getElementById('audaz-global-search-bar');
        if (globalSearchBar) {
            globalSearchBar.addEventListener('focus', function(e) {
                e.preventDefault();
                this.blur();
                openLaunchpad();
            });
            globalSearchBar.addEventListener('click', function(e) {
                e.preventDefault();
                openLaunchpad();
            });
        }

        if (launchpadClose) {
            launchpadClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeLaunchpad();
            });
        }

        launchpadOverlay.addEventListener('click', function(e) {
            if (e.target === launchpadOverlay) {
                closeLaunchpad();
            }
        });

        // 7. Global Keyboard Shortcuts: Ctrl+K, Cmd+K, Alt+Space, Escape
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                toggleLaunchpad();
            } else if (e.altKey && e.code === 'Space') {
                e.preventDefault();
                toggleLaunchpad();
            } else if (e.key === 'Escape') {
                if (customizerModal && customizerModal.classList.contains('is-open')) {
                    e.preventDefault();
                    closeCustomizerModal();
                } else if (launchpadOverlay.classList.contains('is-open')) {
                    e.preventDefault();
                    closeLaunchpad();
                } else {
                    closeAllSubdocks();
                }
            }
        });

        // 8. Live Search Filtering
        function filterItems(query) {
            const cleanQuery = query.toLowerCase().trim();

            appCards.forEach(card => {
                const label = card.querySelector('.kubre-app-label')?.textContent.toLowerCase() || '';
                const keywords = card.getAttribute('data-keywords')?.toLowerCase() || '';
                if (!cleanQuery || label.includes(cleanQuery) || keywords.includes(cleanQuery)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            quickBtns.forEach(btn => {
                const text = btn.textContent.toLowerCase() || '';
                const keywords = btn.getAttribute('data-keywords')?.toLowerCase() || '';
                if (!cleanQuery || text.includes(cleanQuery) || keywords.includes(cleanQuery)) {
                    btn.style.display = 'flex';
                } else {
                    btn.style.display = 'none';
                }
            });
        }

        if (launchpadSearch) {
            launchpadSearch.addEventListener('input', function(e) {
                filterItems(e.target.value);
            });
        }

        // 9. Mobile Bottom Nav Integration: Connect Mobile "Módulos" toggle to Launchpad
        const mobileMenuToggle = document.getElementById('audazBottomMenuToggle');
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                toggleLaunchpad();
            });
        }
    }

    // Initialize on DOM Ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initKubreOS);
    } else {
        initKubreOS();
    }
})();

/**
 * Kubre OS - ERP Modern Desktop & Mobile UI Framework
 * Interactive Dock Controller, Instant Sub-Docks & Universal Search
 */

(function() {
    'use strict';

    function initKubreOS() {
        const launchpadOverlay = document.getElementById('kubre-launchpad-overlay');
        const launchpadSearch = document.getElementById('kubre-launchpad-search');
        const launchpadClose = document.getElementById('kubre-launchpad-close');
        const launcherBtns = document.querySelectorAll('.kubre-open-launchpad');
        const appCards = document.querySelectorAll('.kubre-app-card');
        const quickBtns = document.querySelectorAll('.kubre-quick-btn');
        const subdockItems = document.querySelectorAll('.kubre-has-subdock');
        const subdockLinks = document.querySelectorAll('.kubre-subdock-link, .kubre-subdock-mainlink');

        let subdockTimer = null;

        // 1. Close all open sub-docks
        function closeAllSubdocks() {
            if (subdockTimer) {
                clearTimeout(subdockTimer);
                subdockTimer = null;
            }
            subdockItems.forEach(item => {
                item.classList.remove('has-subdock-open');
            });
        }

        // 2. Open specific sub-dock
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

        // 3. Direct, instant navigation on subdock link click (ZERO lag, 1st click guaranteed)
        subdockLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.stopPropagation();
                const href = this.getAttribute('href');
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    window.location.href = href;
                }
            });
        });

        // 4. Sub-dock click & hover handling on dock items
        subdockItems.forEach(item => {
            // Click Handler on dock icon
            item.addEventListener('click', function(e) {
                // If clicked inside the subdock panel/links, do not toggle dock
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
            if (!e.target.closest('.kubre-has-subdock')) {
                closeAllSubdocks();
            }
        });

        if (!launchpadOverlay) return;

        // 5. Open Launchpad
        function openLaunchpad() {
            closeAllSubdocks();
            launchpadOverlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            if (launchpadSearch) {
                setTimeout(() => {
                    launchpadSearch.focus();
                    launchpadSearch.select();
                }, 100);
            }
        }

        // 6. Close Launchpad
        function closeLaunchpad() {
            launchpadOverlay.classList.remove('is-open');
            document.body.style.overflow = '';
            if (launchpadSearch) {
                launchpadSearch.value = '';
                filterItems('');
            }
        }

        // 7. Toggle Launchpad
        function toggleLaunchpad() {
            if (launchpadOverlay.classList.contains('is-open')) {
                closeLaunchpad();
            } else {
                openLaunchpad();
            }
        }

        // 8. Attach Click Events to Launcher Buttons & Top Global Search Bar
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

        // Close on close button click
        if (launchpadClose) {
            launchpadClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeLaunchpad();
            });
        }

        // Close on clicking backdrop
        launchpadOverlay.addEventListener('click', function(e) {
            if (e.target === launchpadOverlay) {
                closeLaunchpad();
            }
        });

        // 9. Global Keyboard Shortcuts: Ctrl+K, Cmd+K, Alt+Space, Escape
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                toggleLaunchpad();
            } else if (e.altKey && e.code === 'Space') {
                e.preventDefault();
                toggleLaunchpad();
            } else if (e.key === 'Escape') {
                if (launchpadOverlay.classList.contains('is-open')) {
                    e.preventDefault();
                    closeLaunchpad();
                } else {
                    closeAllSubdocks();
                }
            }
        });

        // 10. Live Search Filtering
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

        // 11. Mobile Bottom Nav Integration: Connect Mobile "Módulos" toggle to Launchpad
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

/**
 * People Section - Tab Toggle Functionality
 * Scoped to .apl-people only
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        const peopleSection = document.querySelector('.apl-people');

        if (!peopleSection) {
            return;
        }

        const pills = peopleSection.querySelectorAll('.apl-people__pill');
        const panels = peopleSection.querySelectorAll('.apl-people__panel');

        if (!pills.length || !panels.length) {
            return;
        }

        // Add click handler to each pill
        pills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                if (!targetTab) {
                    return;
                }

                // Update pills
                pills.forEach(function(p) {
                    p.classList.remove('is-active');
                    p.setAttribute('aria-selected', 'false');
                });
                this.classList.add('is-active');
                this.setAttribute('aria-selected', 'true');

                // Update panels
                panels.forEach(function(panel) {
                    const panelTab = panel.getAttribute('data-panel');

                    if (panelTab === targetTab) {
                        panel.classList.add('is-active');
                    } else {
                        panel.classList.remove('is-active');
                    }
                });
            });
        });
    }
})();

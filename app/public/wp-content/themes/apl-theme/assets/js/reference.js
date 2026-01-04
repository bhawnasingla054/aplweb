/**
 * Placeholder for any lightweight interactions the reference layout might need.
 * Extend this file if you need to wire up animations or toggle behavior.
 */
(function () {
    document.documentElement.classList.add('apl-reference-ready');

    const selectors = {
        carousel: '.apl-demo__carousel',
        track: '.apl-demo__track',
        card: '.apl-demo__card',
        prev: '.apl-demo__arrow--prev',
        next: '.apl-demo__arrow--next',
    };

    const carousels = document.querySelectorAll(selectors.carousel);

    carousels.forEach((carousel) => {
        const track = carousel.querySelector(selectors.track);
        if (!track) {
            return;
        }

        const cards = Array.from(track.querySelectorAll(selectors.card));
        const total = cards.length;

        if (total === 0) {
            return;
        }

        let current = 0;
        const autoplayEnabled = carousel.dataset.autoplay === 'true';
        const delay = 2500;
        let timer = null;

        const applyState = () => {
            cards.forEach((card) => {
                card.classList.remove('is-active', 'is-prev', 'is-next');
            });

            if (total === 1) {
                cards[0].classList.add('is-active');
                return;
            }

            const prevIndex = (current - 1 + total) % total;
            const nextIndex = (current + 1) % total;

            cards[current].classList.add('is-active');
            cards[prevIndex].classList.add('is-prev');
            cards[nextIndex].classList.add('is-next');
        };

        const go = (dir) => {
            if (total <= 1) {
                return;
            }

            current = (current + dir + total) % total;
            applyState();
        };

        const start = () => {
            if (!autoplayEnabled || total <= 1) {
                return;
            }

            if (timer) {
                return;
            }

            timer = setInterval(() => {
                go(1);
            }, delay);
        };

        const stop = () => {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        };

        const restart = () => {
            stop();
            start();
        };

        const prevButton = carousel.querySelector(selectors.prev);
        const nextButton = carousel.querySelector(selectors.next);

        if (prevButton) {
            prevButton.addEventListener('click', () => {
                go(-1);
                restart();
            });
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => {
                go(1);
                restart();
            });
        }

        carousel.addEventListener('mouseenter', stop);
        carousel.addEventListener('mouseleave', start);

        applyState();
        start();
    });
})();

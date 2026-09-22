// Universal Background Music Manager for Fruit Math
const preferenceKey = 'fruit-math-music-muted';
const audioSrc = '/audio/fruit-garden.wav';

class GlobalMusicManager {
    constructor() {
        this.audio = null;
        this.muted = false;
        try {
            this.muted = localStorage.getItem(preferenceKey) === 'true';
        } catch {
            this.muted = false;
        }
        this.init();
    }

    init() {
        if (!this.audio && typeof Audio !== 'undefined') {
            this.audio = new Audio(audioSrc);
            this.audio.loop = true;
            this.audio.volume = 0.28;
            this.audio.preload = 'none';

            this.audio.addEventListener('playing', () => this.updateUI());
            this.audio.addEventListener('pause', () => this.updateUI());
        }

        // Browser policy: start playing on first user interaction if not muted
        const gesture = () => {
            if (!this.muted && this.audio && this.audio.paused) {
                this.play();
            }
        };

        document.addEventListener('pointerdown', gesture, { passive: true, once: true });
        document.addEventListener('keydown', gesture, { passive: true, once: true });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                if (this.audio && !this.audio.paused) this.audio.pause();
            } else {
                if (!this.muted && this.audio && this.audio.paused) this.play();
            }
        });

        // Clean event delegation for toggle buttons (prevents DOM thrashing & MutationObserver loops)
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-music-toggle], [data-global-music-toggle]');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            }
        });

        const sync = () => this.updateUI();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', sync, { once: true });
        } else {
            sync();
        }

        document.addEventListener('livewire:navigated', () => {
            this.updateUI();
            if (!this.muted && this.audio && this.audio.paused) this.play();
        });
    }

    play() {
        if (this.muted || !this.audio) return;
        this.audio.play().catch(() => {});
        this.updateUI();
    }

    pause() {
        if (!this.audio) return;
        this.audio.pause();
        this.updateUI();
    }

    toggle() {
        this.muted = !this.muted;
        try {
            localStorage.setItem(preferenceKey, String(this.muted));
        } catch {}

        if (this.muted) {
            this.pause();
        } else {
            this.play();
        }
        this.updateUI();
    }

    updateUI() {
        const isPlaying = this.audio && !this.audio.paused && !this.muted;
        const buttons = document.querySelectorAll('[data-music-toggle], [data-global-music-toggle]');
        const isSw = document.documentElement.lang === 'sw';

        buttons.forEach(btn => {
            const targetPressed = String(isPlaying);
            if (btn.getAttribute('aria-pressed') !== targetPressed) {
                btn.setAttribute('aria-pressed', targetPressed);
            }

            const targetLabel = isPlaying
                ? (isSw ? 'Zima muziki' : 'Mute music')
                : (isSw ? 'Washa muziki' : 'Play music');
            if (btn.getAttribute('aria-label') !== targetLabel) {
                btn.setAttribute('aria-label', targetLabel);
            }

            const iconEl = btn.querySelector('.music-icon');
            if (iconEl) {
                const targetIcon = isPlaying ? '🎵' : '🔇';
                if (iconEl.textContent !== targetIcon) {
                    iconEl.textContent = targetIcon;
                }
            }

            const labelEl = btn.querySelector('.music-label');
            if (labelEl) {
                const targetText = isPlaying
                    ? (isSw ? 'Muziki: Unalia' : 'Music: On')
                    : (isSw ? 'Muziki: Umezimwa' : 'Music: Off');
                if (labelEl.textContent !== targetText) {
                    labelEl.textContent = targetText;
                }
            }
        });
    }
}

window.FruitMusic = new GlobalMusicManager();

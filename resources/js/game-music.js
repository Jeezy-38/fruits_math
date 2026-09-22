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

        document.addEventListener('pointerdown', gesture, { passive: true });
        document.addEventListener('keydown', gesture, { passive: true });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                if (this.audio && !this.audio.paused) this.audio.pause();
            } else {
                if (!this.muted && this.audio && this.audio.paused) this.play();
            }
        });

        const bindAll = () => this.syncButtons();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bindAll, { once: true });
        } else {
            bindAll();
        }

        document.addEventListener('livewire:navigated', () => {
            this.syncButtons();
            if (!this.muted && this.audio && this.audio.paused) this.play();
        });

        new MutationObserver(bindAll).observe(document.body, { childList: true, subtree: true });
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

    syncButtons() {
        const buttons = document.querySelectorAll('[data-music-toggle], [data-global-music-toggle]');
        buttons.forEach(btn => {
            if (btn._musicBound) return;
            btn._musicBound = true;
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            });
        });
        this.updateUI();
    }

    updateUI() {
        const isPlaying = this.audio && !this.audio.paused && !this.muted;
        const buttons = document.querySelectorAll('[data-music-toggle], [data-global-music-toggle]');
        const isSw = document.documentElement.lang === 'sw';

        buttons.forEach(btn => {
            btn.setAttribute('aria-pressed', String(isPlaying));
            btn.setAttribute('aria-label', isPlaying ? (isSw ? 'Zima muziki' : 'Mute music') : (isSw ? 'Washa muziki' : 'Play music'));

            const iconEl = btn.querySelector('.music-icon');
            if (iconEl) {
                iconEl.textContent = isPlaying ? '🎵' : '🔇';
            }

            const labelEl = btn.querySelector('.music-label');
            if (labelEl) {
                labelEl.textContent = isPlaying
                    ? (isSw ? 'Muziki: Unalia' : 'Music: On')
                    : (isSw ? 'Muziki: Umezimwa' : 'Music: Off');
            } else {
                btn.innerHTML = isPlaying
                    ? '<span>♫ ' + (isSw ? 'Muziki' : 'Music') + '</span>'
                    : '<span>🔇 ' + (isSw ? 'Muziki' : 'Music') + '</span>';
            }
        });
    }
}

window.FruitMusic = new GlobalMusicManager();

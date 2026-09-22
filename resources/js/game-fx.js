// Lightweight Web Audio API synthesizer + zero-dependency Canvas Confetti for Fruit Math
class SoundFX {
    constructor() {
        this.ctx = null;
        this.mutedKey = 'fruit-math-music-muted';
    }

    init() {
        if (!this.ctx) {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (AudioCtx) {
                this.ctx = new AudioCtx();
            }
        }
        if (this.ctx && this.ctx.state === 'suspended') {
            this.ctx.resume().catch(() => {});
        }
    }

    isMuted() {
        try {
            return localStorage.getItem(this.mutedKey) === 'true';
        } catch {
            return false;
        }
    }

    tone(freq, type, duration, startTime, startGain, endGain) {
        if (this.isMuted() || !this.ctx) return;
        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            osc.type = type;
            osc.frequency.setValueAtTime(freq, startTime);
            gain.gain.setValueAtTime(startGain, startTime);
            gain.gain.exponentialRampToValueAtTime(Math.max(0.0001, endGain), startTime + duration);
            osc.connect(gain);
            gain.connect(this.ctx.destination);
            osc.start(startTime);
            osc.stop(startTime + duration);
        } catch (e) {}
    }

    correct() {
        this.init();
        if (!this.ctx) return;
        const now = this.ctx.currentTime;
        // 4-note ascending bell arpeggio (C5 -> E5 -> G5 -> C6)
        this.tone(523.25, 'triangle', 0.16, now, 0.22, 0.01);
        this.tone(659.25, 'triangle', 0.16, now + 0.07, 0.25, 0.01);
        this.tone(783.99, 'triangle', 0.20, now + 0.14, 0.28, 0.01);
        this.tone(1046.50, 'sine', 0.45, now + 0.22, 0.32, 0.001);
    }

    wrong() {
        this.init();
        if (!this.ctx) return;
        const now = this.ctx.currentTime;
        // Soft encouraging cartoon wobble
        this.tone(350, 'sine', 0.12, now, 0.18, 0.04);
        this.tone(260, 'sine', 0.18, now + 0.08, 0.15, 0.001);
    }

    victory() {
        this.init();
        if (!this.ctx) return;
        const now = this.ctx.currentTime;
        // Celebration victory fanfare (C5, E5, G5, high C6, E6)
        this.tone(523.25, 'triangle', 0.14, now, 0.25, 0.02);
        this.tone(659.25, 'triangle', 0.14, now + 0.10, 0.25, 0.02);
        this.tone(783.99, 'triangle', 0.16, now + 0.20, 0.28, 0.02);
        this.tone(1046.50, 'sine', 0.65, now + 0.32, 0.35, 0.001);
        this.tone(1318.51, 'sine', 0.45, now + 0.44, 0.20, 0.001);
    }

    pop() {
        this.init();
        if (!this.ctx) return;
        const now = this.ctx.currentTime;
        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(450, now);
            osc.frequency.exponentialRampToValueAtTime(920, now + 0.04);
            gain.gain.setValueAtTime(0.25, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.08);
            osc.connect(gain);
            gain.connect(this.ctx.destination);
            osc.start(now);
            osc.stop(now + 0.08);
        } catch {
            this.tone(600, 'sine', 0.06, now, 0.15, 0.001);
        }
    }
}

export const fx = new SoundFX();

// Canvas Confetti
export function launchConfetti(duration = 2800) {
    let canvas = document.getElementById('fruit-confetti-canvas');
    if (!canvas) {
        canvas = document.createElement('canvas');
        canvas.id = 'fruit-confetti-canvas';
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100vw';
        canvas.style.height = '100vh';
        canvas.style.pointerEvents = 'none';
        canvas.style.zIndex = '99999';
        document.body.appendChild(canvas);
    }

    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const colors = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#ec4899', '#8b5cf6', '#fbbf24'];
    const emojis = ['🍎', '🍌', '🍊', '🍓', '⭐', '✨'];
    const particles = [];

    for (let i = 0; i < 90; i++) {
        const isEmoji = i % 5 === 0;
        particles.push({
            x: canvas.width / 2 + (Math.random() - 0.5) * (canvas.width * 0.5),
            y: canvas.height * 0.35,
            vx: (Math.random() - 0.5) * 14,
            vy: -Math.random() * 12 - 4,
            size: isEmoji ? 24 : Math.random() * 8 + 6,
            color: colors[Math.floor(Math.random() * colors.length)],
            emoji: isEmoji ? emojis[Math.floor(Math.random() * emojis.length)] : null,
            rotation: Math.random() * 360,
            vRot: (Math.random() - 0.5) * 10,
            opacity: 1,
            decay: Math.random() * 0.008 + 0.006,
        });
    }

    let start = performance.now();

    function render(t) {
        const elapsed = t - start;
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        let active = false;
        for (const p of particles) {
            p.x += p.vx;
            p.y += p.vy;
            p.vy += 0.35;
            p.vx *= 0.98;
            p.rotation += p.vRot;
            p.opacity = Math.max(0, p.opacity - p.decay);

            if (p.opacity > 0 && p.y < canvas.height + 40) {
                active = true;
                ctx.save();
                ctx.globalAlpha = p.opacity;
                ctx.translate(p.x, p.y);
                ctx.rotate((p.rotation * Math.PI) / 180);

                if (p.emoji) {
                    ctx.font = `${p.size}px sans-serif`;
                    ctx.textAlign = 'center';
                    ctx.fillText(p.emoji, 0, 0);
                } else {
                    ctx.fillStyle = p.color;
                    ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
                }
                ctx.restore();
            }
        }

        if (active && elapsed < duration) {
            requestAnimationFrame(render);
        } else {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            canvas.remove();
        }
    }

    requestAnimationFrame(render);
}

// Prime AudioContext on first user interaction
const prime = () => { fx.init(); };
document.addEventListener('pointerdown', prime, { passive: true });
document.addEventListener('keydown', prime, { passive: true });

// Livewire / Custom Event hooks
window.addEventListener('fx:correct', () => fx.correct());
window.addEventListener('fx:wrong', () => fx.wrong());
window.addEventListener('fx:victory', () => {
    fx.victory();
    launchConfetti();
});
window.addEventListener('fx:pop', () => fx.pop());
window.addEventListener('fx:confetti', () => launchConfetti());

window.FruitAudio = fx;

window.speakQuestion = function(text) {
    if (!('speechSynthesis' in window) || !text) return;
    try {
        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(text);
        const isSw = document.documentElement.lang === 'sw';
        utterance.lang = isSw ? 'sw-TZ' : 'en-US';
        utterance.rate = 0.88; // Relaxed friendly pace for kids
        utterance.pitch = 1.15; // Cheerful friendly pitch

        const voices = window.speechSynthesis.getVoices();
        if (voices && voices.length > 0) {
            const match = voices.find(v => isSw ? v.lang.toLowerCase().startsWith('sw') : v.lang.toLowerCase().startsWith('en'));
            if (match) utterance.voice = match;
        }

        window.speechSynthesis.speak(utterance);
    } catch (e) {}
};

// Auto-check for completion celebration marker in the DOM
function checkAutoCelebrate() {
    const celebrateEl = document.querySelector('[data-celebrate="true"]');
    if (celebrateEl && !celebrateEl.dataset.celebrated) {
        celebrateEl.dataset.celebrated = 'true';
        fx.victory();
        launchConfetti();
    }
}
document.addEventListener('DOMContentLoaded', checkAutoCelebrate);
document.addEventListener('livewire:navigated', checkAutoCelebrate);
if (typeof window !== 'undefined') {
    document.addEventListener('livewire:init', () => {
        if (window.Livewire && window.Livewire.hook) {
            window.Livewire.hook('morph.updated', checkAutoCelebrate);
        }
    });
}

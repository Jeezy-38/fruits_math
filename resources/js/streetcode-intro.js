// StreetCode x Fruit Math: Kid-Game Intro Engine
// Features: Marimba Audio Synthesizer, Juice Splatter Physics, Animated Mascot Kiko, Arcade Juice Loader & Fruit Pop

export function initStreetCodeIntro() {
    const introEl = document.getElementById('streetcode-intro-screen');
    if (!introEl) return;

    const isStandalone = introEl.dataset.standalone === 'true';
    const percentEl = document.getElementById('streetcode-progress-percent');
    const barEl = document.getElementById('streetcode-progress-bar');
    const runnerEl = document.getElementById('streetcode-fruit-runner');
    const statusEl = document.getElementById('streetcode-progress-status');
    const ctaBtn = document.getElementById('streetcode-enter-btn');
    const skipBtn = document.getElementById('streetcode-skip-btn');
    const soundToggle = document.getElementById('streetcode-sound-toggle');
    const popCounterEl = document.getElementById('streetcode-pop-count');
    const mascotBubbleEl = document.getElementById('intro-mascot-speech');
    const mascotCharEl = document.getElementById('intro-mascot-char');
    const autoEnterTimerEl = document.getElementById('streetcode-auto-timer');
    const canvas = document.getElementById('streetcode-juice-canvas');
    const isSw = document.documentElement.lang === 'sw';

    // Skip Intro handling (e.g. after logout, skip query param, or already seen this session)
    const urlParams = new URLSearchParams(window.location.search);
    const hasSkipQuery = urlParams.has('skip_intro');
    const hasBladeSkip = introEl.dataset.skip === 'true';
    const hasSessionSeen = !isStandalone && sessionStorage.getItem('fruit_math_intro_seen') === 'true';
    const shouldSkip = !isStandalone && (hasSkipQuery || hasBladeSkip || hasSessionSeen);

    if (hasSkipQuery) {
        try {
            sessionStorage.setItem('fruit_math_intro_seen', 'true');
            const cleanUrl = new URL(window.location.href);
            cleanUrl.searchParams.delete('skip_intro');
            window.history.replaceState({}, document.title, cleanUrl.pathname + (cleanUrl.search || ''));
        } catch (e) {}
    }

    // State
    let progress = 0;
    let isFinished = false;
    let popScore = 0;
    let counterInterval = null;
    let autoCountdownInterval = null;
    let soundEnabled = true;

    try {
        const stored = localStorage.getItem('streetcode-intro-sound');
        if (stored !== null) soundEnabled = stored === 'true';
    } catch (e) {}

    // Audio Engine: Marimba / Bell Synthesizer (Kids Game Harmonic Tones)
    let audioCtx = null;
    const getAudio = () => {
        if (!audioCtx) {
            const AudioClass = window.AudioContext || window.webkitAudioContext;
            if (AudioClass) audioCtx = new AudioClass();
        }
        if (audioCtx && audioCtx.state === 'suspended') {
            audioCtx.resume().catch(() => {});
        }
        return audioCtx;
    };

    // Marimba note synthesizer
    const playMarimba = (freq, duration = 0.22, gainVal = 0.24) => {
        if (!soundEnabled) return;
        try {
            const ctx = getAudio();
            if (!ctx) return;
            const now = ctx.currentTime;

            // Fundamental (sine + slight triangle overtone for warm wooden marimba ring)
            const osc1 = ctx.createOscillator();
            const osc2 = ctx.createOscillator();
            const gainNode = ctx.createGain();

            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(freq, now);

            osc2.type = 'triangle';
            osc2.frequency.setValueAtTime(freq * 2, now); // 2nd harmonic

            gainNode.gain.setValueAtTime(gainVal, now);
            gainNode.gain.exponentialRampToValueAtTime(0.0001, now + duration);

            osc1.connect(gainNode);
            osc2.connect(gainNode);
            gainNode.connect(ctx.destination);

            osc1.start(now);
            osc2.start(now);
            osc1.stop(now + duration);
            osc2.stop(now + duration);
        } catch (e) {}
    };

    // Cute squish/pop sound for fruit splatter
    const playPop = () => {
        if (!soundEnabled) return;
        try {
            const ctx = getAudio();
            if (!ctx) return;
            const now = ctx.currentTime;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'sine';
            osc.frequency.setValueAtTime(320, now);
            osc.frequency.exponentialRampToValueAtTime(980, now + 0.08);

            gain.gain.setValueAtTime(0.28, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.09);

            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(now);
            osc.stop(now + 0.09);
        } catch (e) {}
    };

    // Cheerful victory chord (C major arpeggio)
    const playVictoryFanfare = () => {
        if (!soundEnabled) return;
        const notes = [523.25, 659.25, 783.99, 1046.50, 1318.51];
        notes.forEach((n, i) => {
            setTimeout(() => playMarimba(n, 0.45, 0.3), i * 90);
        });
    };

    // Pentatonic scale frequencies for ascending counter steps
    const marimbaScale = [
        261.63, 293.66, 329.63, 392.00, 440.00, // C4, D4, E4, G4, A4
        523.25, 587.33, 659.25, 783.99, 880.00, // C5, D5, E5, G5, A5
        1046.50, 1174.66, 1318.51               // C6, D6, E6
    ];

    // Sound UI
    const updateSoundUI = () => {
        if (!soundToggle) return;
        soundToggle.innerHTML = soundEnabled ? '<span>🔊</span>' : '<span>🔇</span>';
        soundToggle.setAttribute('title', soundEnabled ? (isSw ? 'Zima Sauti' : 'Mute Sound') : (isSw ? 'Washa Sauti' : 'Unmute Sound'));
    };
    updateSoundUI();

    if (soundToggle) {
        soundToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            soundEnabled = !soundEnabled;
            try {
                localStorage.setItem('streetcode-intro-sound', String(soundEnabled));
            } catch (err) {}
            updateSoundUI();
            if (soundEnabled) playMarimba(659.25, 0.25, 0.25);
        });
    }

    // Kid-friendly loading milestones & Mascot speech updates
    const milestones = isSw ? [
        { pct: 0, status: '⚡ StreetCode inawasha injini ya mchezo...', speech: 'Mambo vipi! Mimi ni Kiko! Karibu kwenye Fruit Math! 🍎' },
        { pct: 20, status: '🍎 Inalima bustani ya maapulo na machungwa...', speech: 'Tuna maapulo na ndizi tamu sana za kuhesabu! 🍌' },
        { pct: 45, status: '🦁 Kiko anavaa viatu vya kukimbia na kofia...', speech: 'Niko tayari kukushangilia kila unapopatia! 🦁✨' },
        { pct: 68, status: '🎁 Kuficha almasi na nyota kwenye masanduku...', speech: 'Kuna masanduku ya dhahabu yaliyojaa zawadi! 🎁⭐' },
        { pct: 88, status: '🧠 Inatayarisha mafumbo ya kasi na nyota...', speech: 'Hesabu za saa na vipande zinakuja! Washa akili! 🧠' },
        { pct: 98, status: '✨ Kila kitu kimekamilika na kung\'aa...', speech: 'Hureee! Mchezo uko tayari kabisa! Bonyeza tuanze! 🚀' },
        { pct: 100, status: '🚀 TAYARI KABISA! BONYEZA KUANZA KUCHEZA!', speech: 'TWENDE TUKACHEZE SASA HIVI! 🎮🍎⭐' }
    ] : [
        { pct: 0, status: '⚡ StreetCode is starting up the game engine...', speech: 'Hey friend! I am Kiko! Welcome to Fruit Math! 🍎' },
        { pct: 20, status: '🍎 Harvesting sweet apples, bananas & oranges...', speech: 'We have juicy fruits waiting for you to count! 🍌' },
        { pct: 45, status: '🦁 Kiko the Mascot is putting on his champion hat...', speech: 'I am ready to cheer you on every single win! 🦁✨' },
        { pct: 68, status: '🎁 Packing gold chests with sparkling stars...', speech: 'Secret golden treasure chests are packed! 🎁⭐' },
        { pct: 88, status: '🧠 Preparing fun speed & fraction puzzles...', speech: 'Sharpen your brain speed! Fun challenges ahead! 🧠' },
        { pct: 98, status: '✨ Polishing world with magical fruit glitter...', speech: 'Woohoo! Everything is shining and ready to play! 🚀' },
        { pct: 100, status: '🚀 ALL READY! TAP BELOW TO START PLAYING!', speech: 'LET\'S GO PLAY RIGHT NOW! 🎮🍎⭐' }
    ];

    const getMilestone = (pct) => {
        let match = milestones[0];
        for (let m of milestones) {
            if (pct >= m.pct) match = m;
        }
        return match;
    };

    const fruitRunners = ['🍎', '🍌', '🍊', '🍓', '🍍', '🍉', '🥥', '🍏', '🍇', '⭐'];

    // Progress Updates
    const setProgress = (val) => {
        progress = Math.min(100, Math.max(0, val));
        if (percentEl) percentEl.textContent = `${Math.floor(progress)}%`;
        if (barEl) barEl.style.width = `${progress}%`;
        if (runnerEl) {
            runnerEl.style.left = `${progress}%`;
            const iconIdx = Math.floor((progress / 100) * (fruitRunners.length - 1));
            runnerEl.textContent = fruitRunners[iconIdx] || '🍎';
        }

        const m = getMilestone(progress);
        if (statusEl && statusEl.textContent !== m.status) {
            statusEl.style.opacity = '0';
            setTimeout(() => {
                statusEl.textContent = m.status;
                statusEl.style.opacity = '1';
            }, 100);
        }

        if (mascotBubbleEl && mascotBubbleEl.textContent !== m.speech) {
            mascotBubbleEl.style.transform = 'scale(0.95)';
            setTimeout(() => {
                mascotBubbleEl.textContent = m.speech;
                mascotBubbleEl.style.transform = 'scale(1)';
            }, 100);
        }
    };

    // Close and Enter Main Page
    const enterGame = () => {
        if (counterInterval) clearInterval(counterInterval);
        if (autoCountdownInterval) clearInterval(autoCountdownInterval);

        if (isStandalone) {
            window.location.href = '/?skip_intro=1';
            return;
        }

        introEl.style.transition = 'opacity 0.55s cubic-bezier(0.4, 0, 0.2, 1), transform 0.55s ease';
        introEl.style.opacity = '0';
        introEl.style.transform = 'scale(1.05)';
        introEl.style.pointerEvents = 'none';

        try {
            sessionStorage.setItem('fruit_math_intro_seen', 'true');
        } catch (e) {}

        setTimeout(() => {
            introEl.classList.add('hidden');
            introEl.style.display = 'none';
        }, 600);
    };

    // 100% Milestone Celebration
    const onComplete = () => {
        if (isFinished) return;
        isFinished = true;
        setProgress(100);

        playVictoryFanfare();

        // Canvas Confetti
        if (typeof window.launchConfetti === 'function') {
            window.launchConfetti(4000);
        } else {
            window.dispatchEvent(new CustomEvent('fx:confetti'));
        }

        // Mascot celebration dance
        if (mascotCharEl) {
            mascotCharEl.classList.add('animate-mascot-jump');
            const starEyes = mascotCharEl.querySelector('#mascot-star-eyes');
            const normalEyes = mascotCharEl.querySelector('#mascot-eyes');
            if (starEyes && normalEyes) {
                starEyes.classList.remove('hidden');
                normalEyes.classList.add('hidden');
            }
        }

        // Reveal Big 3D Play Button (User clicks manually to enter)
        if (ctaBtn) {
            ctaBtn.classList.remove('hidden');
            ctaBtn.classList.add('animate-jelly-bounce');
        }

        // Manual Click Notification: Wait for user to explicitly click
        if (autoEnterTimerEl) {
            autoEnterTimerEl.textContent = isSw
                ? '👆 Bonyeza kitufe hapo juu kuanza kucheza!'
                : '👆 Tap the button above to start playing!';
        }
    };

    // Smooth Cartoon Counter Sequence
    const startCounter = () => {
        progress = 0;
        isFinished = false;
        setProgress(0);
        if (ctaBtn) ctaBtn.classList.add('hidden');
        if (autoEnterTimerEl) autoEnterTimerEl.textContent = '';

        let step = 0;
        const totalDuration = 3600; // ~3.6s of upbeat anticipation
        const intervalTime = 36;
        const totalSteps = totalDuration / intervalTime;
        let lastToneIndex = -1;

        counterInterval = setInterval(() => {
            step++;
            const rawRatio = step / totalSteps;
            // Playful easing: fast burst, short breathing space at 50%, excited sprint to 100%
            let eased;
            if (rawRatio < 0.5) {
                eased = Math.pow(rawRatio / 0.5, 0.85) * 0.5;
            } else {
                eased = 0.5 + Math.pow((rawRatio - 0.5) / 0.5, 1.15) * 0.5;
            }

            const currentVal = Math.min(100, Math.round(eased * 100));
            setProgress(currentVal);

            // Play marimba notes along the scale
            const toneIdx = Math.floor((currentVal / 100) * (marimbaScale.length - 1));
            if (toneIdx !== lastToneIndex && currentVal < 100) {
                lastToneIndex = toneIdx;
                playMarimba(marimbaScale[toneIdx], 0.16, 0.2);
            }

            if (step >= totalSteps || currentVal >= 100) {
                clearInterval(counterInterval);
                onComplete();
            }
        }, intervalTime);
    };

    // Canvas Juice Splatter & Sparkle Particles System
    const splatters = [];
    const initJuiceCanvas = () => {
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        let w = (canvas.width = window.innerWidth);
        let h = (canvas.height = window.innerHeight);

        window.addEventListener('resize', () => {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
        });

        // Spawn colorful juice splatter at (x, y)
        const spawnSplatter = (x, y, fruitColor = null) => {
            const fruitPalette = ['#ef4444', '#f59e0b', '#10b981', '#fbbf24', '#ec4899', '#8b5cf6'];
            const mainColor = fruitColor || fruitPalette[Math.floor(Math.random() * fruitPalette.length)];

            for (let i = 0; i < 18; i++) {
                const angle = Math.random() * Math.PI * 2;
                const speed = Math.random() * 8 + 2;
                splatters.push({
                    x,
                    y,
                    vx: Math.cos(angle) * speed,
                    vy: Math.sin(angle) * speed - 1.5,
                    size: Math.random() * 9 + 4,
                    color: mainColor,
                    alpha: 1,
                    decay: Math.random() * 0.035 + 0.02
                });
            }
        };

        // Render loop
        const render = () => {
            ctx.clearRect(0, 0, w, h);

            for (let i = splatters.length - 1; i >= 0; i--) {
                const p = splatters[i];
                p.x += p.vx;
                p.y += p.vy;
                p.vy += 0.28; // Gravity
                p.vx *= 0.95;
                p.size *= 0.97;
                p.alpha -= p.decay;

                if (p.alpha <= 0 || p.size <= 0.5) {
                    splatters.splice(i, 1);
                    continue;
                }

                ctx.save();
                ctx.globalAlpha = p.alpha;
                ctx.fillStyle = p.color;
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }

            requestAnimationFrame(render);
        };
        render();

        // Screen tap / click juice splash
        introEl.addEventListener('pointerdown', (e) => {
            if (e.target.closest('button, a')) return;
            spawnSplatter(e.clientX, e.clientY);
            playPop();
        }, { passive: true });

        // Expose to window for fruit popper
        window.spawnFruitJuice = spawnSplatter;
    };

    // Mascot Click Interaction (Jump & Laugh)
    if (mascotCharEl) {
        mascotCharEl.addEventListener('click', (e) => {
            e.stopPropagation();
            playPop();
            playMarimba(880, 0.28, 0.3);

            mascotCharEl.classList.remove('animate-mascot-jump');
            void mascotCharEl.offsetWidth; // trigger reflow
            mascotCharEl.classList.add('animate-mascot-jump');

            if (mascotBubbleEl) {
                mascotBubbleEl.textContent = isSw ? 'Hahaha! Mimi ni Kiko, twende tukapige hesabu! 🦁✨' : 'Haha! I am Kiko! Let us crush these math puzzles! 🦁✨';
            }

            const rect = mascotCharEl.getBoundingClientRect();
            if (window.spawnFruitJuice) {
                window.spawnFruitJuice(rect.left + rect.width / 2, rect.top + rect.height / 2, '#f59e0b');
            }
        });
    }

    // Interactive Floating Fruit Popping (Extra Kid Mini-Game)
    const initFruitPopping = () => {
        const fruits = introEl.querySelectorAll('.intro-pop-fruit');
        fruits.forEach((f) => {
            f.addEventListener('click', (e) => {
                e.stopPropagation();
                popScore += 1;
                if (popCounterEl) popCounterEl.textContent = String(popScore);

                playPop();
                playMarimba(marimbaScale[popScore % marimbaScale.length] * 1.5, 0.2, 0.25);

                const rect = f.getBoundingClientRect();
                const fruitColor = f.dataset.color || '#ef4444';
                if (window.spawnFruitJuice) {
                    window.spawnFruitJuice(rect.left + rect.width / 2, rect.top + rect.height / 2, fruitColor);
                }

                // Squash & burst
                f.style.transform = 'scale(1.6) rotate(20deg)';
                f.style.opacity = '0';
                f.style.pointerEvents = 'none';

                // Floating Star Score Floater
                const floater = document.createElement('div');
                floater.textContent = '+5 ⭐ BINGWA!';
                floater.style.position = 'fixed';
                floater.style.left = `${rect.left}px`;
                floater.style.top = `${rect.top}px`;
                floater.style.color = '#fef08a';
                floater.style.textShadow = '0 3px 0 #b45309, 0 6px 12px rgba(0,0,0,0.6)';
                floater.style.fontWeight = '900';
                floater.style.fontSize = '22px';
                floater.style.pointerEvents = 'none';
                floater.style.zIndex = '9999';
                floater.style.transition = 'all 0.65s cubic-bezier(0.18, 0.89, 0.32, 1.28)';
                introEl.appendChild(floater);

                requestAnimationFrame(() => {
                    floater.style.transform = 'translateY(-40px) scale(1.25)';
                    floater.style.opacity = '0';
                });
                setTimeout(() => floater.remove(), 700);

                // Respawn with fun wobble
                setTimeout(() => {
                    f.style.transform = 'scale(1) rotate(0deg)';
                    f.style.opacity = '1';
                    f.style.pointerEvents = 'auto';
                }, 1200);
            });
        });
    };

    // Listeners
    if (skipBtn) skipBtn.addEventListener('click', enterGame);
    if (ctaBtn) ctaBtn.addEventListener('click', enterGame);

    // Replay capability
    window.showStreetCodeIntro = () => {
        if (counterInterval) clearInterval(counterInterval);
        if (autoCountdownInterval) clearInterval(autoCountdownInterval);

        introEl.classList.remove('hidden');
        introEl.style.display = 'flex';
        introEl.style.opacity = '1';
        introEl.style.transform = 'scale(1)';
        introEl.style.pointerEvents = 'auto';

        initJuiceCanvas();
        startCounter();
    };

    // If skip flag is active, do not run intro or play audio automatically
    if (shouldSkip) {
        introEl.classList.add('hidden');
        introEl.style.display = 'none';
        return;
    }

    // Run systems
    initJuiceCanvas();
    initFruitPopping();
    startCounter();
}

document.addEventListener('DOMContentLoaded', () => {
    initStreetCodeIntro();
});

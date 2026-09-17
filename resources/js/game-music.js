// One player per mounted game; Livewire question updates keep the same audio.
let player = null;
const preferenceKey = 'fruit-math-music-muted';
function mount(element) {
    const audio = element.querySelector('audio');
    const button = element.querySelector('[data-music-toggle]');
    let muted = false;
    let disposed = false;
    try { muted = localStorage.getItem(preferenceKey) === 'true'; } catch {}
    audio.volume = 0.3;
    const active = () => !disposed && element.closest('[data-game-active="true"]') && !document.hidden;
    const label = () => {
        const playing = !audio.paused && !muted;
        const text = playing ? '♫ Mute music' : muted ? '♫ Music off' : '♫ Play music';
        if (button.textContent !== text) button.textContent = text;
        button.setAttribute('aria-label', playing ? 'Mute background music' : 'Play background music');
        button.setAttribute('aria-pressed', String(playing));
    };
    const play = () => {
        if (!active() || muted) return;
        audio.play().then(() => {
            if (!active() || muted) audio.pause();
            label();
        }).catch(label); // Browser may require the first tap before allowing sound.
    };
    const gesture = event => { if (!button.contains(event.target)) play(); };
    const toggle = () => {
        muted = !audio.paused && !muted;
        try { localStorage.setItem(preferenceKey, String(muted)); } catch {}
        if (muted) audio.pause(); else play();
        label();
    };
    const visibility = () => { if (document.hidden) audio.pause(); else play(); label(); };
    button.addEventListener('click', toggle);
    document.addEventListener('pointerdown', gesture);
    document.addEventListener('keydown', gesture);
    document.addEventListener('visibilitychange', visibility);
    audio.addEventListener('playing', label);
    audio.addEventListener('pause', label);
    label(); play();
    return { element, destroy() {
        disposed = true;
        audio.pause(); audio.currentTime = 0;
        button.removeEventListener('click', toggle);
        document.removeEventListener('pointerdown', gesture);
        document.removeEventListener('keydown', gesture);
        document.removeEventListener('visibilitychange', visibility);
        audio.removeEventListener('playing', label);
        audio.removeEventListener('pause', label);
    }};
}
function sync() {
    const element = document.querySelector('[data-game-active="true"] [data-game-music]');
    if (player && player.element !== element) { player.destroy(); player = null; }
    if (element && !player) player = mount(element);
    document.querySelectorAll('[data-game-active="false"] [data-game-music]').forEach(el => { el.hidden = true; });
}
function init() {
    sync();
    new MutationObserver(sync).observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['data-game-active'] });
}
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
else init();
window.addEventListener('pagehide', () => { if (player) player.destroy(); player = null; });
window.addEventListener('pageshow', sync);
document.addEventListener('livewire:navigating', () => { if (player) player.destroy(); player = null; });

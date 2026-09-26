let installPrompt;
const isStandalone = () => window.matchMedia('(display-mode: standalone)').matches || navigator.standalone === true;

function refreshInstallButton() {
    const button = document.querySelector('[data-pwa-install]');
    if (button) button.hidden = !installPrompt || isStandalone();
}

window.addEventListener('beforeinstallprompt', event => {
    event.preventDefault();
    installPrompt = event;
    refreshInstallButton();
});

document.addEventListener('click', async event => {
    if (!event.target.closest('[data-pwa-install]') || !installPrompt) return;
    const prompt = installPrompt;
    installPrompt = null;
    refreshInstallButton();
    try {
        await prompt.prompt();
        await prompt.userChoice;
    } catch (error) {
        console.warn('Fruit Math installation was unavailable.', error);
    }
});

window.addEventListener('appinstalled', () => {
    installPrompt = null;
    refreshInstallButton();
});
document.addEventListener('livewire:navigated', refreshInstallButton);

// Register only with compiled assets; Vite development should not install a worker.
if (import.meta.env.PROD && window.isSecureContext && 'serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js', { scope: '/', updateViaCache: 'none' })
        .catch(error => console.warn('Fruit Math offline support could not start.', error));
}

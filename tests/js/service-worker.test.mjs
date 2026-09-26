import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import vm from 'node:vm';

function worker(online = false) {
    const handlers = {};
    const stored = new Map();
    const removed = [];
    const context = {
        URL, Response,
        self: {
            location: { origin: 'https://fruit.test' },
            addEventListener: (name, handler) => { handlers[name] = handler; },
            skipWaiting: async () => {},
            clients: { claim: async () => {} },
        },
        caches: {
            open: async () => ({
                add: async path => stored.set(path, new Response('Offline notice')),
                match: async path => stored.get(path)?.clone(),
            }),
            keys: async () => ['fruit-math-public-v4-1', 'other-app', 'fruit-math-public-v5'],
            delete: async key => removed.push(key),
        },
        fetch: async () => {
            if (online) return new Response('Private account page');
            throw new TypeError('Offline');
        },
    };
    vm.runInNewContext(readFileSync(new URL('../../public/service-worker.js', import.meta.url), 'utf8'), context);
    return { handlers, stored, removed };
}

test('installation caches only the public notice and activation preserves unrelated caches', async () => {
    const { handlers, stored, removed } = worker();
    let pending;
    handlers.install({ waitUntil: promise => { pending = promise; } });
    await pending;
    assert.deepEqual([...stored.keys()], ['/offline.html']);
    handlers.activate({ waitUntil: promise => { pending = promise; } });
    await pending;
    assert.deepEqual(removed, ['fruit-math-public-v4-1']);
});

test('navigation uses network online and public fallback offline without caching account pages', async () => {
    for (const online of [true, false]) {
        const { handlers, stored } = worker(online);
        stored.set('/offline.html', new Response('Offline notice'));
        let response;
        handlers.fetch({
            request: { method: 'GET', mode: 'navigate', url: 'https://fruit.test/dashboard' },
            respondWith: promise => { response = promise; },
        });
        assert.equal(await (await response).text(), online ? 'Private account page' : 'Offline notice');
        assert.deepEqual([...stored.keys()], ['/offline.html']);
    }
});

test('POSTs, API requests and cross-origin navigation bypass the worker', () => {
    const { handlers } = worker();
    for (const request of [
        { method: 'POST', mode: 'navigate', url: 'https://fruit.test/login' },
        { method: 'GET', mode: 'cors', url: 'https://fruit.test/livewire/update' },
        { method: 'GET', mode: 'navigate', url: 'https://other.test/' },
    ]) handlers.fetch({ request, respondWith: () => assert.fail('Unexpected interception') });
});

test('missing offline cache still returns a valid response', async () => {
    const { handlers } = worker();
    let response;
    handlers.fetch({
        request: { method: 'GET', mode: 'navigate', url: 'https://fruit.test/' },
        respondWith: promise => { response = promise; },
    });
    assert.equal((await response).status, 503);
});

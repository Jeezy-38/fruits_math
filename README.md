# Fruit Math V4.2 — parent and child learning

Laravel 12 + Livewire 3 mathematics app with parent and admin accounts, child profiles, 11 game types, worlds and admin curriculum tools.

## Run locally

Requires PHP 8.2+ with SQLite, Composer, and a browser. Compiled frontend assets are included in the repaired ZIP, so Node is only needed to change frontend assets.

```sh
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Open the address printed by the last command. On Windows, create an empty `database/database.sqlite` file using your file manager instead of `touch`.

Local demo accounts (created only in local/testing environments):

| Role | Email | Password |
| --- | --- | --- |
| Parent | parent@fruitmath.test | password |
| Admin | admin@fruitmath.test | password |

Use normal login. Optional one-click demo login requires `APP_ENV=local` and `DEMO_ENABLED=true`. It is disabled by default. Re-seeding preserves existing demo passwords and child progress.

## Learning flow

1. Parent: register or log in → Play → add/select a child.
2. Child: continue the adventure or choose an unlocked level from the world map.
3. Complete the game to save first-answer accuracy, stars, XP and daily activity.
4. Parent: review the child’s learning progress from the dashboard.
5. Admin: view platform totals and manage curriculum topics/lessons. Curriculum authoring is retained; adventure levels currently use their existing difficulty settings.

## Removed in V4.2

Teacher registration/login, teacher dashboards, classroom creation/joining, assignments and teacher metrics are no longer available. Registration always creates a parent account; submitted teacher/admin roles are rejected. Existing teacher sessions are signed out and existing teacher accounts cannot log in.

Historical teacher/classroom/assignment database records and migrations are retained for safe upgrades, but have no app routes or screens. No existing account or learning history is deleted. Removed component files must also be removed when upgrading an older installation; use this complete source folder rather than copying only changed files.

## Core repairs retained from V4.1

- Restored missing web entry point, controller base class, layout component and runtime directories.
- Repaired question options so the correct answer always appears exactly once.
- Equal-area shaded fraction bars and clock hands driven by the generated time.
- Server-owned question state and scoring. Answer keys are absent from Livewire public state.
- Unique first-answer records, guarded advancement, transactional completion and single reward per first successful level completion.
- Failed games award no XP and unlock no levels. Stars only increase by improvements to a level's best result.
- Role/ownership checks, login throttling, registration session renewal, child creation and persistent locale selection.
- Removed caching of authenticated pages. The service worker only caches a public offline notice.
- Local compiled CSS/JS replace the Tailwind CDN. PHP and frontend dependency lock files are included.

## Validation

```sh
php vendor/bin/phpunit
php artisan view:cache
```

The regression suite covers game routes, authentication, child creation, curriculum rules, answer choices, role/ownership restrictions, locked game state, duplicate rewards, removed teacher routes, rejected teacher registration/login and revocation of legacy teacher sessions.

To rebuild the frontend, use Node 22+ and pnpm 11:

```sh
pnpm install --frozen-lockfile
pnpm run build
```

Alternatively, `npm install` then `npm run build` works with the package manifest, but does not use the included pnpm lock file.

## Existing V4 installations

Back up your database, preserve your existing `.env`, install dependencies and run `php artisan migrate`. Do not use `migrate:fresh` on existing data. Finish or restart any old in-progress games: the new server-owned question state is only available for new sessions. Old completed results remain intact. Build or copy the included `public/build` assets, then run `php artisan optimize:clear`.

## Current limits

- A browser refresh starts a new game; resuming unfinished sessions is not implemented.
- Internet/server access is required for gameplay. The offline page is a reconnect notice, not offline play or offline answer syncing.
- English/Kiswahili locale plumbing and selected question translations work; full interface translation remains unfinished.
- Achievement definitions remain a foundation; automatic badge awards, adaptive hints and multiplayer are not implemented.
- Custom number ranges apply to counting, arithmetic, comparison and word problems; multiplication/division additionally use selected tables. Other games use difficulty.
- Automated PHP/Livewire tests and asset compilation passed. Browser visual verification was blocked by the browser tool's unavailable security-policy check.

For deployment, serve only `public/`, set `APP_ENV=production` and `APP_DEBUG=false`, use your own accounts and HTTPS, and keep `storage/` and `bootstrap/cache/` writable. Demo credentials from any existing local database must not be carried into a public deployment. No public deployment is included in this repair.

## Background music

An original, locally generated instrumental loop plays during games at low volume. Use the music button to mute/unmute; the preference is remembered in this browser. If autoplay is blocked, tap the game or Play music to begin. Music pauses while the tab is hidden and stops on completion or leaving the game. No external audio service is used.

Answers are saved to SQLite on submission; final scores, progress and rewards are committed when Finish is pressed. The default local database is `database/database.sqlite`.

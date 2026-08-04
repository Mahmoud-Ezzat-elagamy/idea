# Repository Agent Guidelines

## Tech Stack & Versions
- **PHP**: 8.4 (`laravel/framework` v13)
- **Frontend**: React 19, Inertia v3 (`@inertiajs/react`), Tailwind CSS v4, Vite 8, TypeScript
- **Testing**: Pest v5 (`php artisan test --compact`)
- **Static Analysis & Formatting**: Pint (`vendor/bin/pint`), PHPStan (`phpstan analyse`), Rector (`vendor/bin/rector`), ESLint, Prettier, TypeScript (`tsc --noEmit`)

## Developer Commands
- **Run Tests**: `php artisan test --compact`
- **PHP Linting**: `composer lint` (fix) or `composer lint:check` (check)
- **PHP Static Analysis**: `composer types:check` (`phpstan analyse`)
- **JS/TS Type Check**: `npm run types:check` (`tsc --noEmit`)
- **JS Linting**: `npm run lint` (fix) or `npm run lint:check` (check)
- **Full CI Check**: `composer ci:check`
- **Development**: `composer run dev` (runs artisan serve, queue listener, and Vite concurrently)

## Conventions & Gotchas
- **Migrations**: Use string column names with `foreignId('user_id')` or `foreignIdFor(User::class)` explicitly (do NOT pass model class directly into `foreignId()`).
- **PHP Style**: Always use curly braces for control structures; use constructor property promotion; add explicit return type declarations and type hints.
- **Inertia v3**: Components reside in `resources/js/pages`. Use `Inertia::render()`. Axios is removed; use built-in XHR client or fetch. `Inertia::lazy()` replaced by `Inertia::optional()`.
- **Wayfinder**: Import TypeScript helper routes/actions from `@/actions/` or `@/routes/`.
- **Formatting**: Run `vendor/bin/pint --format agent` or `composer lint` after modifying PHP files.

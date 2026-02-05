# Actualización a Laravel 10

## Cambios aplicados

### 1. composer.json
- **PHP:** `^8.1` (Laravel 10 requiere PHP 8.1.0+)
- **laravel/framework:** `^10.0`
- **laravel/tinker:** `^2.8`
- **nunomaduro/collision:** `^7.0`
- **spatie/laravel-ignition:** `^2.0`
- **phpunit/phpunit:** `^10.0`
- **yajra/laravel-datatables-oracle:** `^10.0` (compatible con L10)
- **barryvdh/laravel-debugbar:** `^3.12`
- **laravel/sail:** `^1.18`
- **mockery/mockery:** `^1.6`
- **minimum-stability:** `stable`

### 2. Pest
- No se usa Pest en el proyecto; no aplica actualización.

### 3. Tipos de retorno (L10)
- **Middleware:** `Authenticate::redirectTo(Request $request): ?string`, `handle(): mixed` en CheckRole, LocaleMiddleware, RedirectIfAuthenticated; `TrustHosts::hosts(): array`.
- **Controladores:** LoginController (login, logout, showLoginForm, msgError, remember), DashboardController (métodos principales), CategoriesController (store, update, destroy, list) con `RedirectResponse`, `View`, `JsonResponse`, etc.
- **Console:** `Kernel::schedule(): void`, `commands(): void`; `CloseSessions::handle(): int` con `Command::SUCCESS`/`Command::FAILURE`.
- **Providers:** `AppServiceProvider`, `AuthServiceProvider`, `RouteServiceProvider`, `EventServiceProvider` con `register(): void` y `boot(): void`.

### 4. AuthServiceProvider
- Eliminada la llamada a `$this->registerPolicies()`; en Laravel 10 se invoca automáticamente.

### 5. Kernel HTTP
- `$routeMiddleware` renombrado a `$middlewareAliases` (convención L10).

### 6. PHPUnit
- Eliminado `processUncoveredFiles="true"` de `<coverage>` en `phpunit.xml` (requerido para PHPUnit 10).

### 7. Validación y obsoletos
- No se usan `Redirect::home`, `Bus::dispatchNow` ni reglas de validación con closure `$fail` que cambien en L10. Los modelos ya usan `$casts` (no `$dates`).

---

## Pasos que debes ejecutar

1. **PHP 8.1+**  
   Asegúrate de usar PHP 8.1 o superior (Laragon: menú PHP → versión).

2. **Actualizar dependencias**
   ```bash
   composer update
   ```

3. **Limpiar cachés**
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan optimize:clear
   ```

4. **Guía oficial**  
   [Laravel 10 Upgrade Guide](https://laravel.com/docs/10.x/upgrade)

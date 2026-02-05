# Resumen: requisitos para pasar de Laravel 8 a Laravel 9

## Cambios ya aplicados en este proyecto (guía oficial)

- **composer.json:** `laravel/framework` ^9.0, `nunomaduro/collision` ^6.1, PHP ^8.0.2, y resto de dependencias actualizadas.
- **CORS y TrustProxies:** Uso de `HandleCors` y `TrustProxies` del core (eliminados paquetes `fruitcake/laravel-cors` y `fideloper/proxy`).
- **Modelos:** Añadido `$casts` para fechas en `Order` y `Expense` (Laravel 9 recomienda `$casts` en lugar de `$dates`). No se usaba `$dates` en ningún modelo.
- **Flysystem 3:** En `config/filesystems.php`: variable de entorno `FILESYSTEM_DISK` (con fallback a `FILESYSTEM_DRIVER`), y opción `'throw' => false` en discos `local` y `public` (en L9 los fallos de escritura no lanzan excepción por defecto).
- **Directorio de idiomas:** En `AppServiceProvider::boot()` se llama a `$this->app->useLangPath(resource_path('lang'))` para seguir usando `resources/lang` como en Laravel 8.
- **Exception Handler:** No se define `ignore()` en el Handler; no requiere cambios.

---

## 1. PHP

| Actual (Laravel 8) | Requerido (Laravel 9) |
|-------------------|------------------------|
| `^7.3\|^8.0`      | **PHP 8.0.2 o superior** |

**Acción:** En Laragon, usar PHP 8.0, 8.1 o 8.2. Comprobar con `php -v` en la terminal de Laragon.

---

## 2. Dependencias en `composer.json`

### Require (producción)

| Paquete | Tu versión actual | Cambio para Laravel 9 |
|---------|-------------------|------------------------|
| `php` | `^7.3\|^8.0` | `^8.0.2` |
| `laravel/framework` | `^8.40` | `^9.0` |
| `laravel/tinker` | `^2.5` | `^2.7` (compatible con L9) |
| `fideloper/proxy` | `^4.4` | **Quitar** (Laravel 9 lo incluye en el core) |
| `fruitcake/laravel-cors` | `^2.0` | **Quitar** (CORS ya viene en Laravel; usar `config/cors.php`) |
| `laravel/ui` | `^3.3` | `^4.0` (o mantener `^3.3`, compatible con L9) |
| `doctrine/dbal` | `^3.3` | Mantener `^3.3` |
| `guzzlehttp/guzzle` | `^7.0.1` | Mantener |
| `yajra/laravel-datatables-oracle` | `^9.18` | Mantener `^9.18` (compatible con L9) |

### Require-dev

| Paquete | Tu versión actual | Cambio para Laravel 9 |
|---------|-------------------|------------------------|
| `facade/ignition` | `^2.5` | **Sustituir por** `spatie/laravel-ignition: ^1.0` |
| `nunomaduro/collision` | `^5.0` | `^6.1` |
| `barryvdh/laravel-debugbar` | `^3.6` | `^3.7` (compatible L9) |
| `laravel/sail` | `^1.0.1` | `^1.0.4` o superior |
| `fakerphp/faker` | `^1.9.1` | Mantener |
| `mockery/mockery` | `^1.4.2` | Mantener |
| `phpunit/phpunit` | `^9.3.3` | `^9.5.10` (Laravel 9 usa PHPUnit 9.5+) |

---

## 3. Orden recomendado

1. **PHP:** Asegurar PHP ≥ 8.0.2 en Laragon y en el servidor.
2. **Editar `composer.json`** con las versiones de la tabla anterior (ya aplicadas en el archivo).
3. Ejecutar:
   ```bash
   composer update
   ```
4. Si usabas `fruitcake/laravel-cors`, revisar que las rutas/API usen la configuración en `config/cors.php` (Laravel ya incluye CORS).
5. Si usabas `fideloper/proxy`, el middleware `TrustProxies` de Laravel sigue siendo el de `App\Http\Middleware\TrustProxies`; no hace falta el paquete.
6. Revisar la guía oficial: [Laravel 9 Upgrade Guide](https://laravel.com/docs/9.x/upgrade) por si hay cambios en tu código (por ejemplo `lang/`, reglas de validación, etc.).

---

## 4. Cómo comprobar tu versión de PHP

En la terminal de Laragon (o donde tengas PHP en el PATH):

```bash
php -v
```

Debe ser al menos `PHP 8.0.2`.

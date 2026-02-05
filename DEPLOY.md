# Despliegue (Toffle)

## Por qué no cargan los estilos/JS en el servidor

La carpeta `public/build` (donde Vite genera CSS y JS) está en `.gitignore`, así que **no se sube al repositorio**. En el servidor hay que generarla después de cada despliegue.

## Pasos en el servidor después de hacer pull

1. **Instalar dependencias y generar assets**
   ```bash
   npm ci
   npm run build
   ```
   Esto crea `public/build` con el manifest y los archivos compilados que usa `@vite()`.

2. **Configurar `.env` en producción**
   - `APP_URL` debe ser la URL real del sitio, por ejemplo: `https://tudominio.com`
   - Si aun así no cargan los assets (por ejemplo con proxy o CDN), define también:
     ```env
     ASSET_URL=https://tudominio.com
     ```

3. **(Opcional) Limpiar caché**
   ```bash
   php artisan config:clear
   php artisan view:clear
   ```

## Resumen

| Dónde        | Qué hacer |
|-------------|-----------|
| **Servidor** | Después de `git pull`: `npm ci && npm run build` |
| **.env**    | `APP_URL` = URL real del sitio; si hace falta, `ASSET_URL` igual |

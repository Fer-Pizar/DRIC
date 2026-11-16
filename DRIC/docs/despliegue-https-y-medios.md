# HTTPS y archivos del CMS

## Railway

En el servicio Laravel `DRIC`, definir:

```text
APP_URL=https://dric-admin.up.railway.app
FRONTEND_URL=https://dric-website.up.railway.app
TRUSTED_PROXIES=REMOTE_ADDR
```

`TRUSTED_PROXIES` permite que Laravel reconozca el protocolo HTTPS comunicado por el proxy inmediato. Sin esta configuración, los formularios y redirecciones pueden apuntar a HTTP. El frontend y la base de datos no necesitan esta variable.

Montar el volumen de archivos del servicio Laravel en `/app/storage/app/public`. El enlace público debe apuntar de `/app/public/storage` a `/app/storage/app/public`. La base de datos conserva rutas y metadatos de los archivos; el volumen conserva los bytes de imágenes y PDF. Los archivos recuperados de un respaldo se copian al volumen preservando sus rutas, sin reemplazar archivos ya existentes.

## Servidor institucional

Configurar `APP_URL` y `FRONTEND_URL` con las direcciones HTTPS institucionales. Si hay un proxy inverso, configurar `TRUSTED_PROXIES` con su IP o rango conocido. `REMOTE_ADDR` sirve cuando solo se acepta tráfico del proxy inmediato. Si Laravel recibe HTTPS directamente, dejar `TRUSTED_PROXIES` sin definir.

El directorio `storage/app/public` debe estar en almacenamiento persistente y contar con permisos de escritura para PHP. Crear el enlace público con `php artisan storage:link` si no existe. Migrar el contenido del volumen de Railway al directorio persistente institucional antes del cambio de servidor.

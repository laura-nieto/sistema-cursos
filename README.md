# Sistema de Cursos

Se trata de una aplicación web de uso interno. El propósito de la aplicación es registrar las academias con sus respectivas sucursales, las cuales dictan los cursos de educación vial en la Ciudad Autónoma de Buenos Aires. Cada curso se orienta a un tipo de medio de transporte específico y es requisito para tramitar la licencia de conducir de dicho tipo.


## Instalación

Una vez clonado el proyecto

```bash
  cd cursos
  composer install
```

Una vez que se realice la instalación se debe realizar la configuración de la aplicación.
Se debe realizar una copia del .env.example por .env

```bash
   php artisan key:generate
```

A partir de ahí se modifica el .env y se configura con la información de la base de datos.

```bash
   php artisan migrate --seed
```

## Support

Ante cualquier duda, comunicarse vía email a m.nieto@buenosaires.gob.ar.
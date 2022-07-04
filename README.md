# Sistema de Cursos

Se trata de una aplicación web de uso interno. El propósito de la aplicación es registrar las academias con sus respectivas sucursales, las cuales dictan los cursos de educación vial en la Ciudad Autónoma de Buenos Aires. Cada curso se orienta a un tipo de medio de transporte específico y es requisito para tramitar la licencia de conducir de dicho tipo.


## Instalación

Una vez clonado el proyecto, ingresar a la carpeta y realizar la copia del archivo .env.example a .env

```bash
  cd cursos
  cp .env.example .env
  composer install
```

Una vez que se realice la instalación se debe realizar el siguiente comando

```bash
   php artisan key:generate
```

A partir de ahí se modifica el .env y se configura con la información de la base de datos.

| Variable          | Valor                                                                |
| ----------------- | ------------------------------------------------------------------ |
| DB_CONNECTION     | pgsql |
| DB_HOST           | IP_BBDD |
| DB_PORT           | 5432 |
| DB_DATABASE       | nombre_BBDD |
| DB_USERNAME       | nombre_usuario |
| DB_PASSWORD       | password_usuario |


Por último se corren las migraciones:

```bash
   php artisan migrate --seed
```

## Support

Ante cualquier duda, comunicarse vía email a m.nieto@buenosaires.gob.ar.
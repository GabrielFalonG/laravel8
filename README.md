Se recomienda utilizar Laravel Sail para correr el proyecto en un entorno local.

Pasos:

1) Navegar hasta el directorio donde se clone el proyecto.

    En windows: correr ./vendor/bin/sail up -d 
    (Dentro de una distribución instalada de Linux con WSL2)

    Para Mac o Linux seguir los pasos de la documentación de Laravel 8

2) Correr las migraciones: 
    
    ./vendor/bin/sail artisan migrate

3) Correr el seeder de Usuarios: 

    ./vendor/bin/sail artisan db:seed

4) Linkear la carpeta Storage con public:  

    ./vendor/bin/sail artisan storage:link

Todos los comandos pueden ser corridos dentro del bash del contenedor
Ingresando al mismo con el sig comando: 

    ./vendor/bin/sail artisan bash ó ./vendor/bin/sail artisan shell

Esto permite interactuar directamente con el CLI de Laravel sin la necesidad 
de anteponer  ./vendor/bin/sail artisan {comando} para ejecutarlos
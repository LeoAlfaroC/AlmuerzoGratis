# Almuerzo Gratis
Prueba técnica

# Configuración de entorno de desarrollo

## Requisitos:
- docker (Probado con versión 25.0.3)

## Ejecución
- `git clone git@github.com:LeoAlfaroC/AlmuerzoGratis.git`
- `cd AlmuerzoGratis`
- `docker compose build`
- `docker compose up`
  - Se puede incluir el flag `-d` para dejar corriendo los contenedores en segundo plano
    - En caso de hacerlo, se puede correr `docker compose stop` para detenerlos
- Presionar `Control/Command + C` para detener los contendedores

## Configuración de microservicios:
Se utilizó SQLite para las bases de datos, por lo que es necesario correr
los siguientes comandos para generarlas:
- touch api/database/database.sqlite
- touch cocina/database/database.sqlite
- touch bodega/database/database.sqlite

Luego, se debe correr migraciones y seeders en cada uno de los
tres componentes (API, Cocina, y Bodega):
- php artisan migrate:fresh --seed
 

# Arquitectura
La solución se conforma de los siguientes seis componentes:

- Frontend:
  - Se comunica solo con los componentes API y Websockets
  - Construido con Nuxt.js, Vuetify, y Laravel Echo
- API:
  - Recibe los requests del Frontend y se comunica con los demás componentes
  - Construido con Laravel
  - Almacena los usuarios en su propia BD
- Cocina:
  - Se comunica con todos los componentes excepto Frontend
  - Construido con Laravel
  - Almacena las recetas y los ingredientes en su propia BD
- Bodega:
  - Se comunica con todos los componentes excepto Frontend
  - Construido con Laravel
  - Almacena los ingredientes, el inventario, y el registro de compras en su propia BD
- Websockets:
  - Recibe eventos de los componentes de backend (API, Cocina, y Bodega)
  - Envía estos eventos a cliente autenticados y autorizados (Frontend)
  - Utiliza Soketi
- Redis:
  - Recibe y despacha mensajes de los componentes de backend (API, Cocina, y Bodega)

La comunicación entre componentes de backend se realiza a través de Redis
con el patrón Pub/Sub y el uso de colas de Laravel. Por lo tanto, es necesario
mantener los siguientes comandos, en sus respectivos componentes,
corriendo continuamente (con Supervisor, por ejemplo):

- API:
  - php artisan queue:work
- Cocina:
  - php artisan queue:work
  - php artisan redis:subscribe
- Bodega:
  - php artisan queue:work
  - php artisan redis:subscribe

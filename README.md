# Almuerzo Gratis
Prueba técnica para alegra.com

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
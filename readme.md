## Ejecuta el proyecto en local

### Windows

Para ejecutar el proyecto en Windows, utiliza el siguiente comando en PowerShell:

```powershell
$Env:DOCKER_BUILDKIT = "0"
$Env:COMPOSE_DOCKER_CLI_BUILD = "0"
docker-compose build --no-cache
docker-compose up -d
```
```
docker compose up --build -d ; if($?) {docker image prune}
```

### Linux

Para ejecutar el proyecto en Linux, utiliza el siguiente comando en la terminal:

```bash
docker compose up --build -d && docker image prune
```

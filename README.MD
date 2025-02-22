# LAMP with Tailwind boilerplate

## local setup

run the below command to create and start the containers in detached mode.

```
docker-compose up -d
```

## Production setup
When running on production with docker you must use the docker-compose.prod.yaml file. You can run the below command to start the containers in detached mode.

```bash
docker compose -f docker-compose.prod.yaml up -d
```

## Docker services

### web-server

A php image built using the Docker official image from [DockerHub](https://hub.docker.com/_/php). Defined in the php/php.Dockerfile. Can be accessed from http://localhost

### mysql-server

a mysql image built from DockerHub. MySQL root password can be found in the .env file.

### adminer

an adminer image built from the DockerHub image. Can be accessed from http://localhost:8080

### .env

your mysql root password must be set using a .env file.

```
MYSQL_ROOT_PASSWORD = "your root password"
```

## Local development

### Shell into the web-server container
You can shell into the web-server container using the following command

```bash
docker compose exec web-server bash
```
the above command will open a bash shell in the `web-server` container.

### Composer
To run `composer install` from the web-server container use the following command

```bash
docker compose exec web-server composer install
```
the above command executes the `composer install` command from the `web-server` container.

### bundle and build css
Required node modules can be installed using `npm install`. You can use the following docker compose exec command to install the modules.

```bash
docker compose exec web-server npm install
```

to watch and build css run `npm run dev`. You can use the following docker compose exec command to run the command in the `web-server` container.

```bash
docker compose exec web-server npm run dev
```

### ini
- `ini/upload.ini` can be used to control php upload settings
- `ini/xdebug.ini` can be used to control xdebug settings

### apache
The `apache/000-default.conf` file can be used to modify the default vhost settings for the apache server.

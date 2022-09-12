# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework, with full [HTTP/2](https://symfony.com/doc/current/weblink.html), HTTP/3 and HTTPS support.

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

Fill up env for FTP server:
``APP_FTP_HOST,
APP_FTP_LOGIN,
APP_FTP_PASSWORD,
APP_FTP_PORT,
APP_FTP_PATH,
APP_FTP_PATH_TEST``

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.
6. Run `docker exec -ti container_name sh` to go into container
7. Dir `var/images` is mounted move there some pictures to resize
8. Run command `bin/console image:resize path/to/img width hight server`. For now FTP supported. You can use option `--seve-local` to store resized img on local directory `var/resized`

Enjoy :) 
## Credits

Created by [Kévin Dunglas](https://dunglas.fr), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).

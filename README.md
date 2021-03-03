<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300"></a></p>

## Containerize your Laravel Application with Docker Compose

Clone the repository and make your Laravel project with the latest features of the framework.

PHP 7.4.1 and mysql 5.7 versions.

I recommended to install Workbench to work with databases.
https://www.mysql.com/products/workbench/

## Init the Project

To get started, make sure you have [Docker installed](https://docs.docker.com/) on your system and [Docker Compose](https://docs.docker.com/compose/install/), and then clone this repository.

Clone this repository.
```bash
git@github.com:asiermusa/repository-name.git
```

Run this command to create containers and initialize the Project.
```bash
docker-compose up -d
```

Run the console of your app.
```bash
docker exec -it 'your-laravel-container-name' bash
```

Install all the Composer dependencies.
```bash
composer install
```

Execute any php artisan command.
```bash
php artisan migrate
```

Edit `.env` file wit the docker container credentials.
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_docker
DB_USERNAME=root
DB_PASSWORD=
```

## Ports

Ports used in the project:
| Software | Port |
|-------------- | -------------- |
| **app** | 8080 |
| **mysql** | 3306 |


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

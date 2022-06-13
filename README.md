# IWA Application

Built with [Laravel Lumen](https://lumen.laravel.com/).
## Requirements

- Internet connection

## Recommended

- Docker

This application consists of two parts, a backend and a frontend, which both need to run for this application to work.

[Instructions for running the backend](#installing-and-running-the-backend)

[Instructions for running the front-end](#installing-and-running-the-front-end)

# Installing and running the backend

The recommended way to use this program is with docker, which makes it very easy to run. Go through the following instructions to finish the installation and to start the application.

`docker-compose up`

When everything is running open a new terminal. **Leave the old one open**.

Now run the following two commands:

`docker-compose exec php artisan migrate`

`docker-compose exec php artisan db:seed`

## Installation without docker

First you should install all the dependencies by executing `composer install` from the main folder.

### Environment variables
Next you'll want to copy the *.env.example* file to the same folder and name it `.env`
In this file you should set your database environment variables such as

`DB_DATABASE=iwa`         The database to be used for the Laravel application

`DB_USERNAME=homestead`   The username used for database authentication

`DB_PASSWORD=secret`      The password used for database authentication

### Create database
After correcting these values you should create the database by using a GUI such as MySQL workbench or using the SQL
command `CREATE DATABASE iwa`

### Start migrations
Run the `php artisan migrate` command which will create the needed tables in the database.
Afterwards, run the `php artisan db:seed` command to fill the database with the necessary data.

### Running the project
The project can now be used with the following command `php artisan serve` which will give you the API URL to be used in the front-end.

## Installing and running the front-end
To run the front-end read the [front-end instructions](Frontend/README.md).

### Adding station measurements
Weather data / measurements will not be generated with the `php artisan db:seed` command and should be generated with the WeatherGen application.
The URL used to send these generated measurements is */stations/sendWeatherData*.
You will need to turn on HTTP logging in the WeatherGen application.

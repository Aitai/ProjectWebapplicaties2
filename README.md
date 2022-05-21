# IWA Applicatie

Built with [Laravel Lumen](https://lumen.laravel.com/).
## Requirements

- Internet connection

## Recommended

- Docker

# Installation

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
Before running the migrations you should import the *ProjectSemester2Stations.sql* file in the newly created database.
This file will create all the stations and countries used in the application.

After doing this you can run the `php artisan migrate` command which will create the rest of the tables in the database.
To fill these tables with some default data you can run the `php artisan db:seed` command.

### Running the project
The project can now be used with the following command `php artisan serve` which will give you the API URL to be used in the front-end.

## Front-end
To run the front-end read the *Front-end/README.md* file for instructions.

### Adding station measurements
Weather data / measurements will not be generated with the `php artisan db:seed` command and should be generated with the WeatherGen application.
The URL used to send these generated measurements is */stations/sendWeatherData*.
You will need to turn on HTTP logging.

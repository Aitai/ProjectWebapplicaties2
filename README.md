# Society of Protection of Birds Application

Built with [Laravel Lumen](https://lumen.laravel.com/).
## Requirements

- Internet connection

This application consists of two parts, a backend and a frontend, which both need to run for this application to work.

[Instructions for running the backend](#installing-and-running-the-backend)

[Instructions for running the front-end](#installing-and-running-the-front-end)
# Installing and running the backend

To follow these instructions, you should change directory to `Backend/`. When that is done you should install all the dependencies by executing `composer install`.

### Environment variables
Next you'll want to copy the *.env.example* file to the same folder and name it `.env`.
In this file you should set your database environment variables such as

`DB_DATABASE=weathapp`         The database to be used for the Laravel application

`DB_USERNAME=sopob`   The username used for database authentication

`DB_PASSWORD=secret`      The password used for database authentication

Please also change `JWT_KEY` and `APP_KEY` in production!

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

# Extra information

## API documentation
API documentation can be found at the path */docs* using the backend domain.

## Adding station measurements
Weather data / measurements will not be generated with the `php artisan db:seed` command and should be generated with the WeatherGen application if debugging the application.
The path used to send these generated measurements is */stations/sendWeatherData* using the backend domain.
You will need to turn on HTTP logging in the WeatherGen application.

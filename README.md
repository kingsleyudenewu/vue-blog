# Simple Blog Application
A simple application using Laravel 9 and Vue3 with Vuex


<p>
  <blockquote style="color:red">
    **Please follow the steps below to setup the application on your system** 
  </blockquote>
</p>  

## Required Versions
-PHP 8.0
Node version 16

## Installation Steps

- On the **Subscriber**, run ```php artisan serve --port=8000``` to start it.
- Clone project
- Run ```composer install``` for the main project
- cd to the vue folder and run ```npm install && npm run dev```
- Rename .env.example to .env
- Create you database and set dbname, username and password on the new .env file
- Copy the square one url on .env.example to .env ```SQUARE_ONE_URL```
- Generate your laravel key : ```php artisan key:generate```
- Run ```php artisan migrate```
- Run ```php artisan db:seed``` to generate dummy data for user
- To run your <b>TEST</b> go to your console and type ```./vendor/bin/phpunit``` 

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

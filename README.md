# Notes:
* make sure you edit your .env file (if you don't have it copy `.env.example` to `.env`) to configure your db name, username and password


# API Creation process:
* Make sure you install all the dependencies on your local machine using `composer install`
* Create a controller: `php artisan make:controller Api/<ControllerName> --model=<ModelName> --api`
* Add a new route to your controller under `/routes/api.php`:
`Route::apiResource("<RouteName>", ControllerName::class);`
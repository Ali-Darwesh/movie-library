## Movie Library

Movie Library is a software to manage  create, show,update and delete movies,with ability to   paginate,sort and filter results.
### Githup Link

- [githup link](https://github.com/Ali-Darwesh/movie-library).

## Create Laravel project with 
-composer create-project --prefer-dist laravel/laravel movie-library
- git init
- git add .
- git commit -m ""
- php artisan install:api
- php artisan make:model Movie -mcr --api  
- php artisan make:model Rating -mcr --api  
- php artisan make:controller UserController
- php artisan migrate  
- php artisan make:seeder ResetAutoIncrementSeeder
- php artisan migrate:fresh  
## Models
All of them contain fillable array,ralations
- Movie Model scopes(paginateMovies,sort,Filter)


## Services
I make Services for create ,update and delete operations
- MovieService
- RatingService
- UserService

## Traits
I make a Trait to Reset Auto Increment ID

## Exceptions
I use try-catch to deal with exceptions and use  HTTP status codes to explain the error

## Database
there is three tables :
- movies
- ratnig FK(user_id,movie_id)
- users
rating related to movies with one to one relation
rating related to users with one to many relation
### seeder
to Reset Auto Increment ID on data base migration
## Controllers
In controllers I use all above to keep it in better look and clean code
## API Testing with Postman

To test the API endpoints, you can use the Postman collection provided in the project. Find it at `resources/docs/postman/endpointTask3.postman_collection.json`.

## License
### Githup Link

- [githup link](https://github.com/Ali-Darwesh/movie-library).

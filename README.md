# kontinentalist-rest-api

Technical assessment for Kontinentalist.

The API server is built with Laravel, and the frontend is built with Vue.js and integrated with Inertia.js. 

## User Guide
If you do not wish to host the server locally, you may view the stories and send requests to my API server hosted
at http://146.190.193.16:8000 instead.

## Developer Guide
This section will guide you through the steps to get both the API and frontend servers up and running.

### Pre-requisites
You should have the following installed on your machine before you proceed:
- [*PHP*](https://www.php.net/manual/en/install.php) 8.2.3 or above
- [*Composer*](https://getcomposer.org/download/) 2.5.4 or above
- [*SQLite*](https://www.sqlite.org/download.html) 3.41.1 or above
- [*npm*](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) 9.4.0 or above

### Setup
1. Clone the repository.
```
git clone https://github.com/jontmy/kontinentalist-assessment.git
```
2. Navigate to the project directory.
```
cd kontinentalist-assessment
```
3. Install the dependencies.
```
composer install
npm install
```
4. Copy the `.env.example` file to `.env`.
```
cp .env.example .env
```
5. Generate the application key.
```
php artisan key:generate
```
6. Create the database for the posts. You will be prompted whether to create the SQLite database
   file. Enter `yes` to proceed.
```
php artisan migrate
# If the database driver cannot be found and you're on Ubuntu, run the following command:
sudo apt install php-sqlite3
```
7. Start the API server.
```
php artisan serve
```
8. **In another terminal**, start the frontend server.
```
npm run dev
```
9. Open your browser and navigate to http://localhost:8000 to view the stories on the frontend.
10. Queries can also be made to the API server at http://localhost:8000/; see the API reference below.

## API Reference
The following endpoints are defined in `app/Http/Controllers/ApiController.php`.

### `GET /api/posts`
Returns a list of all posts as a JSON array.

### `GET /api/posts/{id}`
Returns the post with the specified `id` as a JSON object.

If the post with the specified `id` does not exist, the API will return with the HTTP status code 404.

### `POST /api/posts`
Creates a new post with the specified `title` and `content`.

Both fields are required. If either field is missing, the API will return with the HTTP status code 422.

### `PATCH /api/posts/{id}`
Updates the post with the specified `id` with the specified `title` and `content`.

Either field is optional. If both fields are missing, the API will return with the HTTP status code 422.
If the post with the specified `id` does not exist, the API will return with the HTTP status code 404.

### `DELETE /api/posts/{id}`
Deletes the post with the specified `id`.

If the post with the specified `id` does not exist, the API will return with the HTTP status code 404.

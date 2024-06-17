# Books API

## Description

Books API offering CRUD actions on users, authors, and books.

The API offers:

- JWT authentication using the sanctum package.
- Login.
- CRUD of users, authors, and books.
- Requests validated by token and authorized only for users with an administrator role.
- Listener located in app/Listeners/UpdateBookCount.php that when a book is registered in the BookController store method, the BookProcesed event located in app/Events/BookProcesed.php invokes the ProcessBookCountUpdate job located in app/Jobs/ ProcessBookCountUpdate .php which updates the number of books in the authors table represented by the published_books field, this same number of books is also updated using the same BookProcessed event in the destroy method of the BookController to maintain consistency when deleting a book as well.
- Jobs are processed by a queue that is configured with redis in the books-queue container in the docker-compose.yml file.
- ExportController that is used to export data from the authors and books tables to an xlsx file, for this it uses the maatwebsite/excel package.

## Deploy

The API is deployed and available at https://emmanuelcodinghub.com/books-api/, 
you can use username admin with password admin7891 to log in and send other requests to API.

## Documentation

### API
The API documentation: 
https://www.postman.com/molero3111/workspace/books-api/environment/9720967-9785b84a-6c5f-437a-bf82-51cfae827fbe

### Database
You may find ER diagram of the database in database/ER_diagram/books_ER_diagram.pdf

##  Runtimes, engines, tools and requirements

- **Language**: PHP
- **Framework**: Laravel
- **Packages:**: 
    - laravel/sanctum (For JWT authentication)
    - maatwebsite/excel (For xlsx file generation)
- **Database**: PostgresSQL
- **Cache**: Redis (For job queue)

## Run Project locally

1. Clone the repository:

```bash
git clone https://github.com/molero3111/books_api.git
```

2. cd into books_api repository:

```bash
cd books_api/
```

3. Switch to staging branch:
```bash
git checkout staging
```
You may stay on development, but staging branch will have the most stable version.

4. Create .env:

```bash
cp .env.example .env
```

5. Create books_api_network:

```bash
docker network create books_api_network
```

6. Build and run docker containers:

```bash
docker compose -p local up --build
```

The books-queue service should have executed all needed migrations and seeded the db as well.
In the case there was an error with it, you may access the books-api container with command: 
```bash
docker exec -it books-api /bin/bash
```

Once in it, you can execute this command: 
```bash
php artisan key:generate && php artisan migrate && php artisan db:seed && php artisan queue:work
```
That will manually run the migrations, seeding and queue.

7. Set up your first admin user:

Access the books-api container with command:
```bash
docker exec -it books-api /bin/bash
```
The project has a laravel custom command you can use to create admin user, execute: 
```bash
php artisan create:admin-user {name} {usernmae} {email} {password}
```
For example: 
```bash
php artisan create:admin-user john john23 john234@example.com test23
```

With this user you will be able to log in to the API, and even create other users with admin access if you wish so.

## Test project

After following these steps you can access home page at http://localhost:8000. 
In case you get permission errors on storage or bootstrap directories, access the books-api
container with command:

```bash
docker exec -it books-api /bin/bash
```

Once in it, change owner: 
```bash
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
```

### Optional

If you would like to execute php artisan commands, you need to install packages on your host machine, follow these steps: 

1. Install packages:

```bash
composer install
```

In case composer install is failing, it could be because of the maatweb/excel package.
It requires gd and ext-zip extensions to be installed, you may install them with this command:

```bash
sudo apt-get install php8.2-zip php8.2-gd
```

For further testing and usage, follow documentation to send requests to the API.

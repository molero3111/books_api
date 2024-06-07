# Books API

## Description

Books API offering CRUD actions on users, authors, and books.

##  Runtimes, engines, tools and requirements

- **Language**: PHP
- **Framework**: Laravel
- **Packages:**: 
    - laravel/sanctum (For JWT authentication)
    - maatwebsite/excel (For xlsx file generation)
- **Database**: PostgreSQL
- **Cache**: Redis (For job queue)

## Run Project locally

1. Clone the repository:

```bash
git clone https://github.com/molero3111/books_api.git
```

2. cd into notes api repository:

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

7. Create books_api_network:

```bash
docker network create books_api_network
```

8. Build and run docker containers:

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
php artisan migrate && php artisan db:seed && php artisan queue:work
```
That will manually run the migrations, seeding and queue.

9. Set up your first admin user:

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

2. Generate app key:

```bash
php artisan key:generate
```

For futher testing and usage, follow documentation to send requests to the API.

## Documentation

### API
The API documentation was done with postman, you may find it here: 
https://www.postman.com/molero3111/workspace/books-api/documentation/9720967-ecb6b09c-1a10-41f0-9c1e-ddc57924699e

### Database
You may find ER diagram of the database in database/ER_diagram/books_ER_diagram.pdf

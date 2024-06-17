<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

    </head>
    <body>
        <h1>Books API</h1>
        <h2>Documentation</h2>
        <p>
        <a href="https://www.postman.com/molero3111/workspace/books-api/environment/9720967-9785b84a-6c5f-437a-bf82-51cfae827fbe">
            https://www.postman.com/molero3111/workspace/books-api/environment/9720967-9785b84a-6c5f-437a-bf82-51cfae827fbe</a>
        </p>
        <hr/>
        <h2>Features</h2>
        <ul>
            <li>JWT authentication using the sanctum package.</li>
            <li>Login.</li>
            <li>CRUD of users, authors, and books.</li>
            <li>Requests validated by token and authorized only for users with an administrator role.</li>
            <li>Listener located in app/Listeners/UpdateBookCount.php that when a book is registered in the BookController store method, 
            the BookProcesed event located in app/Events/BookProcesed.php invokes the ProcessBookCountUpdate job located in app/Jobs/ ProcessBookCountUpdate.php
            which updates the number of books in the authors table represented by the published_books field, this same number of books is also updated
            using the same BookProcessed event in the destroy method of the BookController to maintain consistency when deleting a book as well.</li>
            <li>Jobs are processed by a queue that is configured with redis in the books-queue container in the docker-compose.yml file.</li>
            <li>ExportController that is used to export data from the authors and books tables to an xlsx file, for this it uses the maatwebsite/excel package.</li>
        </ul>
    </body>
</html>

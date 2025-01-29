<h1>
    Test task for ApriCode Company
</h1>

<h2> How to start? </h2>
    
Clone git repository
```
git clone https://github.com/tinkyrain/apricode-test-task.git
```

<p>In the root of the project, create a .env file</p>

<p>.env File example:</p>

```
DATABASE_PROVIDER=pgsql
DATABASE_HOST=localhost
DATABASE_NAME=apricode-test-task
DATABASE_USERNAME=postgres
DATABASE_PASSWORD=password
```

<h2>
Before connecting to the DB, do not forget to create the database itself. The database schema is located in the root of the project
</h2>
<br>

Install composer dependencies
```
composer install
```

Go to the folder with index.php and run the project
```
cd public
```

```
php -S localhost:8888
```
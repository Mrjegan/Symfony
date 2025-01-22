Symfony CRUD Application with JWT Authentication
=====================================
PHP Version: 8.2
Symfony 7.0.10

Open Windows PowerShell
Install Scoop
	iwr -useb get.scoop.sh | iex

Install Symfony
    scoop install symfony-cli

Environment Variables Edit
Add : C:\Users\YourUsername\scoop\shims

1. XAMPP:
    Start Apache and MySQL.
    Enable : Sodium extension in (php.ini)

2. Go to App Directory and Install Dependencies:
    composer install

3. I have already configured the database name in .env file. You can change the database name if you want to use a different database name.
    CREATE DATABASE symfony_db

4. Then table migration use
    php bin/console doctrine:schema:update --force

5. Run the application using
    symfony server:start

-------- Register user and login using JWT token --------

POST /api/register register user.
    {
        "username": "TestApa1",
        "email": "TestApp1@123",
        "roles": ["TestApp"],
        "password": "Test@123"
    }

POST /api/login_check jwt token for the user.
    {
        "username": "TestApa1",
        "password": "Test@123"
    }

-------- Crud operation api using JWT token --------

POST /api/products creates a product.
    {
        "name": "PS5",
        "description": "Best for gaming",
        "price": 40000
    }

GET /api/products fetches all products.

GET /api/products/{id} fetches a single product.

PUT /api/products/{id} updates a product.
    {
        "name": "TestABC",
        "description": "TestABC",
        "price": 100
    }

DELETE /api/products/{id} deletes a product.

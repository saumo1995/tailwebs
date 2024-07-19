# tailwebs

**Environment:**
 1. PHP : 8.2
 2. Laravel : 11.9
 
 **Setup**
 1. Need to create a database by this command  : CREATE DATABASE tailwebs;
 2. Download the code.
 3. Setup Database connection in .env file like:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=tailwebs
        DB_USERNAME=root
        DB_PASSWORD=
 4. Run these command in project command line:
    1. composer update
    2. php artisan config:clear
    3. php artisan config:cache
    4. php artisan migrate
    5. php artisan db:seed
    6. php artisan storgae:link
 5. After run above command , to run this project by this command :
    php artisan serve
 6. Login Credentials:
    Emails : teacher@tailwebs.com
    Password : 123456

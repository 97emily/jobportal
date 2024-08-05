# Recruitment Portal.
This Recruitment Portal is a web application built with Laravel 11, designed to streamline the recruitment process for companies and job seekers. Companies can post job listings, and candidates can apply directly through the portal. The application features user-friendly interfaces and robust functionality for managing job postings, applications, and user profiles.

## System Features.
User Authentication: Secure user registration and login functionality.

Role-Based Access Control: Separate roles for Admin, employer, and Human Resource each with distinct permissions.

Job Listings Management: Employers can create, update, and delete job postings.

Application Management: Employers can view and manage applications from job seekers.

Admin Dashboard: Comprehensive dashboard for managing users, job listings, and system settings.

Notifications: Email and in-app notifications for important actions, such as application submissions and job status updates.

## Technology Stack.

Backend: Laravel 11 (PHP).

Database: PostgreSQL.

Frontend: HTML, CSS, JavaScript, node.js.

Tools: Composer, Node.js, npm.

## Requirements.

PHP: >= 8.2

Composer: Latest version.

Node.js & npm: Latest versions.

Database: PostgreSQL, MYSQL.

## Browser Support.

Apple Safari

Google Chrome

Microsoft Edge

Mozilla Firefox

## Project Installation.

### Step 1:
In the project’s root directory, copy the .env.example into .env file.
### Step 2: Install Project Dependencies.
Download the project’s dependencies
```composer install```
### Step 3: Set the APP_KEY value in your .env file
```php artisan key:generate --ansi```
### Step 4:  Configure your database
Now that you have set up your project, you probably want to store some data in a database.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flexadmin_db
DB_USERNAME=root
DB_PASSWORD=
```
### Step 5: Running the Migration
``` php artisan migrate ```
### Step 6: Running the seeders
You may execute the db:seed Artisan command to seed your database.
```php artisan db:seed```
### Step 7: Start the local server by executing
```php artisan serve```
### Step 8: Running Vite
Install the node Packages.
```npm install```

After installing node packages success. Run
```npm run dev```


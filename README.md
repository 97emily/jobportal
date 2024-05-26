## About FlexAdmin: Laravel 10, CRUD, Authentication, Admin Template
https://www.flexadmin.io/documentation/introduction/

```diff
! Please give me a star. I appreciate about that. Thank you so much!
```

## Requirement:
- PHP version >= 8.2
- Nodejs version: >=20
- MySql/MariaDB

- Make sure .env file is existing in the project’s root directory
- Make sure the Database environment variables are correct


## Download

https://www.flexadmin.io/laravel-flexadmin-free/


## Installation

https://www.flexadmin.io/documentation/installation/


## Quick Installation (For MacOS or Linux)

```
sh install.sh
```

## Step by Step:

Following this document

https://www.flexadmin.io/documentation/installation/


## Run 

```
php artisan migrate
php artisan db:seed

```

## Sets the APP_KEY value in your .env file

```
php artisan key:generate --ansi
```


## Advance

``````
php artisan make:component YourComponent
php artisan migrate:reset
``````

## File upload
Laravel storage filesystem is so unique. Any file upload will be stored in the storage/app/public directory. To make it accessible in public directory, things you need to do is to the create symlink by running the command:

```
php artisan storage:link

```

This command will symlinked storage/app/public to public/storage
Ensure APP_URL env variable is correct

## UI
npm run dev


## Create new Adnin User
```
php artisan admin:create
```

## Code-style

The project uses [laravel/pint](https://github.com/laravel/pint) to enforce code-style. To run it and fix any issues, use below command:

```
./vendor/bin/pint
```

## Create new Model
```
php artisan make:model SomeModel -c

```

## Create admin module

```
generate:admin-model SomeModel
```

## Create new admin component

```
php artisan make:component Admin/YourComponentName
```


### FlexAdmin Generator Commands

```
php artisan flex.scaffold:controller YourModel
php artisan flex:model YourModel
php artisan flex:scaffold YourModel
php artisan flex:rollback YourModel scaffold
```


## Screenshots

Dashboard | Add New Product  | Update record
--- | --- |---
<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/dashboard.jpg" width="400">|<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/create-product.png" width="400">|<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/update-category.png" width="400">


Product List | Multiple Upload  | Single Upload
--- | --- |---
<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/fx-screen1.png" width="400">|<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/upload-product.png" width="400">|<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/single-upload.png" width="400">


Manage Role | Update Role  | Login
--- | --- |---
<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/fx-auth.png" width="400">|<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/auth.png" width="400">|<img src="https://github.com/flexadminio/laravel-admin-crud/blob/master/screenshots/login.png" width="400">
# jobportal
# jobportal
# jobportal

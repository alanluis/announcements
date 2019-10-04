# Announcements APP with API, MySQL and Vue.js

> Laravel 6 Announcements API whit MySQL database, PHPUnitTests and a Vue.js frontend

## Quick Start

``` bash
# Install Dependencies
composer install

# Create a .env file and config the database settings
cp .env.example .env

# Run Migrations
php artisan migrate

# Execute Seeds
php artisan db:seed

# Generate encryption jey 
php artisan key:generate

# Js Dependences
npm install

# Watch assets files
npm run watch

# Serve your application
php artisan serve

# Run Unit Tests
# Edit phpunit.xml and change the ENV DB_DATABASE variable, I.e: <env name="DB_DATABASE" value="announcements_test"/>
php vendor/bin/phpunit
```

## Endpoints

### List Messages
``` bash
GET api/messages
```
### Get a Message
``` bash
GET api/messages/{id}
```

### Delete message
``` bash
DELETE api/messages/{id}
```

### Add Message
``` bash
POST api/messages
subject
content
start_date
expiration_date
```

### Update message
``` bash
PUT api/messages/{message_id}
subject
content
start_date
expiration_date
```

## App Info

### Author

Alan Oliveira

### Version

1.0.0

### License

This project is licensed under the MIT License
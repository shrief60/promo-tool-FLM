#!/bin/bash

mkdir -p /var/www/html/storage
mkdir -p /var/www/html/storage/app
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/logs

chmod 777 /var/www/html/storage -R
chmod 777 /var/www/html/storage/app -R
chmod 777 /var/www/html/storage/logs -R
chmod 777 /var/www/html/storage/framework -R
chmod 777 /var/www/html/storage/framework/cache -R
chmod 777 /var/www/html/storage/framework/sessions -R
chmod 777 /var/www/html/storage/framework/views -R
chmod 777 /var/www/html/storage/framework/logs -R
chmod 777 /var/www/html/bootstrap/cache -R
chmod 777 /var/www/html/data -R

chown www-data:www-data /var/www/html/storage/logs/* -R
chown www-data:www-data /var/www/html/storage/logs -R

php artisan migrate
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan DB:seed
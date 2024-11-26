#!/usr/bin/bash

cp ./.env.example ./.env

composer install

php artisan key:generate
php artisan storage:link

pnpm install
pnpm run build

touch ./database/database.sqlite
php artisan migrate:fresh --seed >/dev/null 2>&1 || php artisan migrate --seed

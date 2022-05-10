#!/bin/bash
cp .env.example .env
sed -i 's/DB_HOST=127.0.0.1/DB_HOST=codevilafood-db/g' .env
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=codevilafood/g' .env
sed -i 's/DB_USERNAME=root/DB_USERNAME=root/g' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=12345678/g' .env
composer install
#npm install
php artisan key:generate
php artisan config:cache
php artisan storage:link
sleep 10
php artisan migrate --path=database/migrations/tables
php artisan migrate --path=database/migrations/constraints
#php artisan migrate --path=database/migrations/procedures
php artisan db:seed
npm run dev 1>/dev/null 2>/dev/null
php artisan serve --host=0.0.0.0 --port=3000
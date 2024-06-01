echo "Installing FlexAdmin"
cp .env.example .env
composer install
php artisan key:generate --ansi
php artisan migrate
php artisan db:seed
npm install

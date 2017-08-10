php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan clear-compiled
php artisan cache:clear
find /storage/framework/sessions -type f -exec rm {} +
rm -rf bash.exe.stackdump npm-debug.log storage/logs/laravel.log composer.lock public/storage

bash ./zip.bash
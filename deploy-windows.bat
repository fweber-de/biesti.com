git pull
php app\console doctrine:schema:update --force
php app\console cache:clear --env=prod --no-debug
bower install
composer install
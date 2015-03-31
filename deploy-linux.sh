git pull
php app/console doctrine:schema:update --force
php app/console cache:clear --env=prod --no-debug
bower install
composer.phar install
cd ..
chmod 777 -R fweber.info

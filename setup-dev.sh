# install composer
echo "# Installing composer"
curl -s https://getcomposer.org/installer | php

echo "# Installing composer dependencies for phpunit"
cd tests
php ../composer.phar install --dev
cd ../

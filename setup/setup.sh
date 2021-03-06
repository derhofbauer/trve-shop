#!/usr/bin/env bash

apt update && apt install -y libpq-dev git unzip

docker-php-ext-install mysqli

docker-php-ext-install pdo pdo_pgsql

a2enmod rewrite

if [ ! -f /usr/local/bin/composer ]; then
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer
    php -r "unlink('composer-setup.php');"
fi

composer install

chmod 777 -R *

composer migration-fresh
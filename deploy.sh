#!/bin/bash

php app/check.php

export SYMFONY_ENV=prod

composer install --no-dev --optimize-autoloader

bower install

php app/console doctrine:schema:create
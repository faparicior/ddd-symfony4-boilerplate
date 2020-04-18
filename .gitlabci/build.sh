#!/bin/bash

composer install

export APP_ENV=test
./bin/simple-phpunit

bin/console --env=behat doctrine:database:create
bin/console --env=behat doctrine:migrations:migrate --no-interaction

export APP_ENV=behat
./bin/behat

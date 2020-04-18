#!/bin/bash

composer install
bin/console --env=behat doctrine:database:create
bin/console --env=behat doctrine:migrations:migrate --no-interaction

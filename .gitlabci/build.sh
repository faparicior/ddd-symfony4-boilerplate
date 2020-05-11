#!/bin/bash

composer install

bin/console --env=test doctrine:database:create
bin/console --env=test doctrine:migrations:migrate --no-interaction

#!/bin/bash

export APP_ENV=test

ls /var/www/html
ls /var/www/html/public

./node_modules/.bin/cypress run --headless --spec "cypress/integration/Users/User.js"

#export APP_ENV=behat
#./bin/behat

#!/bin/bash

export APP_ENV=test

./node_modules/.bin/cypress run --headless --spec "cypress/integration/Users/User.js"

#export APP_ENV=behat
#./bin/behat

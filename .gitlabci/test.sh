#!/bin/bash

export APP_ENV=test
./bin/simple-phpunit --config phpunit.xml --coverage-html build/coverage-report --log-junit build/logs/junit.xml --coverage-clover build/logs/clover.xml --coverage-text --colors=never

./node_modules/.bin/cypress run --headless --spec "cypress/integration/Users/User.js"
#export APP_ENV=behat
#./bin/behat

cd doc/hugo
../bin/hugo

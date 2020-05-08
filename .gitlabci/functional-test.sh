#!/bin/bash

export APP_ENV=test

echo "directory"
pwd

cp docker/gitlab-ci/httpd.conf /etc/apache2/sites-enabled/000-default.conf
cp -R /builds/fapariciorteam/ddd-symfony4-boilerplate /var/www/html

cd /var/www/html
npm install

./node_modules/.bin/cypress run --headless --spec "cypress/integration/Users/User.js"

#export APP_ENV=behat
#./bin/behat

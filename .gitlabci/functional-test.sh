#!/bin/bash

export APP_ENV=test

echo "# directory"
pwd

cp docker/gitlab-ci/httpd.conf /etc/apache2/sites-enabled/000-default.conf
cp /builds/fapariciorteam/ddd-symfony4-boilerplate/.env /var/www/html
cp -R /builds/fapariciorteam/ddd-symfony4-boilerplate/* /var/www/html
echo "# apache"
apachectl restart
apachectl status
curl 127.0.0.1

#cd /var/www/html
#rm -rf node_modules/cypress
#npm install
#
#./node_modules/.bin/cypress run --headless --spec "cypress/integration/Users/User.js"

#export APP_ENV=behat
#./bin/behat

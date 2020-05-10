#!/bin/bash

#export APP_ENV=test

cp docker/gitlab-ci/httpd.conf /etc/apache2/sites-enabled/000-default.conf
cp /builds/fapariciorteam/ddd-symfony4-boilerplate/.env /var/www/html
cp -R /builds/fapariciorteam/ddd-symfony4-boilerplate/* /var/www/html
chown -R www-data:www-data /var/www/html
echo "# apache"
apachectl restart

#cd /var/www/html
rm -rf node_modules/cypress
npm install

npm run testgitlab
#./node_modules/.bin/cypress run --headless --spec "cypress/integration/Users/User.js"
#cd cypress/results
#npx marge mochawesome.json

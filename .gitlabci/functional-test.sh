#!/bin/bash

cp docker/gitlab-ci/httpd.conf /etc/apache2/sites-enabled/000-default.conf
cp /builds/fapariciorteam/ddd-symfony4-boilerplate/.env.dist /var/www/html/.env
sed -i 's/SENTRY_DSN_/'$SENTRY_DSN'/g' /var/www/html/.env > /var/www/html/.env
sed -i 's/ROLLBAR_TOKEN_/'$ROLLBAR_TOKEN'/g' /var/www/html/.env > /var/www/html/.env
sed -i 's/LOGGY_TOKEN_/'$LOGGY_TOKEN'/g' /var/www/html/.env > /var/www/html/.env
cp -R /builds/fapariciorteam/ddd-symfony4-boilerplate/* /var/www/html
chown -R www-data:www-data /var/www/html
echo "# apache"
apachectl restart

rm -rf node_modules/cypress
npm install

npm run testgitlab

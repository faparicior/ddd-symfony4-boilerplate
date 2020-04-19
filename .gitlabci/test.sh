#!/bin/bash

export APP_ENV=test
./bin/simple-phpunit --config phpunit.xml --coverage-html build/coverage-report --log-junit build/junit.xml --coverage-clover build/clover.xml

export APP_ENV=behat
./bin/behat


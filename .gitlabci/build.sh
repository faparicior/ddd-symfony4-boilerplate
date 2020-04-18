#!/bin/bash

export APP_ENV=test

./bin/simple-phpunit

export APP_ENV=behat

./bin/behat

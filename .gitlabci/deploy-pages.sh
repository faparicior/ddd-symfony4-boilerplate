#!/bin/bash

rm public/*
mv doc/hugo/public/{*,.[!.]*} public
mkdir public/coverage
mv build/coverage-report/{*,.[!.]*} public/coverage
mkdir public/functional-tests
mv cypress/reports/mochareports/* public/functional-tests

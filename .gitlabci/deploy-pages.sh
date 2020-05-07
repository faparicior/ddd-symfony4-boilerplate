#!/bin/bash

rm public/*
mkdir public/coverage
mv build/coverage-report/{*,.[!.]*} public/coverage
mv doc/hugo/public public

#!/bin/bash

rm public/*
mv doc/hugo/public .
mkdir public/coverage
mv build/coverage-report/{*,.[!.]*} public/coverage

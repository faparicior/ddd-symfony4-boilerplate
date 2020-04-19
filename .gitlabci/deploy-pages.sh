#!/bin/bash

cd ..
rm public/*
mv build/coverage-report/{*,.[!.]*} public/

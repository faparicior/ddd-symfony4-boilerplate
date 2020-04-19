#!/bin/bash

pwd
rm ../public/*
mv ../build/coverage-report/{*,.[!.]*} ../public/

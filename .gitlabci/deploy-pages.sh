#!/bin/bash

ls -al
ls -al public
ls -al build

rm public/*
mv build/coverage-report/{*,.[!.]*} public/

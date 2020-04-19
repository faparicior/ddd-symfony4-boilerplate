#!/bin/bash

rm public/*
mv build/coverage-report/{*,.[!.]*} public/

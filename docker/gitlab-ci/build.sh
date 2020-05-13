#!/usr/bin/env bash

#docker build . -t webapp_gitlab-ci
docker build -t registry.gitlab.com/fapariciorteam/ddd-symfony4-boilerplate .
docker push registry.gitlab.com/fapariciorteam/ddd-symfony4-boilerplate
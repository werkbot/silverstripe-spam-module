#!/bin/bash

# Sync main and develop with remote
#
# Run with:
# sh sync-branches-with-remote.sh

git checkout main
git pull
git checkout develop
git pull

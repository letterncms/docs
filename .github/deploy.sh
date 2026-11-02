#!/usr/bin/env bash
#
# Puts main live on the server, in the site's folder given as the first argument. The deploy
# workflow runs it there over SSH; to deploy by hand: ssh <server> bash -s -- <folder> < .github/deploy.sh
#
# What the admin saved on the server into tracked files (the company's details in a global) is
# carried across. If main changed the same lines, nothing moves and the deploy fails.

set -euo pipefail
cd "$HOME/$1"

# Without its database a site would make itself an empty one and publish that.
if [ ! -f storage/installed.json ]; then
  echo "The site in $1 isn't installed. Run php cms install there first." >&2
  exit 1
fi

git fetch --quiet origin main
before="$(git rev-parse HEAD)"
kept=
if ! git diff --quiet; then
  git stash push --quiet --message deploy
  kept=1
fi
git reset --quiet --hard FETCH_HEAD
if [ -n "$kept" ] && ! git stash pop --quiet; then
  git reset --quiet --hard "$before"
  git stash pop --quiet
  echo "What was saved on the server conflicts with main. Nothing was deployed." >&2
  exit 1
fi
echo "Deploying $(git log -1 --format='%h %s')"

# The newest releases the site allows: it runs what everyone else installs.
composer update --no-dev --no-interaction --no-progress --optimize-autoloader
php cms sync --no-interaction
php cms build

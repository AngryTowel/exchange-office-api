#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")"

git pull --ff-only
export IMAGE_TAG="$(git rev-parse --short HEAD)"

docker compose -f compose.prod.yml build --pull
docker compose -f compose.prod.yml up -d --wait
docker image prune -af --filter "until=168h"
docker compose -f compose.prod.yml ps

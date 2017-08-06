#!/usr/bin/env bash
drush --root=$(pwd)/web si glamanate --yes
drush --root=$(pwd)/web en -y migrate migrate_drupal migrate_drupal_ui
drush --root=$(pwd)/web en -y migrate_upgrade
drush --root=$(pwd)/web cr
PORT=$(docker inspect --format='{{(index (index .NetworkSettings.Ports "3306/tcp") 0).HostPort}}' glamanate_mariadb_1)
drush migrate-upgrade --legacy-db-url=mysql://root:root,@mysql.dev:${PORT}/glamanate_d7 --legacy-root=http://glamanate.com --root=$(pwd)/web

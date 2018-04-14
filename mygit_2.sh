#!/usr/bin/env bash
alias art="php artisan"
git remote set-url origin https://github.com/HCarlos/Moriah.git
git config --global user.email "r0@tecnointel.mx"
git config --global user.name "HCarlos"
git config --global color.ui true
git config core.fileMode false
git config --global push.default simple
git stash
git checkout HEAD
git checkout master
git fetch origin
git pull origin master --force
composer dump-autoload
php artisan migrate
php artisan migrate --path=database/migrations/catalogos
rm -rf public/storage
php artisan storage:link
chmod +rwx public/storage
exit
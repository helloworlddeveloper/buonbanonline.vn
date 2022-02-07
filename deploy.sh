#!/bin/sh

ssh -o StrictHostKeyChecking=no $SSH_USER@$DEV_HOST << 'ENDSSH'
  set -e
  cd /home/chonhagiau/ch-nha-giau/
  git pull origin dev
  chown chonhagiau:chonhagiau /home/chonhagiau/ch-nha-giau/src
  chmod -R 777 /home/chonhagiau/ch-nha-giau/src
  chown chonhagiau:chonhagiau -Rf /home/chonhagiau/ch-nha-giau/src/*
  cd /home/chonhagiau/ch-nha-giau/src/
  chmod -Rf 755 ./*
  find ./ -type f -exec chmod 644 {} +;
  chmod 777 /home/chonhagiau/ch-nha-giau/src/.htaccess

  exec "$@"
ENDSSH

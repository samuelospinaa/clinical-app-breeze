#!/bin/bash

SIMPLE=false

while [[ $# -gt 0 ]]; do
    case "$1" in
        --simple)
            SIMPLE=true
            shift
            ;;
        *)
            echo "Argumento desconocido: $1"
            exit 1
            ;;
    esac
done

echo "Updating code from the repository..."
git pull origin main

if [ "$SIMPLE" != "true" ]; then

   read -p "Do you want to run 'composer install'? (y/n): " run_composer

   if [ "$run_composer" == "y" ]; then
      echo "Installing Composer dependencies..."
      composer install --no-interaction --prefer-dist --optimize-autoloader
      #yes | cp -r /home/healthderma/apps/healthderma-app-breeze/public/assets/filament/css/app.css /home/healthderma/apps/healthderma-app-breeze/public/css/filament/filament/app.css
   fi

   read -p "Do you want to run 'php artisan migrate'? (y/n): " run_migrate

   if [ "$run_migrate" == "y" ]; then
      echo "Running database migrations..."
      php artisan migrate --force
   fi

   read -p "Do you want to run 'pnpm run build'? (y/n): " run_build

   if [ "$run_build" == "y" ]; then
       echo "Running pnpm build..."
       pnpm i
       pnpm run build

       echo "Restart SSR Server..."
       pm2 restart 0
   fi

   if [ -z "$run_composer" ] || [ -z "$run_migrate" ] || [ -z "$run_build" ]; then
     echo "ERROR: There cannot be any empty answers."
     exit 1
   fi

fi

echo "Optimizing the application..."
php artisan optimize

echo "Clearing compiled views..."
php artisan view:clear

echo "Clearing configuration cache..."
php artisan config:cache

echo "Deployment completed!"

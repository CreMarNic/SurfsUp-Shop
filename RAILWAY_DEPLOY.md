# Railway Configuration for SurfsUp Shop

## Environment Variables
Add these in Railway dashboard:

```
APP_ENV=prod
APP_SECRET=your-secret-key-here-change-this
DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
SYMFONY_ENV=prod
```

## Build Command
```bash
composer install --no-dev --optimize-autoloader --no-scripts --no-interaction
```

## Start Command
```bash
vendor/bin/heroku-php-apache2 public/
```

## Alternative Start Command (if above fails)
```bash
php -S 0.0.0.0:$PORT -t public/
```

## Troubleshooting
1. Check if all required PHP extensions are available
2. Ensure composer.json is valid
3. Try using PHP 8.2 specifically
4. Check build logs for specific errors


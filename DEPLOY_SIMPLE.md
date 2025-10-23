# 🚀 Simple SurfsUp Shop Deployment

## Quick Fix for Deployment Issues

### Option 1: Use Render.com (Recommended)
1. Go to https://render.com/
2. Sign up with GitHub
3. Click "New" → "Web Service"
4. Connect repository: `CreMarNic/SurfsUp-Shop`
5. Use these settings:

**Build Command:**
```bash
composer install --optimize-autoloader --no-scripts --no-interaction --ignore-platform-req=ext-zip
```

**Start Command:**
```bash
php -S 0.0.0.0:$PORT -t public/
```

### Option 2: Use Railway with PHP Extensions
1. Go to https://railway.app/
2. Create new project from GitHub
3. Add these environment variables:
   - `PHP_EXTENSIONS=zip,gd,intl,mbstring`
   - `COMPOSER_IGNORE_PLATFORM_REQS=1`

### Option 3: Use Heroku with Buildpack
1. Go to https://heroku.com/
2. Create new app
3. Add buildpack: `heroku/php`
4. Set environment variable: `COMPOSER_IGNORE_PLATFORM_REQS=1`

## Environment Variables
```
APP_ENV=prod
APP_SECRET=your-secret-key-here
DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
COMPOSER_IGNORE_PLATFORM_REQS=1
```

## Post-Deployment
1. Run: `php bin/console cache:clear`
2. Create admin user: `php bin/console sylius:user:create`
3. Access admin: `/admin`

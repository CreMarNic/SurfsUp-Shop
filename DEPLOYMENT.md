# 🚀 SurfsUp Shop Deployment Guide

## Quick Deploy Options

### Option 1: Railway (Recommended)
1. Go to https://railway.app/
2. Sign up with GitHub
3. Connect repository: `CreMarNic/SurfsUp-Shop`
4. Railway auto-detects PHP/Sylius
5. Deploy automatically!

### Option 2: Heroku
1. Install Heroku CLI
2. Run: `heroku create surfsup-shop`
3. Run: `git push heroku main`
4. Run: `heroku run php bin/console sylius:install --no-interaction`

### Option 3: Render
1. Go to https://render.com/
2. Connect GitHub repository
3. Select "Web Service"
4. Build command: `composer install --no-dev --optimize-autoloader`
5. Start command: `vendor/bin/heroku-php-apache2 public/`

## Environment Variables Needed

```
APP_ENV=prod
APP_SECRET=your-secret-key-here
DATABASE_URL=sqlite:///%kernel.project_dir%/var/data.db
```

## Post-Deployment Steps

1. Run: `php bin/console sylius:install --no-interaction`
2. Create admin user: `php bin/console sylius:user:create`
3. Clear cache: `php bin/console cache:clear`

## Database Options

- **SQLite** (default): Works out of the box
- **PostgreSQL**: Add `DATABASE_URL=postgresql://...`
- **MySQL**: Add `DATABASE_URL=mysql://...`

## Custom Domain

After deployment, you can add a custom domain in your hosting platform's settings.


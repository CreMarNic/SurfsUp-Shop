# SurfsUp Shop - Hostinger Deployment Guide

## Prerequisites

- Hostinger hosting account with:
  - PHP 8.2 or higher support
  - MySQL database access
  - SSH access (recommended) or FTP access
  - Git support (if available in your plan)
- GitHub repository with your SurfsUp Shop code
- Domain name pointed to Hostinger

## Hostinger Account Setup

### 1. Check Your Hosting Plan

Verify your Hostinger plan includes:
- **PHP 8.2+**: Required for Sylius
- **MySQL Database**: For storing application data
- **SSH Access**: Recommended for easier deployment
- **Git Support**: Optional but helpful

### 2. Access Your Hosting Panel

1. Log in to [hPanel](https://hpanel.hostinger.com/)
2. Navigate to your hosting account
3. Access **File Manager** or **SSH Terminal**

## Deployment Methods

### Method 1: Using Git (Recommended if available)

If your Hostinger plan supports Git:

#### Step 1: Connect via SSH

```bash
ssh username@your-domain.com
# or
ssh username@your-server-ip
```

#### Step 2: Navigate to Your Domain Directory

```bash
cd domains/your-domain.com/public_html
```

#### Step 3: Clone Your Repository

```bash
# If directory is empty
git clone https://github.com/CreMarNic/SurfsUp-Shop.git .

# Or if you need to pull updates
git pull origin main
```

#### Step 4: Install Dependencies

```bash
# Make sure Composer is available
composer install --no-dev --optimize-autoloader --no-interaction

# If Composer is not installed globally, download it:
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar install --no-dev --optimize-autoloader --no-interaction
```

#### Step 5: Set Permissions

```bash
chmod -R 755 .
chmod -R 777 var/
chmod -R 777 public/media
```

---

### Method 2: Using FTP/SFTP

#### Step 1: Prepare Your Files Locally

1. **Clone your repository locally**:
   ```bash
   git clone https://github.com/CreMarNic/SurfsUp-Shop.git
   cd SurfsUp-Shop
   ```

2. **Install dependencies**:
   ```bash
   composer install --no-dev --optimize-autoloader --no-interaction
   ```

3. **Create a deployment package** (exclude unnecessary files):
   - Keep: `config/`, `public/`, `src/`, `templates/`, `vendor/`, `composer.json`, `composer.lock`
   - Exclude: `.git/`, `.env.local`, `var/cache/`, `var/log/`, `tests/`, `node_modules/`

#### Step 2: Upload Files via FTP

1. **Connect using FTP client** (FileZilla, WinSCP, etc.):
   - **Host**: `ftp.your-domain.com` or your server IP
   - **Username**: Your Hostinger FTP username
   - **Password**: Your Hostinger FTP password
   - **Port**: 21 (FTP) or 22 (SFTP)

2. **Upload files** to `public_html/` directory:
   - Upload all files maintaining the directory structure
   - Ensure `public/` folder contents are in `public_html/`

#### Step 3: Set Permissions via FTP Client

- Right-click on `var/` folder → **File Permissions** → Set to `777`
- Right-click on `public/media/` → **File Permissions** → Set to `777`
- All other files/folders should be `755`

---

### Method 3: Using Hostinger File Manager

1. **Access File Manager** in hPanel
2. **Navigate to** `public_html/`
3. **Upload files**:
   - Use "Upload Files" button
   - Upload your project files (zip and extract, or upload individually)
4. **Set permissions**:
   - Right-click `var/` → Change Permissions → `777`
   - Right-click `public/media/` → Change Permissions → `777`

---

## Database Setup

### Step 1: Create MySQL Database

1. **In hPanel**, go to **Databases** → **MySQL Databases**
2. **Create a new database**:
   - Database name: `surfsup_shop` (or your preferred name)
   - Note the database name, username, and password
3. **Add user to database**:
   - Create a new MySQL user
   - Grant all privileges to the user
   - Note the username and password

### Step 2: Get Database Connection Details

You'll need:
- **Database Host**: Usually `localhost` or `mysql.your-domain.com`
- **Database Name**: The name you created
- **Database User**: The username you created
- **Database Password**: The password you set
- **Database Port**: Usually `3306`

---

## Configuration

### Step 1: Create Environment File

1. **Via SSH**:
   ```bash
   cd public_html
   cp .env .env.local
   ```

2. **Via FTP/File Manager**:
   - Copy `.env` file and rename to `.env.local`
   - Edit the file

### Step 2: Configure Environment Variables

Edit `.env.local` with your Hostinger settings:

```env
# Application Environment
APP_ENV=prod
APP_SECRET=your-secret-key-here-generate-a-random-32-character-string

# Database Configuration
DATABASE_URL="mysql://db_user:db_password@localhost:3306/db_name?serverVersion=8.0&charset=utf8mb4"

# Replace with your actual values:
# - db_user: Your MySQL username
# - db_password: Your MySQL password
# - db_name: Your database name
# - localhost: Your database host (usually localhost on Hostinger)

# Mailer Configuration (Optional)
MAILER_DSN=smtp://username:password@smtp.hostinger.com:587

# Symfony Configuration
SYMFONY_ENV=prod
```

**Generate APP_SECRET**:
```bash
# Via SSH
php -r "echo bin2hex(random_bytes(16));"
```

### Step 3: Update Document Root (if needed)

If your files are in `public_html/` but the `public/` folder should be the web root:

**Option A: Move public folder contents** (Recommended)
```bash
# Via SSH
cd public_html
mv public/* .
mv public/.htaccess .
rmdir public
```

**Option B: Configure .htaccess redirect**
Create `.htaccess` in `public_html/`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ public/$1 [L]
```

---

## Post-Deployment Setup

### Step 1: Run Database Migrations

**Via SSH**:
```bash
cd public_html
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
```

**Via Hostinger Terminal** (if SSH not available):
- Use Hostinger's **Terminal** feature in hPanel
- Run the same commands

### Step 2: Install Sylius

```bash
php bin/console sylius:install --no-interaction
```

### Step 3: Create Admin User

```bash
php bin/console sylius:user:create
```

Follow the prompts to create your admin account.

### Step 4: Load Sample Data (Optional)

```bash
php bin/console sylius:fixtures:load
```

### Step 5: Clear and Warm Cache

```bash
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

### Step 6: Set File Permissions

```bash
chmod -R 755 .
chmod -R 777 var/
chmod -R 777 public/media
```

---

## PHP Configuration

### Check PHP Version

1. **In hPanel**, go to **Advanced** → **PHP Configuration**
2. **Select PHP 8.2** (or highest available version)
3. **Enable required extensions**:
   - `pdo_mysql`
   - `intl`
   - `gd`
   - `zip`
   - `xml`
   - `mbstring`
   - `opcache`

### PHP Settings (via .htaccess or php.ini)

Create or edit `.htaccess` in `public_html/`:

```apache
# PHP Settings
php_value memory_limit 256M
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300
php_value max_input_time 300

# Enable OPcache
php_flag opcache.enable On
php_value opcache.memory_consumption 128
```

Or configure via **PHP Configuration** in hPanel.

---

## Domain Configuration

### Step 1: Point Domain to Hostinger

1. **In your domain registrar**, update DNS records:
   - **A Record**: Point to Hostinger's IP address
   - **CNAME**: Point `www` to your domain

2. **In hPanel**, add your domain:
   - Go to **Domains** → **Add Domain**
   - Follow the setup wizard

### Step 2: Enable SSL Certificate

1. **In hPanel**, go to **SSL** → **Free SSL**
2. **Enable SSL** for your domain
3. **Force HTTPS** (add to `.htaccess`):
   ```apache
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

---

## Troubleshooting

### Issue: 500 Internal Server Error

**Solutions**:
1. Check file permissions:
   ```bash
   chmod -R 755 .
   chmod -R 777 var/
   ```

2. Check error logs:
   - In hPanel: **Logs** → **Error Log**
   - Or check `var/log/prod.log`

3. Verify `.env.local` is configured correctly

4. Check PHP version is 8.2+

### Issue: Database Connection Failed

**Solutions**:
1. Verify database credentials in `.env.local`
2. Check database host (usually `localhost` on Hostinger)
3. Ensure database user has proper permissions
4. Test connection:
   ```bash
   php bin/console doctrine:database:create --if-not-exists
   ```

### Issue: Permission Denied Errors

**Solutions**:
```bash
# Set correct permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod -R 777 var/
chmod -R 777 public/media
```

### Issue: Composer Not Found

**Solutions**:
1. Download Composer locally:
   ```bash
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   php composer-setup.php
   ```

2. Use local Composer:
   ```bash
   php composer.phar install --no-dev --optimize-autoloader
   ```

### Issue: Memory Limit Exceeded

**Solutions**:
1. Increase memory limit in `.htaccess`:
   ```apache
   php_value memory_limit 512M
   ```

2. Or contact Hostinger support to increase PHP memory limit

### Issue: Assets Not Loading

**Solutions**:
1. Rebuild assets (if using Webpack Encore):
   ```bash
   yarn install
   yarn encore production
   ```

2. Check `public/build/` directory exists and has correct permissions

3. Verify asset paths in templates

---

## Performance Optimization

### 1. Enable OPcache

Already configured in PHP settings, but verify it's enabled:
```bash
php -i | grep opcache
```

### 2. Enable Gzip Compression

Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>
```

### 3. Set Cache Headers

Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### 4. Database Optimization

- Regularly optimize your database via phpMyAdmin
- Enable query caching if available
- Use indexes on frequently queried columns

---

## Security Considerations

### 1. Protect Sensitive Files

Add to `.htaccess`:
```apache
# Protect .env files
<FilesMatch "\.env">
    Order allow,deny
    Deny from all
</FilesMatch>

# Protect composer files
<FilesMatch "composer\.(json|lock)">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 2. Hide Server Information

Add to `.htaccess`:
```apache
ServerSignature Off
```

### 3. Regular Updates

- Keep Composer dependencies updated
- Regularly update Sylius core
- Monitor security advisories

---

## Updating Your Application

### Method 1: Via Git (Recommended)

```bash
cd public_html
git pull origin main
composer install --no-dev --optimize-autoloader --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

### Method 2: Via FTP

1. Download updated files from GitHub
2. Upload via FTP (excluding `var/` and `.env.local`)
3. Run migrations and clear cache via SSH/Terminal

---

## Support Resources

- **Hostinger Support**: [support.hostinger.com](https://support.hostinger.com)
- **Sylius Documentation**: [docs.sylius.com](https://docs.sylius.com)
- **Symfony Documentation**: [symfony.com/doc](https://symfony.com/doc)

---

## Quick Reference Commands

```bash
# Navigate to project
cd public_html

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Clear cache
php bin/console cache:clear --env=prod

# Warm up cache
php bin/console cache:warmup --env=prod

# Create admin user
php bin/console sylius:user:create

# Check application status
php bin/console about
```

---

## Notes

- **Backup regularly**: Use Hostinger's backup feature or create manual backups
- **Monitor logs**: Check `var/log/prod.log` regularly for errors
- **Test after updates**: Always test your site after deploying updates
- **Keep dependencies updated**: Regularly run `composer update` (in a staging environment first)

---

**Last Updated**: 2024
**Project**: SurfsUp Shop
**Framework**: Sylius (Symfony-based)


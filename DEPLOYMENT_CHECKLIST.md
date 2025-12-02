# 🚀 SurfsUp Shop - Hostinger Deployment Checklist

Follow this checklist step-by-step to deploy your SurfsUp Shop to Hostinger.

## ✅ Pre-Deployment Checklist

### 1. Prepare Your Local Project
- [ ] Ensure all code is committed to GitHub
- [ ] Test your application locally
- [ ] Note your GitHub repository URL: `https://github.com/CreMarNic/SurfsUp-Shop`
- [ ] Have your Hostinger login credentials ready

### 2. Hostinger Account Setup
- [ ] Log in to [hPanel](https://hpanel.hostinger.com/)
- [ ] Verify PHP version (need 8.2+)
  - Go to **Advanced** → **PHP Configuration**
  - Select PHP 8.2 or higher
- [ ] Check if SSH access is available
  - Go to **Advanced** → **SSH Access**
  - Note your SSH credentials if available
- [ ] Note your FTP credentials
  - Go to **Files** → **FTP Accounts**

### 3. Database Preparation
- [ ] Create MySQL database in Hostinger
  - Go to **Databases** → **MySQL Databases**
  - Click **Create Database**
  - Database name: `surfsup_shop` (or your choice)
  - Create a MySQL user and grant privileges
  - **IMPORTANT**: Write down these details:
    - Database Name: `_________________`
    - Database User: `_________________`
    - Database Password: `_________________`
    - Database Host: `_________________` (usually `localhost`)

## 📋 Deployment Steps

### Step 1: Choose Your Deployment Method

**Option A: Git (Recommended - if SSH available)**
- [ ] Use Method 1 from HOSTINGER_DEPLOY.md

**Option B: FTP (If no SSH)**
- [ ] Use Method 2 from HOSTINGER_DEPLOY.md

**Option C: File Manager (Easiest)**
- [ ] Use Method 3 from HOSTINGER_DEPLOY.md

---

### Step 2: Upload Files

#### If Using Git (SSH):
```bash
# Connect via SSH
ssh username@your-domain.com

# Navigate to public_html
cd domains/your-domain.com/public_html

# Clone repository
git clone https://github.com/CreMarNic/SurfsUp-Shop.git .

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction
```

#### If Using FTP:
- [ ] Download project from GitHub (or use local copy)
- [ ] Install dependencies locally: `composer install --no-dev --optimize-autoloader`
- [ ] Upload all files to `public_html/` via FTP client
- [ ] Maintain directory structure

#### If Using File Manager:
- [ ] Zip your project folder (excluding `var/`, `.git/`, `node_modules/`)
- [ ] Upload zip file to `public_html/`
- [ ] Extract the zip file
- [ ] Delete the zip file

---

### Step 3: Configure Environment

- [ ] Create `.env.local` file in `public_html/`
- [ ] Add the following configuration:

```env
APP_ENV=prod
APP_SECRET=GENERATE_A_RANDOM_32_CHARACTER_STRING_HERE
DATABASE_URL="mysql://DB_USER:DB_PASSWORD@localhost:3306/DB_NAME?serverVersion=8.0&charset=utf8mb4"
SYMFONY_ENV=prod
```

**Replace:**
- `DB_USER` with your database username
- `DB_PASSWORD` with your database password
- `DB_NAME` with your database name
- Generate `APP_SECRET` using: `php -r "echo bin2hex(random_bytes(16));"`

- [ ] Save the file

---

### Step 4: Set File Permissions

**Via SSH:**
```bash
chmod -R 755 .
chmod -R 777 var/
chmod -R 777 public/media
```

**Via FTP Client:**
- [ ] Right-click `var/` folder → Permissions → `777`
- [ ] Right-click `public/media/` folder → Permissions → `777`
- [ ] All other folders → `755`

**Via File Manager:**
- [ ] Select `var/` → Change Permissions → `777`
- [ ] Select `public/media/` → Change Permissions → `777`

---

### Step 5: Database Setup

**Via SSH or Hostinger Terminal:**
```bash
cd public_html

# Create database (if not exists)
php bin/console doctrine:database:create --if-not-exists

# Run migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Install Sylius
php bin/console sylius:install --no-interaction
```

- [ ] Verify migrations ran successfully

---

### Step 6: Create Admin User

**Via SSH or Hostinger Terminal:**
```bash
php bin/console sylius:user:create
```

- [ ] Follow prompts to create admin account
- [ ] Save admin credentials securely

---

### Step 7: Clear and Warm Cache

```bash
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

- [ ] Verify cache cleared successfully

---

### Step 8: Configure PHP Settings

**Create/Edit `.htaccess` in `public_html/`:**
```apache
# PHP Settings
php_value memory_limit 256M
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value max_execution_time 300

# Enable OPcache
php_flag opcache.enable On
```

- [ ] Save `.htaccess` file

---

### Step 9: Test Your Site

- [ ] Visit your domain: `https://your-domain.com`
- [ ] Check homepage loads correctly
- [ ] Test admin panel: `https://your-domain.com/admin`
- [ ] Login with admin credentials
- [ ] Verify no errors in browser console

---

### Step 10: Enable SSL (HTTPS)

- [ ] In hPanel, go to **SSL** → **Free SSL**
- [ ] Enable SSL for your domain
- [ ] Add HTTPS redirect to `.htaccess`:

```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

- [ ] Test HTTPS works: `https://your-domain.com`

---

## 🔧 Troubleshooting

### If you see "500 Internal Server Error":
1. Check file permissions (Step 4)
2. Check `.env.local` configuration (Step 3)
3. Check error logs in hPanel → **Logs** → **Error Log**
4. Verify PHP version is 8.2+

### If database connection fails:
1. Verify database credentials in `.env.local`
2. Check database host (usually `localhost`)
3. Ensure database user has proper permissions
4. Test connection via phpMyAdmin

### If assets don't load:
1. Check `public/build/` directory exists
2. Verify file permissions on `public/` folder
3. Rebuild assets if needed (requires Node.js/Yarn)

---

## 📝 Post-Deployment

- [ ] Backup your database regularly
- [ ] Monitor error logs: `var/log/prod.log`
- [ ] Set up regular backups in hPanel
- [ ] Test all major features:
  - [ ] Product browsing
  - [ ] Shopping cart
  - [ ] Checkout process
  - [ ] Admin panel access

---

## 🔄 Updating Your Site

When you need to update:

**Via Git:**
```bash
cd public_html
git pull origin main
composer install --no-dev --optimize-autoloader --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

**Via FTP:**
1. Upload updated files
2. Run migrations and clear cache via SSH/Terminal

---

## 📞 Need Help?

- Check `HOSTINGER_DEPLOY.md` for detailed instructions
- Hostinger Support: [support.hostinger.com](https://support.hostinger.com)
- Sylius Docs: [docs.sylius.com](https://docs.sylius.com)

---

**Ready to start?** Begin with Step 1 and check off each item as you complete it! ✅


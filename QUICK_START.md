# 🚀 Quick Start - Deploy to Hostinger

You have a Hostinger account and domain. Let's get your SurfsUp Shop live!

## Step 1: Check Your Hostinger Setup (5 minutes)

### A. Access hPanel
1. Go to [hPanel](https://hpanel.hostinger.com/)
2. Log in with your Hostinger credentials
3. Select your domain/hosting account

### B. Check PHP Version
1. In hPanel, go to **Advanced** → **PHP Configuration**
2. Select **PHP 8.2** or higher (required for Sylius)
3. Click **Save**

### C. Check Available Access Methods
Check which of these you have:

**Option 1: SSH Access** (Best - fastest deployment)
- Go to **Advanced** → **SSH Access**
- If you see SSH credentials → ✅ You have SSH!
- Note your SSH username and host

**Option 2: FTP Access** (Works on all plans)
- Go to **Files** → **FTP Accounts**
- If you see FTP accounts → ✅ You have FTP!
- Note your FTP host, username, and password

**Option 3: File Manager** (Always available)
- Go to **Files** → **File Manager**
- ✅ This is always available!

---

## Step 2: Create Database (5 minutes)

1. In hPanel, go to **Databases** → **MySQL Databases**
2. Click **Create Database**
3. Fill in:
   - **Database Name**: `surfsup_shop` (or your choice)
   - **Username**: Create a new user (or use existing)
   - **Password**: Create a strong password
4. Click **Create**
5. **IMPORTANT**: Write down these details:
   ```
   Database Name: _________________
   Database User: _________________
   Database Password: _________________
   Database Host: localhost (usually)
   ```

---

## Step 3: Choose Your Deployment Method

### 🎯 Method A: Git + SSH (Recommended - Fastest)
**Use this if:** You have SSH access

**Steps:**
1. Connect via SSH (I'll guide you)
2. Clone your GitHub repo
3. Install dependencies
4. Configure and deploy

**Time:** ~15 minutes

---

### 📁 Method B: FTP (Works Everywhere)
**Use this if:** You have FTP access (no SSH)

**Steps:**
1. Prepare files locally
2. Upload via FTP client
3. Configure via File Manager or Terminal
4. Set up database

**Time:** ~30 minutes

---

### 📂 Method C: File Manager (Easiest)
**Use this if:** You want the simplest method

**Steps:**
1. Zip your project
2. Upload via File Manager
3. Extract files
4. Configure via Terminal or File Manager

**Time:** ~45 minutes

---

## What's Next?

**Tell me:**
1. ✅ Do you have SSH access? (Yes/No/Not sure)
2. ✅ Do you have FTP access? (Yes/No/Not sure)
3. ✅ Have you created the database? (Yes/No)

Once you tell me, I'll give you the exact commands and steps for your situation!

---

## Quick Commands Reference

### If you have SSH:
```bash
# Connect
ssh username@your-domain.com

# Navigate
cd domains/your-domain.com/public_html

# Clone
git clone https://github.com/CreMarNic/SurfsUp-Shop.git .

# Install
composer install --no-dev --optimize-autoloader
```

### If you need to check access:
- **SSH**: hPanel → Advanced → SSH Access
- **FTP**: hPanel → Files → FTP Accounts
- **File Manager**: hPanel → Files → File Manager

---

**Ready?** Check your Hostinger setup and let me know what access you have! 🎯


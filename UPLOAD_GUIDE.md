# 📤 Upload SurfsUp Shop to Hostinger - Step by Step

Your `public_html` is empty - perfect! Let's upload your SurfsUp Shop.

## Method: Upload via File Manager (Easiest)

### Step 1: Prepare Your Files Locally

**On your computer:**

1. **Navigate to your project folder:**
   ```bash
   cd C:\xampp\htdocs\sylius
   ```

2. **Install production dependencies** (if not done):
   ```bash
   composer install --no-dev --optimize-autoloader --no-interaction
   ```
   This creates the `vendor/` folder with all required packages.

3. **Create a zip file** of your project:
   - Select all files and folders EXCEPT:
     - ❌ `.git/` folder (if exists)
     - ❌ `var/cache/` (will be recreated)
     - ❌ `var/log/` (will be recreated)
     - ❌ `node_modules/` (if exists)
     - ❌ `.env.local` (we'll create this on server)
   
   - ✅ Include these:
     - `config/`
     - `public/`
     - `src/`
     - `templates/`
     - `vendor/`
     - `composer.json`
     - `composer.lock`
     - `bin/`
     - All other files

4. **Create the zip file:**
   - Right-click selected files → "Send to" → "Compressed (zipped) folder"
   - Name it: `surfsup-shop.zip`

---

### Step 2: Upload to Hostinger

**In Hostinger File Manager:**

1. **Navigate to `public_html`** (you're already there!)

2. **Click the "Upload" button** (top right - looks like an up arrow)

3. **Select your zip file:**
   - Click "Select Files" or drag and drop `surfsup-shop.zip`
   - Wait for upload to complete (may take a few minutes)

4. **Extract the zip file:**
   - Right-click on `surfsup-shop.zip`
   - Select "Extract" or "Extract All"
   - Extract to current directory (`public_html`)
   - Wait for extraction to complete

5. **Delete the zip file:**
   - Right-click `surfsup-shop.zip` → Delete
   - (Keep the extracted files)

---

### Step 3: Verify Upload

**Check that these folders exist in `public_html`:**
- ✅ `config/`
- ✅ `public/`
- ✅ `src/`
- ✅ `templates/`
- ✅ `vendor/`
- ✅ `bin/`

**If you see these, you're good! ✅**

---

### Step 4: Move Public Folder Contents (IMPORTANT!)

**The `public/` folder should be your web root. Do this:**

**Option A: Via File Manager (Easier)**
1. Open the `public/` folder
2. Select ALL files inside `public/`
3. Cut them (Ctrl+X)
4. Go back to `public_html/`
5. Paste them (Ctrl+V)
6. Now delete the empty `public/` folder

**Option B: Via Terminal (If available)**
1. In hPanel, look for "Terminal" in the left sidebar
2. Open Terminal
3. Run:
   ```bash
   cd public_html
   mv public/* .
   mv public/.htaccess . 2>/dev/null || true
   rmdir public
   ```

---

### Step 5: Set File Permissions

**In File Manager:**

1. **Right-click on `var/` folder:**
   - Select "Change Permissions" or "Permissions"
   - Set to: `777`
   - Click "Save"

2. **Right-click on `public/media/` folder** (if it exists):
   - Set permissions to: `777`

3. **All other folders:**
   - Set to: `755` (default is usually fine)

---

## What's Next?

After uploading, we need to:
1. ✅ Create database (if not done)
2. ✅ Configure `.env.local` file
3. ✅ Run database migrations
4. ✅ Create admin user
5. ✅ Test your site

**Tell me when the upload is complete, and we'll continue!** 🚀


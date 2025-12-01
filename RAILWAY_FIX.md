# 🔧 Railway Deployment Fix

## Problem
Railway build is failing because it can't find `public/`, `src/`, and `config/` directories. This happens when the build context is incorrect.

## Solution

The Dockerfile expects the **repository root** as the build context, and it copies files from the `sylius/` subdirectory.

### Configure Railway Build Settings

1. **Go to Railway Dashboard** → Your Service → **Settings**

2. **Find "Build" section** and configure:
   - **Root Directory**: Leave empty (uses repository root) OR set to `.` (repository root)
   - **Dockerfile Path**: `sylius/Dockerfile`
   - **Build Context**: `.` (repository root - this is the key!)

3. **Alternative: Set Root Directory to `sylius/`**
   - If Railway doesn't support custom Dockerfile path:
   - **Root Directory**: `sylius`
   - **Dockerfile Path**: `Dockerfile` (will use sylius/Dockerfile)
   - Then update Dockerfile to copy from `.` instead of `sylius/`

## Current Dockerfile Configuration

The Dockerfile is configured to:
- Copy `composer.json` from `sylius/composer.json`
- Copy all files from `sylius/` directory
- Expect build context to be repository root

## Quick Fix: Update Railway Settings

**Option 1: Use Root as Build Context (Recommended)**
```
Root Directory: . (or leave empty)
Dockerfile Path: sylius/Dockerfile
```

**Option 2: Use sylius/ as Root Directory**
If Railway doesn't support custom Dockerfile paths:
1. Set Root Directory to `sylius/`
2. The Dockerfile will need to be updated to copy from `.` instead of `sylius/`

## Verify Configuration

After updating settings, trigger a new deployment. The build should now:
1. ✅ Find `composer.json` in `sylius/`
2. ✅ Copy all files from `sylius/` to container
3. ✅ Find `public/`, `src/`, and `config/` directories
4. ✅ Complete successfully

## If Still Failing

If you're still getting errors, check:
1. **Build Logs**: Look for "ERROR: public directory missing"
2. **Verify Structure**: Ensure `sylius/public/`, `sylius/src/`, `sylius/config/` exist
3. **Check Root Directory**: Railway should be building from repository root

## Alternative: Move Dockerfile to Root

If Railway configuration is difficult, you can:
1. Copy `sylius/Dockerfile` to root as `Dockerfile`
2. Update it to copy from `sylius/` subdirectory
3. Set Railway root directory to `.` (repository root)

---

**Note**: The Dockerfile has been updated to copy from `sylius/` subdirectory, assuming the build context is the repository root.


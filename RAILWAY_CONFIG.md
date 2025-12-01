# Railway Configuration Guide

## Problem
Railway is detecting `sylius/Dockerfile` but using repository root as build context, causing `COPY sylius/` to fail.

## Solution Options

### Option 1: Use Root Dockerfile (Recommended)

Configure Railway to use the root `Dockerfile`:

1. Go to Railway Dashboard → Your Service → **Settings**
2. Find **"Build"** section
3. Set:
   - **Root Directory**: `.` (repository root) or leave empty
   - **Dockerfile Path**: `Dockerfile` (root Dockerfile)
   - **Build Context**: `.` (repository root)

The root `Dockerfile` is already configured to copy from `sylius/` subdirectory.

### Option 2: Use sylius/ as Root Directory

Configure Railway to use `sylius/` as the root:

1. Go to Railway Dashboard → Your Service → **Settings**
2. Find **"Root Directory"** setting
3. Set to: `sylius`
4. Railway will automatically use `sylius/Dockerfile`

Then the `sylius/Dockerfile` will work correctly (it copies from `.` which will be `sylius/`).

### Option 3: Clear Build Cache

If Railway is using cached builds:

1. Go to Railway Dashboard → Your Service → **Settings**
2. Find **"Clear Build Cache"** or **"Rebuild"** option
3. Clear cache and trigger new deployment

## Current Setup

- **Root Dockerfile**: `Dockerfile` - Expects repository root as build context, copies from `sylius/`
- **Sylius Dockerfile**: `sylius/Dockerfile` - Expects `sylius/` as build context, copies from `.`

## Recommended Configuration

**Use Option 1** - Configure Railway to use root `Dockerfile`:
- Root Directory: `.` (or empty)
- Dockerfile Path: `Dockerfile`

This is the simplest and most reliable configuration.


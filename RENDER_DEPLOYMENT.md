# LavaLust Student Portal - Deployment Guide

## 🚀 Deploy to Render

Follow these steps to deploy your LavaLust application to Render:

### Step 1: Connect GitHub Repository

1. Go to [Render Dashboard](https://dashboard.render.com)
2. Click **"New +"** → **"Web Service"**
3. Click **"Connect a repository"**
4. Find and select: `jhaeylabergue/labergue-januar-lavalust`
5. Click **"Connect"**

### Step 2: Configure Web Service

**Basic Settings:**
- **Name**: `labergue-januar-lavalust` (or your preferred name)
- **Region**: Select closest to you (e.g., `Singapore`, `Oregon`)
- **Branch**: `main`
- **Runtime**: `PHP`

**Build & Deploy:**
- **Build Command**: `composer install`
- **Start Command**: 
  ```bash
  php -S 0.0.0.0:$PORT public/index.php
  ```

### Step 3: Environment Variables

Click **"Advanced"** and add these environment variables:

```
APP_ENV = production
BASE_URL = https://your-app-name.onrender.com/
```

**To find your URL after deployment:**
- Check the Render dashboard - it will show your app URL
- Update `BASE_URL` with the actual URL

### Step 4: Add Environment File

Create `.env` file at project root (optional but recommended):

```env
APP_ENV=production
BASE_URL=https://your-app-name.onrender.com/
```

Add to `.gitignore` to keep sensitive data private:
```
.env
.env.local
runtime/logs/*
runtime/session/*
```

### Step 5: Deploy

1. Click **"Create Web Service"**
2. Render will automatically build and deploy your app
3. Wait for build to complete (takes 2-5 minutes)
4. Your app will be live at: `https://your-app-name.onrender.com`

---

## 📋 Environment Variables Reference

| Variable | Value | Notes |
|----------|-------|-------|
| `APP_ENV` | `production` | Set to production for live deployment |
| `BASE_URL` | `https://your-domain.onrender.com/` | Update after deployment |
| `LOG_THRESHOLD` | `1` | Error logging level |
| `COMPOSER_VENDOR_DIR` | `vendor` | Composer packages directory |

---

## 🔧 Render Configuration File

You can optionally create a `render.yaml` file for more control:

```yaml
services:
  - type: web
    name: labergue-januar-lavalust
    env: php
    plan: free
    buildCommand: composer install
    startCommand: php -S 0.0.0.0:$PORT public/index.php
    envVars:
      - key: APP_ENV
        value: production
      - key: BASE_URL
        fromService:
          name: labergue-januar-lavalust
          property: url
```

---

## 📊 Project Structure for Deployment

```
labergue-januar-lavalust/
├── app/                    # Application code
│   ├── config/            # Configuration files
│   ├── controllers/       # Controllers including StudentController
│   ├── middlewares/       # Middleware including StudentMiddleware
│   ├── views/            # Views including student portal
│   └── ...
├── public/               # Public entry point
│   ├── index.php        # Application entry
│   └── .htaccess        # Apache routing
├── scheme/              # Framework core
├── runtime/             # Logs and sessions
├── index.php            # Root entry point (redirects to public/)
├── Procfile             # Render deployment config
├── composer.json        # PHP dependencies
├── .htaccess            # Root routing
└── DOCUMENTATION.md     # Full documentation
```

---

## ✅ Verify Deployment

After deployment, test these routes:

1. **Homepage**: `https://your-app-name.onrender.com/`
2. **Student Portal**: `https://your-app-name.onrender.com/student`
3. **Grant Access**: `https://your-app-name.onrender.com/student?grant=1`
4. **Student Profile**: `https://your-app-name.onrender.com/student/profile`

All routes should work without `/index.php/` prefix.

---

## 🐛 Troubleshooting

### 404 Errors
- Ensure `.htaccess` files are deployed
- Check that `index_page` config is empty in `app/config/config.php`
- Verify root `index.php` is present

### Session Issues
- Render uses ephemeral storage - sessions persist during deployment
- For production, consider database-backed sessions
- Check `runtime/session/` permissions

### Build Failures
- Ensure `composer.json` exists in root
- Check PHP version compatibility (requires PHP 8.0+)
- Review build logs in Render dashboard

---

## 📱 Monitoring & Logs

In Render Dashboard:
1. Click your service name
2. Go to **"Logs"** tab
3. View real-time application logs
4. Check **"Events"** for deployment history

---

## 🔄 Continuous Deployment

Once connected:
- Every push to `main` branch triggers automatic deployment
- Failed builds won't affect live app
- Rollback by redeploying previous commit
- Custom domains available under **"Settings"**

---

## 🎯 Next Steps

1. ✅ Push code to GitHub (Done!)
2. 🔄 Connect to Render (Follow steps above)
3. 🌐 Deploy and test
4. 📊 Monitor logs and performance
5. 🚀 Add custom domain (optional)

Your app will be live within minutes! 🎉

---

**Repository**: [jhaeylabergue/labergue-januar-lavalust](https://github.com/jhaeylabergue/labergue-januar-lavalust)  
**Framework**: LavaLust v4.6.0  
**PHP Version**: 8.0+  
**Last Updated**: 2026-08-18

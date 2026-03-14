# Deploying GLFTS to Railway.app

This guide explains how to host your Global Logistics & Fleet Tracking System on Railway.

## 1. Prerequisites
- A [Railway.app](https://railway.app) account.
- [Railway CLI](https://docs.railway.app/guides/cli) installed (optional but recommended).

## 2. Setting up the Database
1. In your Railway dashboard, click **"New project"**.
2. Select **"Provision MySQL"**. 
3. Once the database is created, click on it and go to the **"Variables"** tab. Copy these values:
   - `MYSQL_URL` (or individual host, port, user, password, database).

## 3. Deploying the Application
1. Click **"New"** → **"GitHub Repo"** and select your `naveenGLFTS` repository.
2. Railway will automatically detect it's a Laravel app.

## 4. Configuration (Variables)
Go to your App Settings in Railway and add these **Variables**:
- `APP_KEY`: (Copy from your local `.env`)
- `APP_ENV`: `production`
- `APP_DEBUG`: `false`
- `APP_URL`: `https://${{RAILWAY_STATIC_URL}}`
- `DB_CONNECTION`: `mysql`
- `DB_HOST`: `${{MySQL.MYSQLHOST}}`
- `DB_PORT`: `${{MySQL.MYSQLPORT}}`
- `DB_DATABASE`: `${{MySQL.MYSQLDATABASE}}`
- `DB_USERNAME`: `${{MySQL.MYSQLUSER}}`
- `DB_PASSWORD`: `${{MySQL.MYSQLPASSWORD}}`

## 5. Deployment Commands
Railway uses a `Nixpacks` build system. It should handle everything, but ensure your **Start Command** (in Settings) is:
```bash
php artisan migrate --force && php artisan scribe:generate && php artisan serve --host=0.0.0.0 --port=$PORT
```
*(Note: Using `php artisan serve` is fine for lightweight Railway deployments, or you can use a production-ready Dockerfile approach).*

## 6. Accessing the App
Once the build is "Success", Railway will provide a public URL (e.g., `https://naveenglfts-production.up.railway.app`). 
- **Dashboard**: `/`
- **Interactive Docs**: `/docs`

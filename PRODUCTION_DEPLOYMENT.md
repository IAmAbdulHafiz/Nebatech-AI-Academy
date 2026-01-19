# Production Deployment Guide

## 🚀 Nebatech Software Solutions Ltd - Production Checklist

### ✅ Completed Production Setup

1. **Environment Configuration** (`.env`)
   - [x] `APP_ENV=production`
   - [x] `APP_DEBUG=false`
   - [x] Generated secure `JWT_SECRET` (64 characters)
   - [x] Generated secure `ENCRYPTION_KEY` (64 characters)
   - [x] `LOG_LEVEL=error`
   - [x] `AI_DEMO_MODE=false`

2. **Application Entry Point** (`public/index.php`)
   - [x] Error display disabled for production
   - [x] Errors logged to `storage/logs/php_errors.log`
   - [x] Session security settings (httponly, secure, samesite)
   - [x] CORS restricted to allowed origins
   - [x] Security headers (X-Content-Type-Options, X-Frame-Options, etc.)
   - [x] HSTS header for production

3. **Apache Configuration** (`public/.htaccess`)
   - [x] Directory listing disabled
   - [x] Sensitive files protected (.env, .log, .sql, etc.)
   - [x] Security headers via mod_headers
   - [x] Asset caching configured
   - [x] Gzip compression enabled
   - [x] HTTPS redirect ready (uncomment when SSL is configured)

4. **Debug Files Removed**
   - [x] Removed all test-*.php files
   - [x] Removed all debug-*.php files
   - [x] Removed setup and migration scripts from public
   - [x] Removed clear-cache.php and clear-session.php

---

### 📋 Pre-Deployment Tasks

Before going live, complete these steps:

#### 1. Database
```bash
# Export development database
mysqldump -u root nebatech_ai_academy > backup.sql

# On production server, create database and import
mysql -u prod_user -p prod_database < backup.sql
```

#### 2. Update Production .env
```env
# Update these values for your production server
APP_URL=https://your-domain.com

DB_HOST=production_db_host
DB_NAME=production_db_name
DB_USER=production_db_user
DB_PASSWORD=secure_production_password

MAIL_HOST=your_smtp_host
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS=noreply@your-domain.com

# Payment keys (if using)
PAYSTACK_SECRET_KEY=live_sk_xxxxx
PAYSTACK_PUBLIC_KEY=live_pk_xxxxx
```

#### 3. SSL Certificate
```bash
# Enable HTTPS redirect in .htaccess by uncommenting:
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

#### 4. File Permissions (Linux/Unix)
```bash
# Set proper permissions
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Make storage writable
chmod -R 775 storage/
chmod -R 775 public/uploads/

# Protect sensitive files
chmod 600 .env
```

#### 5. Composer (Production)
```bash
# Install dependencies without dev packages
composer install --no-dev --optimize-autoloader
```

---

### 🔒 Security Checklist

- [ ] SSL certificate installed and working
- [ ] HTTPS redirect enabled
- [ ] Database credentials are secure (not root with no password)
- [ ] All API keys are production keys (not test/demo)
- [ ] `.env` file is not accessible via web
- [ ] `storage/` directory is not accessible via web
- [ ] File upload directory has proper restrictions
- [ ] Rate limiting implemented on API endpoints
- [ ] CSRF protection is working
- [ ] Input validation on all forms

---

### 📊 Monitoring

#### Log Files Location
- Application logs: `storage/logs/app.log`
- PHP errors: `storage/logs/php_errors.log`
- Dispatch errors: `storage/logs/dispatch.log`

#### Recommended Monitoring Tools
- Error tracking: Sentry, Bugsnag, or Rollbar
- Uptime: UptimeRobot, Pingdom
- Performance: New Relic, Datadog

---

### 🔄 Deployment Commands

```bash
# 1. Pull latest code (if using Git)
git pull origin main

# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Clear any cached data
php artisan cache:clear  # If using Laravel-style cache

# 4. Run database migrations (if any)
mysql -u user -p database < database/migrations/latest.sql

# 5. Set permissions
chmod -R 775 storage/
```

---

### ⚠️ Important Notes

1. **API Keys**: The OpenAI and Judge0 API keys in the current `.env` are development keys. Replace with production keys that have appropriate rate limits and billing.

2. **Database**: Current setup uses `root` with no password. Create a dedicated MySQL user with limited privileges for production.

3. **Backups**: Set up automated daily backups of:
   - Database
   - `storage/uploads/` directory
   - `.env` file (store securely offline)

4. **Scaling**: If traffic grows, consider:
   - Redis for session/cache storage
   - CDN for static assets
   - Database read replicas

---

## 📞 Support

For deployment assistance, contact the development team.

Last updated: <?php echo date('Y-m-d'); ?>

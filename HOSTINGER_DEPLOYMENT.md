# Hostinger Deployment Guide for Nebatech Software Solutions Ltd

## Step 1: Upload ALL Files to public_html

Upload the **entire project** to:
```
/home/u948335622/domains/nebatech.com/public_html/
```

Upload these folders/files:
- `config/`
- `database/`
- `routes/`
- `src/`
- `storage/`
- `vendor/`
- `assets/` (from public folder)
- `uploads/` (from public folder)
- `js/` (from public folder)
- `.env`
- `.htaccess` (from public folder)
- `index.hostinger.php` (from public folder)
- `composer.json`

## Step 2: Rename Index File

In `public_html/`:
1. Delete or rename the existing `index.php` (if any)
2. Rename `index.hostinger.php` to `index.php`

## Step 3: Set Folder Permissions

Using File Manager or SSH:
```bash
chmod 755 /home/u948335622/domains/nebatech.com/public_html/storage
chmod 755 /home/u948335622/domains/nebatech.com/public_html/storage/logs
chmod 755 /home/u948335622/domains/nebatech.com/public_html/storage/cache
chmod 755 /home/u948335622/domains/nebatech.com/public_html/storage/uploads
chmod 755 /home/u948335622/domains/nebatech.com/public_html/uploads
chmod 600 /home/u948335622/domains/nebatech.com/public_html/.env
```

## Step 4: Import Database

1. Go to Hostinger hPanel → Databases → phpMyAdmin
2. Select database `u948335622_nebatech`
3. Click **Import**
4. Choose file: `nebatech_hostinger_export.sql`
5. Click **Go**

## Step 5: Verify .env File

Make sure `public_html/.env` has:
```
APP_URL=https://nebatech.com
DB_NAME=u948335622_nebatech
DB_USER=u948335622_nebatech_user
DB_PASSWORD=AbdulP@$$w0r_D
```

## Step 6: Enable HTTPS Redirect

In `public_html/.htaccess`, uncomment these lines:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## Final File Structure

```
/home/u948335622/domains/nebatech.com/public_html/
├── index.php                 ← Entry point (renamed from index.hostinger.php)
├── .htaccess                 ← Protects sensitive folders
├── .env                      ← Protected by .htaccess
├── composer.json
├── config/                   ← Protected by .htaccess
├── database/                 ← Protected by .htaccess
├── routes/                   ← Protected by .htaccess
├── src/                      ← Protected by .htaccess
├── storage/                  ← Protected by .htaccess
│   ├── cache/
│   ├── logs/
│   └── uploads/
├── vendor/                   ← Protected by .htaccess
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
├── js/
└── uploads/
```

## Troubleshooting

### Error: 500 Internal Server Error
- Check `/home/u948335622/nebatech-app/storage/logs/php_errors.log`
- Verify file permissions
- Check PHP version is 8.1+

### Error: Class not found
- Ensure `vendor/` folder was uploaded
- Run `composer install --no-dev` via SSH if available

### Error: Database connection failed
- Verify database credentials in `.env`
- Check database exists in Hostinger panel

## Test URLs

After deployment, test:
- https://nebatech.com/ - Home page
- https://nebatech.com/login - Login page
- https://nebatech.com/courses - Courses page

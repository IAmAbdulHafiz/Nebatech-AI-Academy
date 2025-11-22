@echo off
REM Community Platform Database Setup Script for Windows
REM Run this to set up all community tables and seed data

echo ==============================================
echo Nebatech AI Academy Community Platform Setup
echo ==============================================
echo.

REM Database credentials
set DB_HOST=localhost
set DB_NAME=nebatech_academy
set DB_USER=root
set DB_PASS=

echo Creating community tables...
mysql -h %DB_HOST% -u %DB_USER% %DB_NAME% < schema.sql

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Failed to create tables. Please check your database connection.
    pause
    exit /b 1
)

echo [SUCCESS] Community tables created!
echo.

echo Seeding initial data...
mysql -h %DB_HOST% -u %DB_USER% %DB_NAME% < seed_community.sql

if %errorlevel% neq 0 (
    echo.
    echo [ERROR] Failed to seed data.
    pause
    exit /b 1
)

echo [SUCCESS] Seed data inserted!
echo.
echo ==============================================
echo Community Platform Setup Complete!
echo ==============================================
echo.
echo What was created:
echo   - 15 new database tables
echo   - 6 discussion categories
echo   - 20 achievement badges  
echo   - XP system configured
echo.
echo Access your community at:
echo   http://localhost/Nebatech-AI-Academy/public/community
echo.
echo Next steps:
echo   1. Create your first discussion post
echo   2. Customize categories and badges
echo   3. Invite your first members
echo.
pause

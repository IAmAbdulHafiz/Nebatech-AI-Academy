<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mail Driver
    |--------------------------------------------------------------------------
    */
    'driver' => 'smtp',

    /*
    |--------------------------------------------------------------------------
    | SMTP Configuration
    |--------------------------------------------------------------------------
    | Configure your SMTP server settings below. For development, you can use
    | services like Mailtrap.io. For production, use services like SendGrid,
    | Mailgun, Amazon SES, or your own SMTP server.
    |
    | Example configurations:
    |
    | Gmail:
    | - host: smtp.gmail.com
    | - port: 587
    | - encryption: tls
    | - username: your-email@gmail.com
    | - password: your-app-password (not regular password!)
    |
    | Mailtrap (Development):
    | - host: smtp.mailtrap.io
    | - port: 2525
    | - encryption: tls
    | - username: your-mailtrap-username
    | - password: your-mailtrap-password
    |
    | SendGrid:
    | - host: smtp.sendgrid.net
    | - port: 587
    | - encryption: tls
    | - username: apikey
    | - password: your-sendgrid-api-key
    */
    'smtp' => [
        'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
        'port' => env('MAIL_PORT', 2525),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'), // tls or ssl
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default From Address
    |--------------------------------------------------------------------------
    */
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'noreply@nebatech.academy'),
        'name' => env('MAIL_FROM_NAME', 'Nebatech AI Academy'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Queue Settings
    |--------------------------------------------------------------------------
    */
    'queue' => [
        'enabled' => env('MAIL_QUEUE_ENABLED', true),
        'batch_size' => env('MAIL_QUEUE_BATCH_SIZE', 10),
        'max_attempts' => env('MAIL_QUEUE_MAX_ATTEMPTS', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Preferences
    |--------------------------------------------------------------------------
    | Default notification settings for new users
    */
    'notifications' => [
        'grades' => true,
        'enrollment' => true,
        'certificates' => true,
        'announcements' => true,
        'reminders' => true,
        'marketing' => false,
    ],
];

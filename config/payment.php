<?php

/**
 * Payment Gateway Configuration
 * 
 * Hubtel Online Checkout API integration for Ghana payments
 */

return [
    // Default payment gateway
    'default' => 'hubtel',
    
    // Currency settings
    'currency' => 'GHS',
    'currency_symbol' => 'GH₵',
    
    // Hubtel Payment Gateway
    'hubtel' => [
        // API Credentials - Get these from your Hubtel Merchant Dashboard
        'client_id' => $_ENV['HUBTEL_CLIENT_ID'] ?? '',
        'client_secret' => $_ENV['HUBTEL_CLIENT_SECRET'] ?? '',
        
        // Merchant Account Number (POS Sales ID)
        // Find yours at: https://unity.hubtel.com/account/api-keys-integrations
        'merchant_account_number' => $_ENV['HUBTEL_MERCHANT_ID'] ?? '',
        
        // Callback URL - Hubtel will POST payment status here
        'callback_url' => $_ENV['HUBTEL_CALLBACK_URL'] ?? 
            (($_ENV['APP_URL'] ?? 'http://localhost') . '/api/payments/hubtel/callback'),
        
        // Return URL - Customer redirected here after payment
        'return_url' => $_ENV['HUBTEL_RETURN_URL'] ?? 
            (($_ENV['APP_URL'] ?? 'http://localhost') . '/payments/success'),
        
        // Cancellation URL - Customer redirected here if they cancel
        'cancellation_url' => $_ENV['HUBTEL_CANCELLATION_URL'] ?? 
            (($_ENV['APP_URL'] ?? 'http://localhost') . '/payments/cancelled'),
        
        // API Endpoints
        'api_url' => 'https://payproxyapi.hubtel.com',
        'status_check_url' => 'https://api-txnstatus.hubtel.com',
        
        // Timeout for status checks (in minutes)
        'status_check_timeout' => 5,
        
        // Enable test mode (uses sandbox if available)
        'test_mode' => (bool) ($_ENV['HUBTEL_TEST_MODE'] ?? false),
    ],
    
    // Supported payment methods
    'methods' => [
        'mobile_money' => [
            'enabled' => true,
            'name' => 'Mobile Money',
            'description' => 'Pay with MTN, Vodafone, or AirtelTigo',
            'icon' => 'fas fa-mobile-alt',
            'providers' => [
                'mtn' => [
                    'name' => 'MTN Mobile Money',
                    'code' => 'mtn-gh',
                    'icon' => '/assets/images/payment/mtn-momo.png',
                ],
                'vodafone' => [
                    'name' => 'Vodafone Cash',
                    'code' => 'vodafone-gh',
                    'icon' => '/assets/images/payment/vodafone-cash.png',
                ],
                'airteltigo' => [
                    'name' => 'AirtelTigo Money',
                    'code' => 'tigo-gh',
                    'icon' => '/assets/images/payment/airteltigo.png',
                ],
            ],
        ],
        'card' => [
            'enabled' => true,
            'name' => 'Bank Card',
            'description' => 'Pay with Visa or Mastercard',
            'icon' => 'fas fa-credit-card',
        ],
        'wallet' => [
            'enabled' => true,
            'name' => 'Digital Wallet',
            'description' => 'Pay with Hubtel, G-Money, or Zeepay',
            'icon' => 'fas fa-wallet',
        ],
        'ghqr' => [
            'enabled' => true,
            'name' => 'Ghana QR',
            'description' => 'Scan and pay with any GhQR-enabled app',
            'icon' => 'fas fa-qrcode',
        ],
        'bank_transfer' => [
            'enabled' => false,
            'name' => 'Bank Transfer',
            'description' => 'Direct bank transfer (manual verification)',
            'icon' => 'fas fa-university',
        ],
    ],
    
    // Payment status mapping
    'status_map' => [
        'success' => 'completed',
        'paid' => 'completed',
        'pending' => 'pending',
        'unpaid' => 'pending',
        'failed' => 'failed',
        'cancelled' => 'cancelled',
        'refunded' => 'refunded',
    ],
    
    // Response codes
    'response_codes' => [
        '0000' => 'Success',
        '0005' => 'Payment partner failure',
        '2001' => 'Transaction failed',
        '4000' => 'Validation error',
        '4070' => 'Fees not configured',
    ],
    
    // Minimum amount for payments (in GHS)
    'minimum_amount' => 0.50,
    
    // Maximum amount for single transaction (in GHS)
    'maximum_amount' => 50000.00,
    
    // Enable payment logging
    'logging' => [
        'enabled' => true,
        'path' => __DIR__ . '/../storage/logs/payments.log',
    ],
];

<?php

namespace Nebatech\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Hubtel Payment Gateway Service
 * 
 * Integrates with Hubtel Online Checkout API for accepting payments via:
 * - Mobile Money (MTN, Vodafone, AirtelTigo)
 * - Bank Card
 * - Wallet (Hubtel, G-Money, Zeepay)
 * - GhQR
 */
class HubtelPaymentService
{
    private Client $client;
    private array $config;
    private string $baseUrl = 'https://payproxyapi.hubtel.com';
    private string $statusCheckUrl = 'https://api-txnstatus.hubtel.com';

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/payment.php';
        
        $this->client = new Client([
            'timeout' => 30,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->getAuthToken(),
                'Cache-Control' => 'no-cache'
            ]
        ]);
    }

    /**
     * Generate Base64 encoded auth token
     */
    private function getAuthToken(): string
    {
        $clientId = $this->config['hubtel']['client_id'] ?? '';
        $clientSecret = $this->config['hubtel']['client_secret'] ?? '';
        
        return base64_encode($clientId . ':' . $clientSecret);
    }

    /**
     * Initiate a payment checkout
     * 
     * @param array $paymentData Payment details
     * @return array Response with checkout URLs
     * @throws \Exception
     */
    public function initiateCheckout(array $paymentData): array
    {
        $required = ['amount', 'description', 'clientReference'];
        foreach ($required as $field) {
            if (empty($paymentData[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        // Validate amount (max 2 decimal places)
        $amount = round((float) $paymentData['amount'], 2);
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Amount must be greater than 0");
        }

        // Ensure clientReference is max 32 characters
        $clientReference = substr($paymentData['clientReference'], 0, 32);

        $payload = [
            'totalAmount' => $amount,
            'description' => $paymentData['description'],
            'callbackUrl' => $this->config['hubtel']['callback_url'],
            'returnUrl' => $paymentData['returnUrl'] ?? $this->config['hubtel']['return_url'],
            'merchantAccountNumber' => $this->config['hubtel']['merchant_account_number'],
            'cancellationUrl' => $paymentData['cancellationUrl'] ?? $this->config['hubtel']['cancellation_url'],
            'clientReference' => $clientReference,
        ];

        // Optional fields
        if (!empty($paymentData['payeeName'])) {
            $payload['payeeName'] = $paymentData['payeeName'];
        }
        if (!empty($paymentData['payeeMobileNumber'])) {
            $payload['payeeMobileNumber'] = $this->formatPhoneNumber($paymentData['payeeMobileNumber']);
        }
        if (!empty($paymentData['payeeEmail'])) {
            $payload['payeeEmail'] = $paymentData['payeeEmail'];
        }

        try {
            $response = $this->client->post($this->baseUrl . '/items/initiate', [
                'json' => $payload
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (($body['responseCode'] ?? '') !== '0000') {
                throw new \Exception($body['message'] ?? 'Payment initiation failed');
            }

            // Log successful initiation
            $this->logTransaction($clientReference, 'initiated', $payload, $body);

            return [
                'success' => true,
                'checkoutUrl' => $body['data']['checkoutUrl'] ?? null,
                'checkoutDirectUrl' => $body['data']['checkoutDirectUrl'] ?? null,
                'checkoutId' => $body['data']['checkoutId'] ?? null,
                'clientReference' => $body['data']['clientReference'] ?? $clientReference,
            ];

        } catch (GuzzleException $e) {
            error_log('Hubtel API Error: ' . $e->getMessage());
            $this->logTransaction($clientReference, 'error', $payload, ['error' => $e->getMessage()]);
            
            throw new \Exception('Payment service temporarily unavailable. Please try again.');
        }
    }

    /**
     * Check transaction status
     * 
     * @param string $clientReference The client reference of the transaction
     * @return array Transaction status details
     */
    public function checkTransactionStatus(string $clientReference): array
    {
        $merchantId = $this->config['hubtel']['merchant_account_number'];
        
        try {
            $response = $this->client->get(
                $this->statusCheckUrl . "/transactions/{$merchantId}/status",
                [
                    'query' => ['clientReference' => $clientReference]
                ]
            );

            $body = json_decode($response->getBody()->getContents(), true);

            if (($body['responseCode'] ?? '') !== '0000') {
                return [
                    'success' => false,
                    'status' => 'unknown',
                    'message' => $body['message'] ?? 'Status check failed'
                ];
            }

            $data = $body['data'] ?? [];

            return [
                'success' => true,
                'status' => strtolower($data['status'] ?? 'unknown'),
                'transactionId' => $data['transactionId'] ?? null,
                'externalTransactionId' => $data['externalTransactionId'] ?? null,
                'paymentMethod' => $data['paymentMethod'] ?? null,
                'amount' => $data['amount'] ?? 0,
                'charges' => $data['charges'] ?? 0,
                'amountAfterCharges' => $data['amountAfterCharges'] ?? 0,
                'date' => $data['date'] ?? null,
                'clientReference' => $data['clientReference'] ?? $clientReference,
            ];

        } catch (GuzzleException $e) {
            error_log('Hubtel Status Check Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Unable to check payment status'
            ];
        }
    }

    /**
     * Process callback from Hubtel
     * 
     * @param array $callbackData Raw callback data from Hubtel
     * @return array Processed callback data
     */
    public function processCallback(array $callbackData): array
    {
        $responseCode = $callbackData['ResponseCode'] ?? $callbackData['responseCode'] ?? '';
        $status = $callbackData['Status'] ?? $callbackData['status'] ?? '';
        $data = $callbackData['Data'] ?? $callbackData['data'] ?? [];

        $isSuccess = $responseCode === '0000' && strtolower($status) === 'success';

        $result = [
            'success' => $isSuccess,
            'responseCode' => $responseCode,
            'status' => strtolower($data['Status'] ?? $status),
            'checkoutId' => $data['CheckoutId'] ?? $data['checkoutId'] ?? null,
            'salesInvoiceId' => $data['SalesInvoiceId'] ?? $data['salesInvoiceId'] ?? null,
            'clientReference' => $data['ClientReference'] ?? $data['clientReference'] ?? null,
            'amount' => $data['Amount'] ?? $data['amount'] ?? 0,
            'customerPhone' => $data['CustomerPhoneNumber'] ?? $data['customerPhoneNumber'] ?? null,
            'description' => $data['Description'] ?? $data['description'] ?? null,
            'paymentDetails' => $data['PaymentDetails'] ?? $data['paymentDetails'] ?? [],
        ];

        // Log callback
        $this->logTransaction(
            $result['clientReference'] ?? 'unknown',
            'callback_' . ($isSuccess ? 'success' : 'failed'),
            $callbackData,
            $result
        );

        return $result;
    }

    /**
     * Generate a unique client reference
     * 
     * @param string $prefix Optional prefix for the reference
     * @return string Unique reference (max 32 chars)
     */
    public function generateClientReference(string $prefix = 'NAA'): string
    {
        // Format: PREFIX-YYYYMMDD-RANDOM
        $date = date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(6)), 0, 12));
        
        return substr("{$prefix}{$date}{$random}", 0, 32);
    }

    /**
     * Format phone number to international format (233XXXXXXXXX)
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle different formats
        if (str_starts_with($phone, '233')) {
            return $phone;
        }
        
        if (str_starts_with($phone, '0')) {
            return '233' . substr($phone, 1);
        }
        
        if (strlen($phone) === 9) {
            return '233' . $phone;
        }
        
        return $phone;
    }

    /**
     * Log transaction for debugging and auditing
     */
    private function logTransaction(string $reference, string $action, array $request, array $response): void
    {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'reference' => $reference,
            'action' => $action,
            'request' => $request,
            'response' => $response
        ];

        $logPath = __DIR__ . '/../../storage/logs/payments.log';
        $logLine = json_encode($logEntry) . PHP_EOL;
        
        file_put_contents($logPath, $logLine, FILE_APPEND | LOCK_EX);
    }

    /**
     * Verify webhook signature (if Hubtel provides one)
     * Currently Hubtel doesn't sign webhooks, but this is a placeholder
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        // Hubtel doesn't currently provide webhook signatures
        // This method is here for future compatibility
        return true;
    }

    /**
     * Get supported payment channels
     */
    public function getSupportedChannels(): array
    {
        return [
            'mobilemoney' => [
                'mtn-gh' => 'MTN Mobile Money',
                'vodafone-gh' => 'Vodafone Cash',
                'tigo-gh' => 'AirtelTigo Money',
            ],
            'card' => [
                'visa' => 'Visa',
                'mastercard' => 'Mastercard',
            ],
            'wallet' => [
                'hubtel' => 'Hubtel Wallet',
                'gmoney' => 'G-Money',
                'zeepay' => 'Zeepay',
            ],
            'ghqr' => [
                'ghqr' => 'Ghana QR Code',
            ]
        ];
    }

    /**
     * Check if the service is properly configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->config['hubtel']['client_id']) 
            && !empty($this->config['hubtel']['client_secret'])
            && !empty($this->config['hubtel']['merchant_account_number']);
    }
}

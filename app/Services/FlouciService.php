<?php

namespace App\Services;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FlouciService
{
    protected $client;
    protected $publicKey;
    protected $privateKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('services.flouci.public_key');
        $this->privateKey = config('services.flouci.private_key');
        $this->baseUrl = rtrim(config('services.flouci.base_url', 'https://developers.flouci.com/api/v2'), '/');

        $this->client = new Client([
            'base_uri' => $this->baseUrl . '/',
            'timeout' => 30,
            'http_errors' => false,
        ]);
    }

    public function isConfigured()
    {
        return !empty($this->publicKey) && !empty($this->privateKey)
            && !str_contains($this->publicKey, 'xxxxxxxx') && !str_contains($this->privateKey, 'xxxxxxxx');
    }

    protected function headers()
    {
        return [
            'Authorization' => 'Bearer ' . $this->publicKey . ':' . $this->privateKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Create a payment and return the checkout link.
     *
     * @return array{success: bool, payment_id?: string, link?: string, message?: string}
     */
    public function generatePayment(Order $order)
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'message' => 'Flouci is not configured.'];
        }

        $amountMillimes = (int) round($order->total_price * 1000);

        $payload = [
            'amount' => (string) $amountMillimes,
            'developer_tracking_id' => 'order_' . $order->id,
            'accept_card' => true,
            'success_link' => route('payment.result', ['order' => $order->id, 'outcome' => 'success']),
            'fail_link' => route('payment.result', ['order' => $order->id, 'outcome' => 'fail']),
            'webhook' => route('payment.webhook'),
            'session_timeout_secs' => 1800,
            'client_id' => $order->customer_name,
        ];

        try {
            $response = $this->client->post('generate_payment', [
                'headers' => $this->headers(),
                'json' => $payload,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200 || !isset($body['result']['payment_id']) || !isset($body['result']['link'])) {
                Log::error('Flouci generate_payment failed', ['status' => $statusCode, 'body' => $body]);
                return ['success' => false, 'message' => $body['result']['message'] ?? 'Payment link could not be created.'];
            }

            return [
                'success' => true,
                'payment_id' => $body['result']['payment_id'],
                'link' => $body['result']['link'],
            ];
        } catch (\Throwable $e) {
            Log::error('Flouci generate_payment exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Could not reach the payment provider.'];
        }
    }

    /**
     * Confirm whether a payment succeeded.
     *
     * @return array{success: bool, paid: bool, status?: string, message?: string}
     */
    public function verifyPayment($paymentId)
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'paid' => false, 'message' => 'Flouci is not configured.'];
        }

        try {
            $response = $this->client->get('verify_payment/' . $paymentId, [
                'headers' => $this->headers(),
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200 || empty($body['result']['status'])) {
                Log::error('Flouci verify_payment failed', ['status' => $statusCode, 'body' => $body]);
                return ['success' => false, 'paid' => false, 'message' => 'Payment verification failed.'];
            }

            $paymentStatus = strtoupper($body['result']['status']);

            return [
                'success' => true,
                'paid' => $paymentStatus === 'SUCCESS',
                'status' => $paymentStatus,
            ];
        } catch (\Throwable $e) {
            Log::error('Flouci verify_payment exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'paid' => false, 'message' => 'Could not reach the payment provider.'];
        }
    }
}

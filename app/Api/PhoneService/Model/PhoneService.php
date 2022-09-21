<?php

namespace App\Domain\Core\Api\PhoneService\Model;

use App\Domain\Core\Api\PhoneService\Error\PhoneError;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhoneService
{
    const SERVER = "notify.eskiz.uz/api/";
    public $authorization = null;

    public function authorize()
    {
        $response = Http::post(self::SERVER . "auth/login", [
            "email" => env("SMS_EMAIL"),
            "password" => env("SMS_PASSWORD")
        ]);
        if ($response->getStatusCode() == 401) {
            throw new PhoneError("Failed To Authorize to Sms channel", 401);
        }
        $response = json_decode($response->body());
        $this->authorization = $response->data->token;
    }

    private function leftOnlyIntegers($phone)
    {
        return preg_filter("/[^0-9]*/", "", $phone);
    }

    public function send_code($phone_to_send, string $message)
    {
        $secret = $this->authorization;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secret,
        ])->post(self::SERVER . 'message/sms/send', [
            'mobile_phone' => $this->leftOnlyIntegers($phone_to_send),
            'message' => $message,
            'from' => '4546'
        ]);
        $response_decoded = $response->json();
        if ($response->getStatusCode() == 401 ||
            (isset($response_decoded['status_code'])
                && $response_decoded['status_code'] == 500)) {
            $this->authorize();
            return $this->send_code($phone_to_send, $message);
        }
        if ($response->getStatusCode() == 400) {
            $message = $response->json();
            Log::info($message);
            if (isset($message['message']) && isset($message['message']['mobile_phone'])) {
                throw new PhoneError(__($message['message']['mobile_phone'][0]), 400);
            }
            throw new PhoneError($response->body(), 400);
        }
        return $response_decoded;
    }
}

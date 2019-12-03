<?php

namespace App\Validation;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {

        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params' =>
                [
                    'secret' => env('RECAPTCHA_SECRET'),
                    'response' => $value
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        Log::info($body);
        return $body->success;
    }
}
<?php

namespace App\Clients;

use Illuminate\Http\Client\Factory as HttpClient;
use Exception;

class OpenAiClient
{
    /**
     * @param HttpClient $http
     * @param string $baseUrl
     * @param string $apiKey
     * @param string $model
     */
    public function __construct(
        private readonly HttpClient $http,
        private readonly string     $baseUrl,
        private readonly string     $apiKey,
        private readonly string     $model
    ) {
    }

    /**
     * @param string $prompt
     * @param int $maxTokens
     * @param float $temperature
     * @return string
     * @throws Exception
     */
    public function requestCompletion(string $prompt, int $maxTokens = 500, float $temperature = 0.7): string
    {
        $response = $this->http->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl, [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ]);

        if ($response->failed()) {
            throw new Exception($response->body());
        }

        return $response->json('choices.0.message.content');
    }
}

<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Exception;

class OpenAIClient
{
    private string $baseUrl;
    private string $apiKey;
    private string $model;

    public function __construct() {
        $this->baseUrl = config('services.openai.url');
        $this->apiKey = config('services.openai.key');
        $this->model = config('services.openai.model');
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
        $response = Http::withHeaders([
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


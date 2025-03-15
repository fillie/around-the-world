<?php

namespace App\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

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
     * Sends a prompt to OpenAI and returns the response.
     * @throws ConnectionException
     */
    public function requestCompletion(string $prompt, int $maxTokens = 500, float $temperature = 0.7): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl, [
            'model' => $this->model,
            'prompt' => $prompt,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ]);

        if ($response->failed()) {
            return ['error' => 'Failed to generate response from OpenAI'];
        }

        return $response->json();
    }
}


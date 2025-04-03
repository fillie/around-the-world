<?php

namespace Tests\Unit\Clients;

use App\Clients\OpenAiClient;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;
use Mockery;
use Tests\TestCase;
use Exception;

class OpenAiClientTest extends TestCase
{
    public function test_request_completion_returns_ai_response()
    {
        $http = Mockery::mock(HttpClient::class);
        $response = Mockery::mock(Response::class);

        $expectedResponse = 'Hello, this is a mock response!';
        $prompt = 'Say hello';

        $http->shouldReceive('withHeaders')
            ->once()
            ->andReturnSelf();

        $http->shouldReceive('post')
            ->once()
            ->with('https://mock-api.com', Mockery::on(function ($payload) use ($prompt) {
                return $payload['model'] === 'gpt-4' &&
                    $payload['messages'][0]['content'] === $prompt;
            }))
            ->andReturn($response);

        $response->shouldReceive('failed')->andReturnFalse();
        $response->shouldReceive('json')->with('choices.0.message.content')->andReturn($expectedResponse);

        $client = new OpenAiClient(
            $http,
            'https://mock-api.com',
            'fake-key',
            'gpt-4'
        );

        $result = $client->requestCompletion($prompt);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_request_completion_throws_exception_on_failure()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('API Error');

        $http = Mockery::mock(HttpClient::class);
        $response = Mockery::mock(Response::class);

        $http->shouldReceive('withHeaders')->andReturnSelf();
        $http->shouldReceive('post')->andReturn($response);

        $response->shouldReceive('failed')->andReturnTrue();
        $response->shouldReceive('body')->andReturn('API Error');

        $client = new OpenAiClient(
            $http,
            'https://mock-api.com',
            'fake-key',
            'gpt-4'
        );

        $client->requestCompletion('Trigger error');
    }
}

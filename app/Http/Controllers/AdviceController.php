<?php

namespace App\Http\Controllers;

use App\DTOs\AdviceRequestDTO;
use App\Http\Requests\GenerateAdviceRequest;
use App\Services\AdviceService;
use Illuminate\Http\JsonResponse;


class AdviceController extends Controller
{
    public function __construct(private readonly AdviceService $adviceService) {}

    /**
     * Generate new travel advice for multiple countries and a specific date range.
     */
    public function generate(GenerateAdviceRequest $request): JsonResponse
    {
        $this->adviceService->generateAdvice(AdviceRequestDTO::fromRequest($request->all()));

        return response()->json([
            'message' => 'Travel advice generation in progress',
        ], 202);
    }
}

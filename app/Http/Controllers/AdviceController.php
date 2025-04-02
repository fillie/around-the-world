<?php

namespace App\Http\Controllers;

use App\DTOs\AdviceRequestDTO;
use App\Http\Requests\GenerateAdviceRequest;
use App\Http\Resources\AdviceResource;
use App\Models\Advice;
use App\Models\User;
use App\Services\AdviceService;
use Illuminate\Http\JsonResponse;

class AdviceController extends Controller
{
    public function __construct(private readonly AdviceService $adviceService) {}

    /**
     * Display the specified resource.
     */
    public function show(Advice $advice): JsonResponse
    {
        return response()->json([
            'data' => AdviceResource::make($advice)
        ]);
    }
    /**
     * Generate new travel advice for multiple countries and a specific date range.
     */
    public function store(GenerateAdviceRequest $request): JsonResponse
    {
        $advice = $this->adviceService->create(AdviceRequestDTO::fromRequest($request->all()), User::find(1));

        // todo fix magic method
        return response()->json([
            'message' => 'Travel advice generation in progress',
            'data' => $advice->id,
        ], 202);
    }
}

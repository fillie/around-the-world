<?php

namespace App\Http\Controllers;

use App\DTOs\VisitDTO;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Resources\VisitResource;
use App\Models\Visit;
use App\Services\VisitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VisitController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct(
        protected VisitService $visitService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => VisitResource::collection(
                $this->visitService->getAllVisits()
            )
        ]);
    }

    /**
     * Store a new visit.
     */
    public function store(StoreVisitRequest $request): JsonResponse
    {
        $visit = $this->visitService->createVisit(
            VisitDTO::fromRequest($request)
        );

        return response()->json([
            'message' => 'Visit recorded successfully.',
            'data' => VisitResource::make($visit)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit): JsonResponse
    {
        return response()->json([
            'data' => VisitResource::make($visit)
        ]);
    }

    /**
     * Update an existing visit.
     */
    public function update(StoreVisitRequest $request, Visit $visit): JsonResponse
    {
        $visit = $this->visitService->updateVisit(
            $visit,
            VisitDTO::fromRequest($request)
        );

        return response()->json([
            'message' => 'Visit updated successfully.',
            'data' => VisitResource::make($visit)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit): Response
    {
        $this->visitService->deleteVisit($visit);
        return response()->noContent();
    }
}

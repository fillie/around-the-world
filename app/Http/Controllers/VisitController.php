<?php

namespace App\Http\Controllers;

use App\DTOs\VisitDTO;
use App\Http\Requests\VisitRequest;
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
            'data' => $this->visitService->getAllVisits()
        ]);
    }

    /**
     * Store a new visit.
     *
     * @param VisitRequest $request
     * @return JsonResponse
     */
    public function store(VisitRequest $request): JsonResponse
    {
        $visit = $this->visitService->createVisit(new VisitDTO(
            user: $request->user(),
            countryId: (int) $request->input('country_id'),
            dateVisited: $request->input('date_visited'),
            lengthOfVisit: (int) $request->input('length_of_visit'),
            notes: $request->input('notes')
        ));

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
            'data' => $visit
        ]);
    }

    /**
     * Update an existing visit.
     *
     * @param VisitRequest $request
     * @param Visit $visit
     * @return JsonResponse
     */
    public function update(VisitRequest $request, Visit $visit): JsonResponse
    {
        $visit = $this->visitService->updateVisit($visit, new VisitDTO(
            user: $request->user(),
            countryId: (int) $request->input('country_id'),
            dateVisited: $request->input('date_visited'),
            lengthOfVisit: (int) $request->input('length_of_visit'),
            notes: $request->input('notes')
        ));

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

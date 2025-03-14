<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitRequest;
use App\Models\Visit;
use App\Services\VisitService;
use Illuminate\Http\JsonResponse;


class VisitController extends Controller
{
    protected VisitService $visitService;

    /**
     * Constructor.
     */
    public function __construct(VisitService $visitService)
    {
        $this->visitService = $visitService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => Visit::owned()->get()]);
    }

    /**
     * Store our visit.
     *
     * @param VisitRequest $request
     * @return JsonResponse
     */
    public function store(VisitRequest $request): JsonResponse
    {
        $visit = $this->visitService->createVisit($request->toDTO());

        return response()->json([
            'message' => 'Visit recorded successfully.',
            'data' => $visit
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Visit $visit): JsonResponse
    {
        return response()->json(['data' => $visit]);
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
        $visit = $this->visitService->updateVisit($visit, $request->toDTO());

        return response()->json([
            'message' => 'Visit updated successfully.',
            'data' => $visit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit): JsonResponse
    {
        $visit->delete();
        return response()->json([
            'message' => 'Visit deleted successfully.'
        ], 204);
    }
}

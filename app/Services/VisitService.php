<?php

namespace App\Services;

use App\DTO\VisitDTO as VisitDTO;
use App\Models\Visit as VisitModel;
use Illuminate\Support\Facades\Auth;

class VisitService
{
    /**
     * Create a new visit record.
     */
    public function createVisit(VisitDTO $visitData): VisitService
    {
        return VisitService::create([
            'user_id'        => Auth::id(),
            'country_id'     => $visitData->country_id,
            'date_visited'   => $visitData->date_visited,
            'length_of_visit'=> $visitData->length_of_visit,
            'notes'          => $visitData->notes,
        ]);
    }

    /**
     * Update an existing visit record.
     */
    public function updateVisit(VisitModel $visit, VisitDTO $visitData): VisitModel
    {
        $visit->update([
            'country_id'     => $visitData->country_id,
            'date_visited'   => $visitData->date_visited,
            'length_of_visit'=> $visitData->length_of_visit,
            'notes'          => $visitData->notes,
        ]);

        return $visit;
    }
}

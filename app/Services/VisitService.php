<?php

namespace App\Services;

use App\DTO\VisitDTO as VisitDTO;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class VisitService
{
    /**
     * Create a new visit record.
     */
    public function createVisit(VisitDTO $visitData): Visit
    {
        return Visit::create([
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
    public function updateVisit(Visit $visit, VisitDTO $visitData): Visit
    {
        $visit->update([
            'country_id'     => $visitData->country_id,
            'date_visited'   => $visitData->date_visited,
            'length_of_visit'=> $visitData->length_of_visit,
            'notes'          => $visitData->notes,
        ]);

        return $visit;
    }

    /**
     * Delete a visit.
     *
     * @param Visit $visit
     * @return void
     */
    public function deleteVisit(Visit $visit): void
    {
        $visit->delete();
    }
}

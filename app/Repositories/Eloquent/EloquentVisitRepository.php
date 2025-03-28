<?php

namespace App\Repositories\Eloquent;

use App\Models\Visit;
use App\Repositories\Contracts\VisitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentVisitRepository implements VisitRepositoryInterface
{
    /**
     * Retrieve all Visit records using the "owned" scope.
     */
    public function all(): Collection
    {
        return Visit::owned()->get();
    }

    /**
     * Create a new Visit using the provided properties.
     */
    public function create(
        int $userId,
        int $countryId,
        string $dateVisited,
        int $lengthOfVisit,
        ?string $notes
    ): Visit {
        return Visit::create([
            'user_id' => $userId,
            'country_id' => $countryId,
            'date_visited' => $dateVisited,
            'length_of_visit' => $lengthOfVisit,
            'notes' => $notes,
        ]);
    }

    /**
     * Update the given Visit with the provided properties.
     */
    public function update(
        Visit $visit,
        int $countryId,
        string $dateVisited,
        int $lengthOfVisit,
        ?string $notes
    ): Visit {
        $visit->update([
            'country_id' => $countryId,
            'date_visited' => $dateVisited,
            'length_of_visit' => $lengthOfVisit,
            'notes'  => $notes,
        ]);
        return $visit;
    }

    /**
     * Delete the given Visit record.
     */
    public function delete(Visit $visit): bool
    {
        return $visit->delete();
    }

    /**
     * Find a Visit by its ID.
     */
    public function find(int $id): ?Visit
    {
        return Visit::find($id);
    }
}

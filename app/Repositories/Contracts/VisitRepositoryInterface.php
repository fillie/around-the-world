<?php

namespace App\Repositories\Contracts;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Collection;

interface VisitRepositoryInterface
{
    /**
     * Retrieve all Visit records.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Create a new Visit using individual properties.
     *
     * @param int $userId
     * @param int $countryId
     * @param string $dateVisited
     * @param int $lengthOfVisit
     * @param string|null $notes
     * @return Visit
     */
    public function create(
        int $userId,
        int $countryId,
        string $dateVisited,
        int $lengthOfVisit,
        ?string $notes
    ): Visit;

    /**
     * Update an existing Visit using individual properties.
     *
     * @param Visit $visit
     * @param int $countryId
     * @param string $dateVisited
     * @param int $lengthOfVisit
     * @param string|null $notes
     * @return Visit
     */
    public function update(
        Visit $visit,
        int $countryId,
        string $dateVisited,
        int $lengthOfVisit,
        ?string $notes
    ): Visit;

    /**
     * Delete the given Visit.
     *
     * @param Visit $visit
     * @return bool
     */
    public function delete(Visit $visit): bool;

    /**
     * Find a Visit by its ID.
     *
     * @param int $id
     * @return Visit|null
     */
    public function find(int $id): ?Visit;
}

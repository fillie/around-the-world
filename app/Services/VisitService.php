<?php

namespace App\Services;

use App\Models\Visit;
use App\DTOs\VisitDTO;
use App\Repositories\Contracts\VisitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class VisitService
{
    /**
     * Inject the repository into the service.
     */
    public function __construct(
        private VisitRepositoryInterface $visitRepository,
    ) {}

    /**
     * Create a new Visit record using individual properties from the DTO.
     */
    public function createVisit(VisitDTO $visitDTO): Visit
    {
        return $this->visitRepository->create(
            $visitDTO->user->id,
            $visitDTO->countryId,
            $visitDTO->dateVisited,
            $visitDTO->lengthOfVisit,
            $visitDTO->notes
        );
    }

    /**
     * Update an existing Visit record using individual properties from the DTO.
     */
    public function updateVisit(Visit $visit, VisitDTO $visitDTO): Visit
    {
        return $this->visitRepository->update(
            $visit,
            $visitDTO->countryId,
            $visitDTO->dateVisited,
            $visitDTO->lengthOfVisit,
            $visitDTO->notes
        );
    }

    /**
     * Delete the specified Visit record.
     */
    public function deleteVisit(Visit $visit): bool
    {
        return $this->visitRepository->delete($visit);
    }

    /**
     * Retrieve all Visit records.
     */
    public function getAllVisits(): Collection
    {
        return $this->visitRepository->all();
    }
}

<?php

namespace App\DTOs;

use App\Http\Requests\StoreVisitRequest;
use App\Models\User;

final class VisitDTO
{
    /**
     * @param User $user
     * @param int $countryId
     * @param string $dateVisited
     * @param int $lengthOfVisit
     * @param string|null $notes #
     */
    public function __construct(
        public User $user,
        public int $countryId,
        public string $dateVisited,
        public int $lengthOfVisit,
        public ?string $notes
    ) {}

    /**
     * Create a DTO from a form request.
     *
     * @param StoreVisitRequest $request
     * @return self
     */
    public static function fromRequest(StoreVisitRequest $request): self
    {
        return new self(
            user: $request->user(),
            countryId: (int) $request->input('country_id'),
            dateVisited: $request->input('date_visited'),
            lengthOfVisit: (int) $request->input('length_of_visit'),
            notes: $request->input('notes')
        );
    }
}

<?php

namespace App\Repositories\Contracts;

use App\Models\Advice;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use DateTime;

interface AdviceRepositoryInterface
{
    /**
     * Retrieve all advice records.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Create a given advice.
     *
     * @param User $user
     * @param string $country
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return Advice
     */
    public function create(
        User $user,
        string $country,
        DateTime $startDate,
        DateTime $endDate,
    ): Advice;

    /**
     * Update a given advice.
     *
     * @param Advice $advice
     * @param string $content
     * @return Advice
     */
    public function update(
        Advice $advice,
        string $content,
    ): Advice;

    /**
     * Delete the given Visit.
     *
     * @param Advice $advice
     * @return bool
     */
    public function delete(Advice $advice): bool;

    /**
     * Find Advice by its ID.
     *
     * @param int $id
     * @return Advice|null
     */
    public function find(int $id): ?Advice;
}

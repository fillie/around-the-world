<?php

namespace App\Repositories\Eloquent;

use App\Models\Advice;
use App\Models\User;
use App\Repositories\Contracts\AdviceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use DateTime;

class EloquentAdviceRepository implements AdviceRepositoryInterface
{
    /**
     * Retrieve all Advice records using the "owned" scope.
     */
    public function all(): Collection
    {
        return Advice::owned()->get();
    }

    /**
     * Create advice.
     *
     * @param User $user
     * @param string $country
     * @param DateTime $startDate,
     * @param DateTime $endDate,
     * @return Advice
     */
    public function create(
        User $user,
        string $country,
        DateTime $startDate,
        DateTime $endDate,
    ): Advice {
        return Advice::create([
            'user_id' => $user->id,
            'country' => $country,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    /**
     * @param Advice $advice
     * @param string $content
     * @return Advice
     */
    public function update(
        Advice $advice,
        string $content,
    ): Advice {
        $advice->update([
            'content' => $content,
        ]);
        return $advice;
    }

    /**
     * @param Advice $advice
     * @return bool
     */
    public function delete(Advice $advice): bool
    {
        return $advice->delete();
    }

    /**
     * @param int $id
     * @return Advice|null
     */
    public function find(int $id): ?Advice
    {
        return Advice::find($id);
    }
}

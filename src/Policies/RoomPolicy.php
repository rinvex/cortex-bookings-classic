<?php

declare(strict_types=1);

namespace Cortex\Bookings\Policies;

use Rinvex\Fort\Models\User;
use Cortex\Bookings\Models\Room;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list rooms.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create rooms.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the room.
     *
     * @param string                                  $ability
     * @param \Rinvex\Fort\Models\User     $user
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return bool
     */
    public function update($ability, User $user, Room $room): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update rooms
    }

    /**
     * Determine whether the user can delete the room.
     *
     * @param string                                  $ability
     * @param \Rinvex\Fort\Models\User     $user
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return bool
     */
    public function delete($ability, User $user, Room $room): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete rooms
    }
}

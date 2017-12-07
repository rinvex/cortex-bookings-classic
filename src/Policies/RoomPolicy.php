<?php

declare(strict_types=1);

namespace Cortex\Bookings\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Cortex\Bookings\Contracts\RoomContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list rooms.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create rooms.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the room.
     *
     * @param string                                      $ability
     * @param \Rinvex\Fort\Contracts\UserContract         $user
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return bool
     */
    public function update($ability, UserContract $user, RoomContract $room)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update rooms
    }

    /**
     * Determine whether the user can delete the room.
     *
     * @param string                                      $ability
     * @param \Rinvex\Fort\Contracts\UserContract         $user
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, RoomContract $room)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete rooms
    }
}

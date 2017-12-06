<?php

declare(strict_types=1);

namespace Cortex\Bookings\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Rinvex\Bookings\Contracts\BookingContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list bookings.
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
     * Determine whether the user can create bookings.
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
     * Determine whether the user can update the booking.
     *
     * @param string                                     $ability
     * @param \Rinvex\Fort\Contracts\UserContract        $user
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return bool
     */
    public function update($ability, UserContract $user, BookingContract $booking)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update bookings
    }

    /**
     * Determine whether the user can delete the booking.
     *
     * @param string                                     $ability
     * @param \Rinvex\Fort\Contracts\UserContract        $user
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, BookingContract $booking)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete bookings
    }
}

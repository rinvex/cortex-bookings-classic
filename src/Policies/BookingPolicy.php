<?php

declare(strict_types=1);

namespace Cortex\Bookings\Policies;

use Rinvex\Fort\Models\User;
use Rinvex\Bookings\Models\Booking;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list bookings.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create bookings.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the booking.
     *
     * @param string                          $ability
     * @param \Rinvex\Fort\Models\User        $user
     * @param \Rinvex\Bookings\Models\Booking $booking
     *
     * @return bool
     */
    public function update($ability, User $user, Booking $booking): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update bookings
    }

    /**
     * Determine whether the user can delete the booking.
     *
     * @param string                          $ability
     * @param \Rinvex\Fort\Models\User        $user
     * @param \Rinvex\Bookings\Models\Booking $booking
     *
     * @return bool
     */
    public function delete($ability, User $user, Booking $booking): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete bookings
    }
}

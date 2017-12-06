<?php

declare(strict_types=1);

namespace Cortex\Bookings\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Cortex\Bookings\Contracts\ResourceContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list resources.
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
     * Determine whether the user can create resources.
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
     * Determine whether the user can update the resource.
     *
     * @param string                                      $ability
     * @param \Rinvex\Fort\Contracts\UserContract         $user
     * @param \Cortex\Bookings\Contracts\ResourceContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, ResourceContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update resources
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param string                                      $ability
     * @param \Rinvex\Fort\Contracts\UserContract         $user
     * @param \Cortex\Bookings\Contracts\ResourceContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, ResourceContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete resources
    }
}

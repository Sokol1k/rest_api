<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        foreach ($user->roles as $role) {
            if ($role->name == 'admin') {
                return true;
            }
        }
    }

    /**
     * Determine whether the user can view the business.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user, Business $business)
    {
        return $user->can("show post");
    }

    /**
     * Determine whether the user can create businesses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can("create post");
    }

    /**
     * Determine whether the user can update the business.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $business
     * @return mixed
     */
    public function update(User $user, Business $business)
    {
        return ($user->can("update post") && $user->id == $business->user_id);
    }

    /**
     * Determine whether the user can delete the business.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Business  $business
     * @return mixed
     */
    public function delete(User $user, Business $business)
    {
        return ($user->can("delete post") && $user->id == $business->user_id);
    }

    public function index(User $user)
    {
        return ($user->can("sort posts") || $user->can("search posts") || $user->can("show post"));
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return false;
    }

    public function index(User $user)
    {
        return false;
    }

    public function show(User $user, User $model)
    {
        return false;
    }

    public function confirm(User $user)
    {
        return false;
    }

    public function userBusinnesses(User $user, User $model)
    {
        return $user->id == $model->id;
    }
}

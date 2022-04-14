<?php

namespace App\Policies;

use App\Models\Audience;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AudiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('browse-audiences')
            ? Response::allow()
            : Response::deny('You do not have permission to browse audiences.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-audiences')
            ? Response::allow()
            : Response::deny('You do not have permission to access audiences details.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-audiences')
            ? Response::allow()
            : Response::deny('You do not have permission to add new audiences.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('edit-audiences')
            ? Response::allow()
            : Response::deny('You do not have permission to edit audiences.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-audiences')
            ? Response::allow()
            : Response::deny('You do not have permission to delete audiences.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audience  $audience
     * @return mixed
     */
    public function restore(User $user, Audience $audience)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Audience  $audience
     * @return mixed
     */
    public function forceDelete(User $user, Audience $audience)
    {
        //
    }
}

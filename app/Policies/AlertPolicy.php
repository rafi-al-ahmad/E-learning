<?php

namespace App\Policies;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class AlertPolicy
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
            return $user->hasPermission('browse-alerts')
            ? Response::allow()
            : Response::deny('You do not have permission to view public alerts.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return mixed
     */
    public function view(User $user, Alert $alert)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-alerts')
            ? Response::allow()
            : Response::deny('You do not have permission to add new public alerts.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return mixed
     */
    public function update(User $user, Alert $alert)
    {
        return $user->hasPermission('edit-any-alerts') || ($user->hasPermission('edit-alerts') && $alert->author === $user->_id)
            ? Response::allow()
            : Response::deny('You do not have permission to edit this alert.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return mixed
     */
    public function delete(User $user, Alert $alert)
    {
        return $user->hasPermission('delete-alerts')
            ? Response::allow()
            : Response::deny('You do not have permission to delete public alerts.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return mixed
     */
    public function restore(User $user, Alert $alert)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Alert  $alert
     * @return mixed
     */
    public function forceDelete(User $user, Alert $alert)
    {
        //
    }
}

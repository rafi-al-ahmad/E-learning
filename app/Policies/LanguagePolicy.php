<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
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
        return $user->hasPermission('browse-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to browse languages.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to read languages details.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('add-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to add new languages.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('edit-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to edit languages.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasPermission('delete-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to delete languages.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->hasPermission('browse-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to browse languages.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Language  $language
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->hasPermission('browse-languages')
            ? Response::allow()
            : Response::deny('You do not have permission to browse languages.');
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use TomatoPHP\FilamentLogger\Models\Activity;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
<<<<<<< HEAD
        return $user->can('view_any_activity');
=======
        // return $user->can('view_any_activity');
        return $user->hasRole('Administrator');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Activity $activity): bool
    {
<<<<<<< HEAD
        return $user->can('view_activity');
=======
        return $user->hasRole('Administrator');
        // return $user->can('view_activity');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_activity');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Activity $activity): bool
    {
        return $user->can('update_activity');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return $user->can('delete_activity');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_activity');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Activity $activity): bool
    {
<<<<<<< HEAD
        return $user->can('force_delete_activity');
=======
        return $user->can('{{ ForceDelete }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
<<<<<<< HEAD
        return $user->can('force_delete_any_activity');
=======
        return $user->can('{{ ForceDeleteAny }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Activity $activity): bool
    {
<<<<<<< HEAD
        return $user->can('restore_activity');
=======
        return $user->can('{{ Restore }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
<<<<<<< HEAD
        return $user->can('restore_any_activity');
=======
        return $user->can('{{ RestoreAny }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Activity $activity): bool
    {
<<<<<<< HEAD
        return $user->can('replicate_activity');
=======
        return $user->can('{{ Replicate }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
<<<<<<< HEAD
        return $user->can('reorder_activity');
=======
        return $user->can('{{ Reorder }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }
}

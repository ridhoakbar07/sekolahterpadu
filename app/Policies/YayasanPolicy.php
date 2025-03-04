<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Yayasan;
use Illuminate\Auth\Access\HandlesAuthorization;

class YayasanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_yayasan');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Yayasan $yayasan): bool
    {
        return $user->can('view_yayasan');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_yayasan');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Yayasan $yayasan): bool
    {
        return $user->can('update_yayasan');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Yayasan $yayasan): bool
    {
        return $user->can('delete_yayasan');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_yayasan');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Yayasan $yayasan): bool
    {
<<<<<<< HEAD
        return $user->can('force_delete_yayasan');
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
        return $user->can('force_delete_any_yayasan');
=======
        return $user->can('{{ ForceDeleteAny }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Yayasan $yayasan): bool
    {
<<<<<<< HEAD
        return $user->can('restore_yayasan');
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
        return $user->can('restore_any_yayasan');
=======
        return $user->can('{{ RestoreAny }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Yayasan $yayasan): bool
    {
<<<<<<< HEAD
        return $user->can('replicate_yayasan');
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
        return $user->can('reorder_yayasan');
=======
        return $user->can('{{ Reorder }}');
>>>>>>> 5e51920c0bfacece3891512f464b93c2323dc58c
    }
}

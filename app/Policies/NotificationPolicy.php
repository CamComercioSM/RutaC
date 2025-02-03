<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function view(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function create(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function update(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function delete(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function restore(User $user) {
        return false;
    }

    public function forceDelete(User $user) {
        return false;
    }
}

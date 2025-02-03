<?php

namespace App\Policies;

use App\Models\Aplication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AplicationPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function view(User $user, Aplication $aplication) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function create(User $user) {
        return false;
    }

    public function update(User $user, Aplication $aplication) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function delete(User $user, Aplication $aplication) {
        return false;
    }

    public function restore(User $user, Aplication $aplication) {
        return false;
    }

    public function forceDelete(User $user, Aplication $aplication) {
        return false;
    }
}

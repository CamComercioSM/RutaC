<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function view(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function create(User $user) {
        return false;
    }

    public function update(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function delete(User $user) {
        return false;
    }

    public function restore(User $user) {
        return false;
    }

    public function forceDelete(User $user) {
        return false;
    }
}

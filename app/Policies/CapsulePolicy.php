<?php

namespace App\Policies;

use App\Models\Capsule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CapsulePolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function view(User $user, Capsule $capsule) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function create(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function update(User $user, Capsule $capsule) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function delete(User $user, Capsule $capsule) {
        return $user->hasAnyRole(['superadmin']);
    }

    public function restore(User $user, Capsule $capsule) {
        return false;
    }

    public function forceDelete(User $user, Capsule $capsule) {
        return false;
    }
}

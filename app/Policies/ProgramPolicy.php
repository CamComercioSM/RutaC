<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function view(User $user, Program $program) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function create(User $user) {
        return $user->hasAnyRole(['superadmin']);
    }

    public function update(User $user, Program $program) {
        return $user->hasAnyRole(['superadmin', 'cordinator']);
    }

    public function delete(User $user, Program $program) {
        return $user->hasAnyRole(['superadmin']);
    }

    public function restore(User $user, Program $program) {
        return false;
    }

    public function forceDelete(User $user, Program $program) {
        return false;
    }
}

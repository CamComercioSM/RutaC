<?php

namespace App\Policies;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StagePolicy {
    use HandlesAuthorization;


    public function viewAny(User $user) {
        return true;
    }

    public function view(User $user, Stage $stage) {
        return true;
    }

    public function create(User $user) {
        return false;
    }

    public function update(User $user, Stage $stage) {
        return $user->hasAnyRole(['superadmin']);
    }

    public function delete(User $user, Stage $stage) {
        return false;
    }

    public function restore(User $user, Stage $stage) {
        return false;
    }

    public function forceDelete(User $user, Stage $stage) {
        return false;
    }
}

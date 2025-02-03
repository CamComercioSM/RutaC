<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function view(User $user, Company $company) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function create(User $user) {
        return false;
    }

    public function update(User $user, Company $company) {
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function delete(User $user, Company $company) {
        return $user->hasAnyRole(['superadmin']);
    }

    public function restore(User $user, Company $company) {
        return false;
    }

    public function forceDelete(User $user, Company $company) {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy {
    use HandlesAuthorization;


    public function viewAny(User $user) {
        return $user->hasAnyRole(['superadmin']);
    }


    public function view(User $user, Setting $setting) {
        return $user->hasAnyRole(['superadmin']);
    }

    public function create(User $user) {
        return false;
    }

    public function update(User $user, Setting $setting) {
        return $user->hasAnyRole(['superadmin']);
    }


    public function delete(User $user, Setting $setting) {
        //
    }

    public function restore(User $user, Setting $setting) {
        //
    }

    public function forceDelete(User $user, Setting $setting) {
        //
    }
}

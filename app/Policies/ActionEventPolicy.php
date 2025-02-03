<?php

namespace App\Policies;

use App\Models\ActionEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Nova\Actions\Action;

class ActionEventPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user) {
        return true;
    }

    public function view(User $user) {
        return true;
    }

    public function create(User $user){
        return false;
    }

    public function update(User $user){
        return false;
    }


    public function delete(User $user){
        return false;
    }

    public function restore(User $user){
        return false;
    }

    public function forceDelete(User $user){
        return false;
    }
}

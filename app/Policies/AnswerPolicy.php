<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user){
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function view(User $user, Answer $answer){
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function create(User $user){
        return $user->hasAnyRole(['superadmin', 'cordinator', 'adviser']);
    }

    public function update(User $user, Answer $answer){
        return $user->hasAnyRole(['superadmin']);
    }

    public function delete(User $user, Answer $answer){
        return $user->hasAnyRole(['superadmin']);
    }

    public function restore(User $user, Answer $answer){
        //
    }

    public function forceDelete(User $user, Answer $answer){
        //
    }
}

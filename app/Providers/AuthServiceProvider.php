<?php

namespace App\Providers;

use App\Models\Alert;
use App\Models\Aplication;
use App\Models\Lead;
use App\Models\Notification;
use App\Nova\Answer;
use App\Nova\Capsule;
use App\Nova\Company;
use App\Nova\Program;
use App\Nova\Section;
use App\Nova\Setting;
use App\Nova\Stage;
use App\Nova\User;
use App\Policies\AlertPolicy;
use App\Policies\AplicationPolicy;
use App\Policies\CapsulePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\LeadPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\SectionPolicy;
use App\Policies\SettingPolicy;
use App\Policies\StagePolicy;
use App\Policies\UserPolicy;
use App\Policies\AnswerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
    protected $policies = [
        User::class => UserPolicy::class,
        Stage::class => StagePolicy::class,
        Program::class => ProgramPolicy::class,
        Capsule::class => CapsulePolicy::class,
        Company::class => CompanyPolicy::class,
        Setting::class => SettingPolicy::class,
        Answer::class => AnswerPolicy::class,
        Aplication::class => AplicationPolicy::class,
        Notification::class => NotificationPolicy::class,
        Lead::class => LeadPolicy::class,
        Alert::class => AlertPolicy::class,
        Section::class => SectionPolicy::class,
    ];

    public function boot() {
        $this->registerPolicies();
    }
}

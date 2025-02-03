<?php

namespace App\Nova\Menu;

use App\Nova\Alert;
use App\Nova\Answer;
use App\Nova\Aplication;
use App\Nova\Banner;
use App\Nova\Capsule;
use App\Nova\Company;
use App\Nova\Lead;
use App\Nova\Link;
use App\Nova\Notification;
use App\Nova\Program;
use App\Nova\Section;
use App\Nova\Setting;
use App\Nova\Stage;
use App\Nova\User;
use App\Nova\UserCompany;
use App\Nova\Variable;
use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\InternalLink;
use DigitalCreative\CollapsibleResourceManager\Resources\NovaResource;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Illuminate\Support\Facades\Auth;

class Menu {
	public static function init(){
		return new CollapsibleResourceManager([
			'disable_default_resource_manager' => true,
			'remember_menu_state'              => true,
			'navigation'                       => [
                TopLevelResource::make([
                    'icon'      => Icon::World(),
                    'label'     => 'Gestionar',
                    'expanded'  => true,
                    'resources' => [
                        Company::class,
                        Answer::class,
                        Aplication::class,
                        Notification::class,
                        UserCompany::class,
                        Lead::class,
                        Alert::class,
                    ],
                ]),
                TopLevelResource::make([
                    'icon'      => Icon::World(),
                    'label'     => 'Sitio Web',
                    'expanded'  => true,
                    'resources' => [
                        Banner::class,
                        NovaResource::make(Section::class)->detail(1)->label('Pagina principal'),
                    ],
                ]),
                TopLevelResource::make([
                    'icon'      => Icon::Manage(),
                    'label'     => 'Configurar',
                    'expanded'  => true,
                    'resources' => [
                        Program::class,
                        Capsule::class,
                        NovaResource::make(Stage::class)->canSee(function (){
                            return Auth::user()->hasAnyRole(['superadmin']);
                        }),
                        NovaResource::make(Variable::class)->canSee(function (){
                            return Auth::user()->hasAnyRole(['superadmin']);
                        }),
                        User::class,
                        NovaResource::make(Setting::class)->canSee(function (){
                            return Auth::user()->hasAnyRole(['superadmin']);
                        }),
                    ],
                ]),
			]
		]);
	}

}

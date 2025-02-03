<?php

namespace App\Nova\Filters;

use App\Models\Company;
use App\Models\Program;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ByCompany extends Filter {
    public $component = 'select-filter';
    public $name = 'Empresa';

    public function apply(Request $request, $query, $value) {
        return $query->where('company_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request) {
        return Company::all()->pluck('id', 'business_name')->toArray();
    }
}

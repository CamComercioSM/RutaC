<?php

namespace App\Nova\Filters;

use App\Models\Program;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class ByProgram extends Filter {
    public $component = 'select-filter';
    public $name = 'Programa';

    public function apply(Request $request, $query, $value) {
        return $query->where('program_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request) {
        return Program::all()->pluck('id', 'name')->toArray();
    }
}

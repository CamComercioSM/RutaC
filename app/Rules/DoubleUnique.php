<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DoubleUnique implements Rule
{
    private $anotherColumn;
    private $anotherValue;
    private $column;
    private $model;
    private $exceptColumn;
    private $exceptId;

    /**
     * Create a new rule instance.
     *
     * @param string $model
     * @param string $column
     * @param string $anotherColumn
     * @param string $anotherValue
     * @param string|null $exceptColumn
     * @param string|null $exceptId
     */
    public function __construct(
        string $model,
        string $column,
        string $anotherColumn,
        string $anotherValue,
        string $exceptColumn = null,
        string $exceptId = null
    ) {
        $this->model = $model;
        $this->column = $column;
        $this->anotherColumn = $anotherColumn;
        $this->anotherValue = $anotherValue;
        $this->exceptColumn = $exceptColumn;
        $this->exceptId = $exceptId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $exist = $this->model::where($this->column, $value)->where($this->anotherColumn, $this->anotherValue);

        if (null !== $this->exceptColumn) {
            $exist = $exist->where($this->exceptColumn, '<>', $this->exceptId);
        }

        $exist = $exist->first();

        if ($exist) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.unique');
    }
}

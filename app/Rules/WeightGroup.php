<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WeightGroup implements Rule
{
    private $model;
    private $anotherColumn;
    private $anotherValue;
    private $column;
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
        $this->anotherColumn = $anotherColumn;
        $this->anotherValue = $anotherValue;
        $this->column = $column;
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
        $weight = $this->model::where($this->anotherColumn, $this->anotherValue);

        if (null !== $this->exceptColumn) {
            $weight = $weight->where($this->exceptColumn, '<>', $this->exceptId);
        }

        $weight = $weight->sum($this->column);

        if (($weight + $value) > 100) {
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
        return 'La suma de los pesos entre todas las secciones debe ser menor o igual a 100';
    }
}

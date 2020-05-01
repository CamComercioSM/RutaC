<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class RutaCException extends Exception
{
    protected $code;
    protected $route;
    protected $message;

    public function __construct($route, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
        $this->route = $route;
        $this->message = $message;
    }

    public function render()
    {
        Log::error($this->code." => ".$this->message);

        return redirect()->route($this->route)->with([
            'error' => __('Ocurrió un error. ['.$this->code.']'),
        ]);
    }
}

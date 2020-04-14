<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class RutaCException extends Exception
{
    protected $code;
    protected $message;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = $code;
        $this->message = $message;
    }

    public function render()
    {
        Log::error($this->code." => ".$this->message);

        return redirect()->route('user.ruta.iniciar-ruta')->with([
            'error' => __('Ocurrió un error. ['.$this->code.']'),
        ]);
    }
}

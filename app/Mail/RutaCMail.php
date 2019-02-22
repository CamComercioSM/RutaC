<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class RutaCMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data, $context, $extra_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $context, $extra_data = [])
    {
        $this->data = $data;
        $this->context = $context;
        $this->extra_data = $extra_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        switch($this->context){
            case 'registro_usuario':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Bienvenido a RutaC')
                ->view('rutac.mails.sign_up_email')->withData($this->data);
            break;
            case 'reenvio_codigo':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Codigo de verificación Ruta C')
                ->view('rutac.mails.verify_email')->withData($this->data);
            break;
            case 'restablecer_clave':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Bienvenido a RutaC')
                ->view('rutac.mails.reset_password')->withData($this->data);
            break;
            case 'fin_diagnostico':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Diagnóstico finalizado')
                ->view('rutac.mails.fin_diagnostico')->withData($this->data);
            break;
            case 'ruta_completa':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Ruta completada')
                ->view('rutac.mails.ruta_completa')->withData($this->data);
            break;
            case 'nuevo_administrador':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Ha sido creado como administrador')
                ->view('administrador.mails.nuevo_administrador')->withData($this->data);
            break;
            case 'actualizacion_datos':
                return $this->to($this->data->usuarioEMAIL)
                ->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena')
                ->subject('Actualización de datos')
                ->view('rutac.mails.actualizacion_datos')->withData($this->data);
            break;
        }
    }
}

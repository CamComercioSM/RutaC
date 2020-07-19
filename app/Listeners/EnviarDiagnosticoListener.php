<?php

namespace App\Listeners;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class EnviarDiagnosticoListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $pdf = PDF::loadView('layouts/emails/templates/fin_diagnostico_pdf', $event->diagnostico->toArray());

        Mail::send('rutac.mails.fin_diagnostico', $user->toArray(), function ($mail) use ($pdf, $user) {
            $mail->from(env('NOTIFY_EMAIL'), 'RutaC - Cámara de Comercio de Santa Marta para el Magdalena');
            $mail->to($user->usuarioEMAIL);
            $mail->subject('Diagnóstico finalizado');
            $mail->attachData($pdf->output(), 'Resultado del Diagnóstico.pdf');
        });
    }
}

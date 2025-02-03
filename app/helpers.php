<?php

namespace App;

use App\Models\Alert;
use App\Models\Company;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Municipality;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Stage;
use App\Models\Variable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class helpers {

    static function maskPartialInfo($string) {
        $ini = substr($string, 0, 4);
        $last = substr($string, -4);
        return $ini . '********' . $last;
    }

    static function validateUpdateInfo() {
        $company = Company::find(Auth::user()->company_id);

        if ($company->update_info == 0)
            return false;

        return true;
    }

    static function validateCompleteDiagnostic() {
        $company = Company::find(Auth::user()->company_id);

        if ($company->complete_diagnostic == 0)
            return false;

        return true;
    }

    static function validarDiagnosticoHace($dias = 365) {
        $company = Company::find(Auth::user()->company_id);
        if ($company->complete_diagnostic == 0)
            return false;
        else {
            // Comparamos si el ultimo diagnostico ha sido realizado hace mas de un año
            $diagnostic = $company->diagnostics()->orderBy('id', 'desc')->first();
            $date_diagnostic = $diagnostic->created_at;
            $date_now = Carbon::now();
            $diasDesdeDiagnostic = $date_now->diffInDays($date_diagnostic);
            if ( $diasDesdeDiagnostic  >= $dias)
                return true;
        }
        return false;
    }

    static function getMyCompany() {

        if (!Auth::check())
            return false;

        $company = Company::find(Auth::user()->company_id);
        return $company;
    }

    static function getAnualSalesWeight($value) {
        $variable_weight = 0.5;
        $answers = [
            0 => 30,
            1 => 55,
            2 => 80,
            3 => 110
        ];
        return $answers[$value] * $variable_weight;
    }

    static function getDiagnosticScore($debug = false) {
        //Definimos los dos grupos principales de variables para luego sumar los pesos de cada variable a su respectivo grupo
        $variable_group_0 = 0;
        $variable_group_1 = 0;
        $company = self::getMyCompany();

        if ($debug)
            dump('ventas: ' . helpers::getAnualSalesWeight($company->anual_sales));

        //calculamos el peso de las ventas y lo asignamos al grupo 0
        $variable_group_0 += helpers::getAnualSalesWeight($company->anual_sales);

        //recorremos las respuestas del ultimo diagnostico

        $answers = $company->diagnostics->last()->answers;

        foreach ($answers as $answer) {
            //Realizamos el calculo para determinar el peso de la respuesta
            $variable = $answer->variable;
            $variable_percentaje = $variable->percentage / 100;
            $answer_percentage = $variable->values[$answer->value]['attributes']['percentage'];
            $answer_weight = $variable_percentaje * $answer_percentage;

            if ($debug)
                dump($answer->variable->name . ': ' . $answer_weight);

            //sumamos el peso de la respuesta al grupo correspondiente
            $variable->variable_group == 0 ? $variable_group_0 += $answer_weight : $variable_group_1 += $answer_weight;
        }

        //obtenemos el calculo final segun los pesos de cada variable
        return ($variable_group_0 * 0.5) + ($variable_group_1 * 0.5);
    }

    static function getStage($value) {
        if ($value <= 1) {
            return 1; //Descubrimiento
        } else if ($value <= 30) {
            return 2; //Nacimiento
        } else if ($value <= 50) {
            return 3; //Despegue
        } else if ($value <= 75) {
            return 4; //Crecimiento
        } else {
            return 5; //Madurez
        }
    }    
    
    static function nombreEtapa($etapaID) {                
        $stage = Stage::find($etapaID);
        return $stage->name;
    }

    static function getStageLabel() {
        $last_diagnostic = self::getMyCompany()->diagnostics->last();
        $stage_id = self::getStage($last_diagnostic->score);
        $stage = Stage::find($stage_id);
        return $stage->name;
    }

    static function getSettingValue($value) {
        $setting = Setting::where('type', $value)->first();
        return $setting->value;
    }

    static function disablePoll(): bool {
        $company = self::getMyCompany();
        $company->show_poll = 0;
        $company->save();
        return true;
    }

    static function getHelperInfo() {
        $notifications = Notification::orderBy('sort_order', 'asc')->get();
        return $notifications;
    }

    public function getMunicipalities(Request $request) {
        $municipalities = Municipality::where('department_id', $request->id)->orderBy('name', 'asc')->get();
        return $municipalities;
    }

    public static function validateLastRenovation($date_register, $last_renovation, $company_id) {
        $date_register = date_create_from_format('Ymd', $date_register);
        $last_renovation = date_create_from_format('Ymd', $last_renovation);

        $diff = date_diff($date_register, $last_renovation);

        // Si la empresa lleva mas de 2 años registrada, se debe crear una alerta de tipo 2
        if ($diff->y > 2)
            self::createAlertCompany(2, $company_id);
    }
    /*
     * Valide si la ultima fecha de renovacion de camara de comercio esta vigente
     * Siempre vencen los 30 de marzo de cada año
     */

    public static function validateRenovation($last_renovation) {
        $actual_date = date_create();

        // Capturamos cuando es la proxima fecha de renovacion
        $renovation_date = date_create_from_format('Ymd', date('Y') . '0330');
        if ($actual_date > $renovation_date)
            $renovation_date->add(new \DateInterval('P1Y'));

        $last_renovation = date_create_from_format('Ymd', $last_renovation);
        $next_renovation = $last_renovation->modify('+1 year');

        return $next_renovation >= $renovation_date;
    }

    public static function createAlertCompany($kind, $company_id) {
        //Validamos primero si la alerta ya existe, para no volverla a crear
        $validate = Alert::where('kind', $kind)->where('company_id', $company_id)->first();
        if ($validate)
            return true;

        $alert = New Alert();
        $alert->company_id = $company_id;
        $alert->kind = $kind;
        $alert->save();
        return true;
    }

    public static function sendMail($to, $subject, $template, $data) {
        try {
            Mail::send($template, ['data' => $data], function ($m) use ($to, $subject) {
                $m->from(env('MAIL_FROM_ADDRESS'), 'Ruta de crecimiento');
                $m->to($to)->subject($subject);
                $m->to('rutac@ccsm.org.co')->subject($subject);
            });
        } catch (\Exception $e) {
            dd($e);
        }
    }

    //Función para obtener el embedido de youtube
    public static function getYouTubeVideoID($url) {
        // Patrón de expresión regular para extraer el ID del video de diferentes formatos de URL de YouTube
        $pattern = '/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})(?:[&?].*)?$/';

        // Intentamos encontrar una coincidencia con el patrón en la URL proporcionada
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1]; // Devuelve el ID del video
        } else {
            // Si no se encuentra ninguna coincidencia con el patrón, la URL es inválida
            return false;
        }
    }
}
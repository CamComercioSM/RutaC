<?php

namespace App\Http\Controllers;

use App\helpers;
use App\Models\Answer;
use App\Models\Aplication;
use App\Models\Capsule;
use App\Models\Company;
use App\Models\Department;
use App\Models\Diagnostic;
use App\Models\Link;
use App\Models\Municipality;
use App\Models\Program;
use App\Models\Section;
use App\Models\Stage;
use App\Models\User;
use App\Models\Variable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller {

    public function login() {
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();

        if (Auth::check()) {
            if (Auth::user()->hasAnyRole('superadmin'))
                return redirect()->route('nova.login');

            if (!helpers::validateUpdateInfo())
                return redirect()->route('company.complete_info');

            if (!helpers::validateCompleteDiagnostic())
                return redirect()->route('company.diagnostic');

            return redirect()->route('company.dashboard');
        }

        return view('website.company.login', compact('footer', 'links'));
    }

    public function loginProcess(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email o contraseña incorrecta. Valide e intente nuevamente');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Email o contraseña incorrecta. Valide e intente nuevamente');
        }

        //valide si tiene una empresa vinculada y no ha sido borrada desde administrador de contenido
        $company = Company::find($user->company_id);
        if (!$company)
            return redirect()->back()->with('error', 'La empresa solicitada ha sido inhabilitada desde nuestro sistema. Favor comunicarse con servicio al cliente.');

        Auth::login($user);

        if (!helpers::validateUpdateInfo())
            return redirect()->route('company.complete_info');

        if (!helpers::validateCompleteDiagnostic())
            return redirect()->route('company.diagnostic');

        return redirect()->route('company.dashboard');
    }

    public function completeInfo() {
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        $company = Auth::user()->company;
        $departments = Department::orderBy('name', 'asc')->get();
        $municipalities = Municipality::orderBy('name', 'asc')->get();

        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
        $ConexionSICAM = new ('ApiSICAM' . $class);

        $api = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'listadoViculosCargos');
        $api = json_decode($api);
        $listaCargos = $api->DATOS;

        return view('website.company.complete_info', compact('company', 'departments', 'municipalities', 'listaCargos', 'footer', 'links'));
    }

    public function completeInfoSave(Request $request) {

        $company = Company::find(Auth::user()->company_id);
        $company->department_id = $request->department;
        $company->municipality_id = $request->municipality;
        $company->address = $request->address;
        $company->telephone = $request->telephone;
        $company->mobile = $request->mobile;

        $company->contact_person = $request->contact_person;
        $company->contact_position = $request->contact_position;
        $company->contact_email = $request->contact_email;
        $company->contact_phone = $request->contact_phone;

        $company->website = $request->website;
        $company->social_instagram = $request->social_instagram;
        $company->social_facebook = $request->social_facebook;
        $company->social_linkedin = $request->social_linkedin;

        //preguntamos a google por la ubicacion
        $municipality = Municipality::find($request->municipality);
        $deparment = Department::find($request->department);
        $address = $request->address . ',' . $municipality->name . ',' . $deparment->name;
        $address = str_replace(' ', '+', $address);
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyCPqpt_YwJzrvm0CuQndesni_zZ_8GTDUA';
        $response = json_decode(file_get_contents($url));
        if (isset($response->results[0])) {
            $lat = $response->results[0]->geometry->location->lat;
            $lng = $response->results[0]->geometry->location->lng;
            $company->geolocation = $lat . ',' . $lng;
        }

        //Marco el proceso de registro como completado
        $company->update_info = 1;
        $company->save();

        if ($company->tipo_registro_rutac == 'FORMAL_MAGDALENA') {//
//      $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
//      $ConexionSICAM = new ('ApiSICAM' . $class);
////    $ConexionSICAM::$MODO_PRUEBAS = true;
////        $ConexionSICAM::$MOSTRAR_RESPUESTA_API  = true;
//      $RespuestaAPI = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'crearUnidadProductiva', [
//          'tipoPersonaRUTAC' => $company->tipoPersonaID,
//          'tipoPersonaCODIGO' => Company::$types[$company->type_person],
//          'tipoIdentificacionID' => $request->tipo_identificacion,
//          'personaIDENTIFICACION' => $request->document,
//          'personaRAZONSOCIAL' => $values->nombrerl,
//          'personaNOMBRES' => null,
//          'personaAPELLIDOS' => null,
//          'correoDIRECCION' => $request->email,
//          'telefonoNUMEROCELULAR' => $request->telcom1,
//          'direccionCOMERCIALDEPARTAMENTO' => $request->department,
//          'direccionCOMERCIALMUNICIPIO' => $request->municipality,
//          'direccionCOMERCIAL' => $request->dircom,
//          'unidadProductivaTIPOREGISTRORUTAC' => Company::$tipo_registro_rutac[3],
//          'unidadProductivaTIPOREGISTRORUTACID' => 3,
//          'unidadProductivaFCHINICIO' => $request->registration_date,
//          'unidadProductivaTITULO' => $request->business_name,
//          'unidadProductivaDESCRIPCION' => $request->description,
//          'unidadProductivaEMAIL' => $request->email,
//          'unidadProductivaENLACE' => $request->dircom,
//          'unidadProductivaTELEFONO' => $request->telcom1,
//          'departamentoID' => $request->department,
//          'municipioID' => $request->municipality,
//          'unidadProductivaDIRECCION' => $request->address,
//          'unidadProductivaCONTACTONOMBRE' => ($request->personaNOMBRES . " " . $request->personaAPELLIDOS),
//          'unidadProductivaCONTACTOEMAIL' => $request->email,
//          'unidadProductivaCONTACTOTELEFONO' => $request->phone,
//          'unidadProductivaCAMARADECOMERCIO' => $request->camara_comercio,
//          'unidadProductivaMATRICULA' => $request->registration_number,
//          'unidadProductivaFCHMATRICULA' => $request->registration_date,
//          'unidadProductivaNIT' => $request->nit,
//          'unidadProductivaREPRESENTANTELEGAL' => $request->name_legal_representative,
//          'REQUEST1' => $request->toArray(),
//      ]);
        }

        // Enviamos notificacion de email al correo corporativo
        helpers::sendMail($company->registration_email, 'Solicitud de registro', 'website.mail.company_register', $company);

        return redirect()->route('company.diagnostic');
    }

    public function diagnostic(Request $request) {

        //Validamos que el usuario este logueado de lo contrario lo manda a iniciar sesion
        if (!Auth::check())
            return redirect()->route('company.login');

        $arranquePOR = "NO";
        $company = helpers::getMyCompany();
        if (!helpers::validateCompleteDiagnostic()) {
            $arranquePOR = "NUEVO";
        }
        if (helpers::validarDiagnosticoHace()) {
            $arranquePOR = "ANUAL";
        }

        $section = Section::find(1);
        $json_data = json_decode($section->data);
//    print_r($json_data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        $variables = null;
        $sells = null;

        if ($request->sells)
            $sells = $request->sells;

        if ($request->sells == 'ventas')
            $variables = Variable::where('related_to', 0)->get();

        if ($request->sells == 'sin-ventas')
            $variables = Variable::where('related_to', 0)->where('related_to_sells', 0)->get();

        return view('website.company.diagnostic', compact('variables', 'sells', 'footer', 'links', 'arranquePOR', 'company'));
    }

    public function saveDiagnostic(Request $request) {

        $tipo_diagnostico = $request->sells;

        //Obtenemos la empresa que vamos actualizar
        $company = helpers::getMyCompany();

        // Creamos un nuevo diagnostico con el score temporalmente en 0. Luego se actualizara con el score final
        $diagnostic = New Diagnostic();
        $diagnostic->company_id = $company->id;
        $diagnostic->score = 0;
        $diagnostic->save();

        if ($tipo_diagnostico == 'ventas') {
            //Guardamos las ventas anuales
            $company->anual_sales = $request->anual_sales;
            $company->save();
        }

        /*
         * Borramos del array request las variables anual_sales y token para dejar solo variables
         * Luego las recorremos y las guardamos en la db
         */
        if ($tipo_diagnostico == 'ventas') {
            unset($request['anual_sales']);
        }
        unset($request['_token']);
        unset($request['sells']);

        foreach ($request->all() as $key => $value) {

            $variable_id = str_replace('variable-', '', $key);

            $answer = New Answer();
            $answer->company_id = $company->id;
            $answer->diagnostic_id = $diagnostic->id;
            $answer->variable_id = $variable_id;
            $answer->value = $value;
            $answer->save();

            if ($tipo_diagnostico == 'ventas') {
                // Si el crecimiento de la empresa ha sido mayor al 10%
                if ($variable_id == 3 && $value == 3)
                    helpers::createAlertCompany(1, $company->id);
            }
        }

        // Si tiene ventas capturamos el diagnostico
        if ($tipo_diagnostico == 'ventas') {
            $score = \App\helpers::getDiagnosticScore();
            $company->stage_id = helpers::getStage($score);
        } else {
            $score = 0;
            $company->stage_id = 1;
        }

        //Guardamos que completo el diagnostico
        $company->complete_diagnostic = 1;
        $company->save();

        //Guardamos el score en el ultimo diagnostico
        $diagnostic->score = $score;
        $diagnostic->stage_id = $company->stage_id;
        $diagnostic->save();

        return redirect()->route('company.dashboard');
    }

    public function dashboard(Request $request) {

        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();

        $company = helpers::getMyCompany();

        if ($company == null)
            return redirect()->route('home')->with('error', 'No se pudo obtener la información de la empresa');

        if ($company == false)
            return redirect()->route('company.login');

        if (!helpers::validateUpdateInfo())
            return redirect()->route('company.complete_info');

        if (!helpers::validateCompleteDiagnostic())
            return redirect()->route('company.diagnostic');

        if (helpers::validarDiagnosticoHace())
            return redirect()->route('company.diagnostic');

        $activarDIAGVOLUNTARIO = false;
        if (helpers::validarDiagnosticoHace(30))
            $activarDIAGVOLUNTARIO = true;

        $debug = $request->debug;
        $stages = Stage::all();

        // Cargamos las notificaciones
        $helper_default = null;
        $helper_notifications = helpers::getHelperInfo();
        if (count($helper_notifications) == 0) {
            $helper_default = [
                'title' => 'Bienvenido',
                'message' => 'Te invitamos a seleccionar una opción del panel lateral izquierdo. En el menú principal, puedes seleccionar entre visualizar perfil, programas, cápsulas o cerrar sesión.',
            ];
        }


        $company = Company::find($company->id);
        foreach ($company->diagnostics as $key => $value) {
            if (is_null($value->stage_id)) {
                $value->stage_id = helpers::getStage($value->score);
            }
            $value->etapaNOMBRE = helpers::nombreEtapa($value->stage_id);
        }


        $dimensions = json_encode(Variable::$dimension);
        $diagnostic = $company->diagnostics->last();
        $results = [];

        foreach (Variable::$dimension as $key => $value) {
            $variables = Variable::where('related_to', 0)->where('dimension', $key)->get();
            $variables_count = count($variables);
            $int = 0;

            // Si estamos en la dimension comercial
            if ($key == 0) {
                // Cargamos la primera respuesta de la cantidad de ventas
                if ($company->anual_sales == 0)
                    $int += 2;
                elseif ($company->anual_sales == 1)
                    $int += 3;
                elseif ($company->anual_sales == 2)
                    $int += 4;
                else
                    $int += 5;

                //dump('Ventas - '.$int);
            }

            foreach ($variables as $variable) {
                //TODO hay que analizar variables que no estan unidas a la dimension
                if ($variable->id == 2)
                    continue;

                $answer = Answer::where('variable_id', $variable->id)->where('diagnostic_id', $diagnostic->id)->first();

                if (is_null($answer))
                    continue;

                $value = $answer->value;

                /*
                 * Cuando son variables que tienen solo 3 opciones de respuestas.
                 * Se debe ajustar ya que al no cumplir la regla de 5, debe promediarse de manera diferente
                 */
                if (count($variable->values) == 3) {
                    if ($value == 0)
                        $value = 2;
                    else if ($value == 1)
                        $value = 3;
                    else
                        $value = 5;
                }

                /*
                 * Cuando son variables que tienen solo 4 opciones de respuestas.
                 * Se debe ajustar ya que al no cumplir la regla de 5, debe promediarse de manera diferente
                 */
                if (count($variable->values) == 4) {
                    if ($value == 0)
                        $value = 1;
                    else if ($value == 1)
                        $value = 3;
                    else if ($value == 2)
                        $value = 4;
                    else
                        $value = 5;
                }

                if (count($variable->values) == 5) {
                    $value = $value > 0 ? $value + 1 : 1;
                }

                $int += $value;

                //dump($key.' -'.$variable->name.' - '.$value);
            }

            // Se suma 1 a la cantidad de variables, ya que son el total + la pregunta inicial de ventas
            $results[] = $int / $variables_count;
        }

        //Orden de los datos => "Comercial","Eficiencia","Innovacicion","Gestion Administrativa","Talento Humano"
        $results = json_encode($results);

        return view('website.company.dashboard',
          compact('company', 'debug', 'stages', 'helper_notifications', 'helper_default', 'footer', 'links', 'dimensions', 'results', 'activarDIAGVOLUNTARIO')
        );
    }

    public function profile() {
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        $company = helpers::getMyCompany();
        if ($company->comercial_activity) {
            $actividad = \App\Models\CiiuActividades::porCODIGO($company->comercial_activity)->get();
            $company->nombre_actividad = $actividad[0]->ciiuActividadTITULO;
        }
        $user = Auth::user();

        // Cargamos las notificaciones
        $helper_default = null;
        $helper_notifications = helpers::getHelperInfo();
        if (count($helper_notifications) == 0) {
            $helper_default = [
                'title' => 'Recomendación para la sección de perfil',
                'message' => 'Te invitamos a presionar algunas de las opciones de actualizar perfil o actualizar contraseña. Recuerda mantener actualizados los datos de tu empresa.',
            ];
        }


        // Buscamos todos los programas que esten relacionadas con la etapa en la que se encuentra la empresa
        $programas_inscrito = Program::whereHas('applications', function ($query) use ($company) {
              $query->where('company_id', $company->id);
          })->get();

        return view('website.company.profile', compact('company', 'user', 'helper_notifications', 'helper_default', 'footer', 'links', 'programas_inscrito'));
    }

    public function profileUpdate() {
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        $company = helpers::getMyCompany();
        $departments = Department::all();
        $municipalities = Municipality::all();
        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
        $ConexionSICAM = new ('ApiSICAM' . $class);

        $api = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'listadoViculosCargos');
        $api = json_decode($api);
        $listaCargos = $api->DATOS;
        return view('website.company.profile_update', compact('company', 'departments', 'municipalities', 'listaCargos', 'footer', 'links'));
    }

    public function profileSave(Request $request) {
        $company = Company::find(Auth::user()->company_id);

        $company->description = $request->description;

        $company->department_id = $request->department;
        $company->municipality_id = $request->municipality;
        $company->address = $request->address;
        $company->telephone = $request->telephone;
        $company->mobile = $request->mobile;

        $company->contact_person = $request->contact_person;
        $company->contact_position = $request->contact_position;
        $company->contact_email = $request->contact_email;
        $company->contact_phone = $request->contact_phone;

        $company->website = $request->website;
        $company->social_instagram = $request->social_instagram;
        $company->social_facebook = $request->social_facebook;
        $company->social_linkedin = $request->social_linkedin;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $name = time() . '-' . $file->getClientOriginalName();
            $file->move(storage_path() . '/app/public/logos/', $name);
            $company->logo = $name;
        }

        $company->save();

        return redirect()->route('company.profile')->with('success', 'Información actualizada correctamente');
    }

    public function passwordUpdate() {
        return view('website.company.password_update');
    }

    public function passwordSave(Request $request) {
        $user = Auth::user();

        if (!Hash::check($request->password_old, $user->password))
            return redirect()->back()->with('error', 'La contraseña actual no es correcta');

        if ($request->password != $request->password_confirm)
            return redirect()->back()->with('error', "El campo de contraseña y confirmar contraseña, deben ser iguales");

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(route('company.profile'))->with('success', "Contraseña actualizada correctamente");
    }

    public function programs() {
        $company = helpers::getMyCompany();
        $user = Auth::user();
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();

        // Buscamos todos los programas que esten relacionadas con la etapa en la que se encuentra la empresa
        $programas_inscrito = Program::whereHas('applications', function ($query) use ($company) {
              $query->where('company_id', $company->id);
          })->where('convocatoriaFCHAPERTURA', '<=', date('Y-m-d'))->get();

        // Buscamos todos los programas que esten relacionadas con la etapa en la que se encuentra la empresa
        $programs_recommend = Program::whereHas('stages', function ($query) use ($company) {
              $query->where('stage_id', $company->stage_id);
          })->where('convocatoriaFCHAPERTURA', '<=', date('Y-m-d'))->where('convocatoriaFCHCIERRE', '>=', date('Y-m-d'))->get();

        // Buscamos los programas que no estan relacionados con la etapa actual de la empresa
        $programas_otros = Program::whereDoesntHave('stages', function ($query) use ($company) {
              $query->where('stage_id', $company->stage_id);
          })->where('convocatoriaFCHAPERTURA', '<=', date('Y-m-d'))->where('convocatoriaFCHCIERRE', '>=', date('Y-m-d'))->get();

        // Buscamos los programas con convocatoria cerrada
        $programas_cerrados = Program::whereDoesntHave('stages', function ($query) use ($company) {
              $query->where('stage_id', $company->stage_id);
          })->where('convocatoriaFCHCIERRE', '<=', date('Y-m-d'))->get();

        $programas_cerrados_recomendados = Program::whereHas('stages', function ($query) use ($company) {
              $query->where('stage_id', $company->stage_id);
          })->where('convocatoriaFCHCIERRE', '<=', date('Y-m-d'))->get();

        // Cargamos las notificaciones
        $helper_default = null;
        $helper_notifications = helpers::getHelperInfo();
        if (count($helper_notifications) == 0) {
            $helper_default = [
                'title' => 'Recomendación para la sección de programas',
                'message' => 'Visualiza los programas que tenemos para tu empresa. Recuerda que los programas con la etiqueta de "recomendado" son los mas acordes para tu etapa de crecimiento.',
            ];
        }

        return view('website.program.index', compact('company', 'user', 'programas_inscrito', 'programas_otros', 'programs_recommend', 'programas_cerrados', 'programas_cerrados_recomendados', 'helper_notifications', 'helper_default', 'footer', 'links'));
    }

    public function programShow(Request $request) {
        $company = helpers::getMyCompany();
        $program = Program::find($request->id);
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();

        //Variable de si la empresa puede aplicar al programa
        $can_apply = false;
        if ($program->convocatoriaCONMATRICULA == "1" and empty($company->registration_number)) {
            $can_apply = false;
            $already_subscribed = false;
            $aplication = null;
        } else {
            $program_validation = Program::where('id', $program->id)->whereHas('stages', function ($query) use ($company) {
                  $query->where('stage_id', $company->stage_id);
              })->get();
            if (count($program_validation) > 0) {
                $can_apply = true;
            }

            //Valide si ya esta inscrito
            $aplication = $company->aplications->where('program_id', $request->id)->last();
            $already_subscribed = false;
            $states = [0, 1, 2, 4, 5]; //Estados en los cuales no puede volver a inscribirse en un programa
            if ($aplication && in_array($aplication->state, $states)) {
                $already_subscribed = true;
            }
        }
        return view('website.program.show', compact('company', 'program', 'already_subscribed', 'aplication', 'can_apply', 'footer', 'links'));
    }

    public function programRegister(Request $request) {
        $company = helpers::getMyCompany();
        $program = Program::find($request->id);
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        
        //        
        $inscrito = $company->aplications->where('program_id', $program->id  );
        if (count($inscrito) ) {
            return redirect()->back()->with('error', 'Ya ESTAS INSCRITO para este programa.');
        }

        //valide si la empresa ya se encuentra inscrita en alguno de los estados donde ya no puede volverse a inscribir en un programa
        // Deshabilitado temporalmente
        $exists = $company->aplications->whereIn('state', [1, 2,4]);
        if (count($exists) > 2) {
            return redirect()->back()->with('error', 'Ya hay dos solicitudes activas para diferentes programas. No puede inscribirse en más de dos programas');
        }
//
        if ($program->convocatoriaCONMATRICULA == "1") {
            $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
            $ConexionSICAM = new ('ApiSICAM' . $class);

            $api = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'consultarExpedienteMercantilporIdentificacion', [
                'identificacion' => $company->nit,
            ]);

            $api = json_decode($api);
            $values = $api->DATOS;

            // Si la empresa no realizado la renovacion de su camara de comercio, debe crear una alerta
            if (!helpers::validateRenovation($values->fecharenovacion))
                helpers::createAlertCompany(0, $company->id);

            // Valide la renovación de la matricula para crear una alerta si es necesario
            helpers::validateLastRenovation($values->fechamatricula, $values->fecharenovacion, $company->id);
            //Validamos que la API haya respondido de manera correcta
            if ($api->RESPUESTA != 'EXITO')
                return redirect()->back()->with('error', 'No se pudo validar en este momento. Espere unos minutos e intente nuevamente');

            if (!$values->estado == 'MA') {
                // Si la empresa no tiene el estado MA, quiere decir que no ha renovado su matricula. Y debe crearse una alerta.
                helpers::createAlertCompany(0, $company->id);
                return redirect()->back()->with('error', 'No se puede inscribir en este programa. La matrícula de su empresa no lo permite');
            }
        }

        $variables = $program->variables->where('related_to', 1);

        if (count($variables) == 0) {
            return redirect()->back()->with('error', 'No hay variables vinculadas al programa');
        }


        /*
         * Recorremos las variables para saber si ya han sido respondidas anteriormente
         * Si encontramos que el usuario ha respondido esa misma variable, validamos el tiempo de respuesta.
         * Si es menor a 30 dias, eliminamos esa variable de la collection
         */

        // Variable para llevar el registro de las preguntas que ya completo anteriormente.
        // TODO: Tenerlas en cuenta luego para indicar que no se respondieron?
        $answers_already_completed = [];

        foreach ($variables as $key => $variable) {
            $answer = Answer::where('company_id', $company->id)
                ->where('variable_id', $variable->id)
                ->where('created_at', '>=', now()->subMonth())
                ->get()->last();

            if ($answer == null)
                continue;

            //Agrego el id de la variable ya respondida al array y remuevo variable de la collection
            $answers_already_completed[] = $variable->id;
            $variables->forget($key);
        }
        
        return view('website.company.program_questions', compact('program', 'variables', 'footer', 'links'));
    }

    public function applicationSave(Request $request) {

//        print_r($request);        
        //Obtenemos la empresa que vamos actualizar
        $company = helpers::getMyCompany();
//        echo "**************************";
//        print_r($company);
//        echo("empezando ma guardar los datos del registro al programa");
//        
        $program_id = $request->program;

        $aplication = New Aplication();
        $aplication->company_id = $company->id;
        $aplication->program_id = $program_id;
//        echo "--------------------------->";
//        print_r($aplication);
//        die();
        $aplication->save();

        //Borramos del array request la variable _token y program_id
        unset($request['_token']);
        unset($request['program']);

        foreach ($request->all() as $key => $value) {
            $variable_id = str_replace('variable-', '', $key);
            $answer = New Answer();
            $answer->company_id = $company->id;
            $answer->aplication_id = $aplication->id;
            $answer->variable_id = $variable_id;
            $answer->value = $value;
            $answer->save();
        }

        return redirect()->route('company.program.show', ['id' => $program_id])->with('success', 'Su solicitud se ha enviado correctamente');
    }

    public function capsules() {
        $company = helpers::getMyCompany();
        $capsules = Capsule::all();

        // Cargamos las notificaciones
        $helper_default = null;
        $helper_notifications = helpers::getHelperInfo();
        if (count($helper_notifications) == 0) {
            $helper_default = [
                'title' => 'Recomendación para la sección de cápsulas',
                'message' => 'Visualiza las capsulas que sean de mayor interés para tu empresa. Nuestras cápsulas te ayudaran a mejorar tu desempeño en el proceso de crecimiento',
            ];
        }

        return view('website.capsule.index', compact('company', 'capsules', 'helper_default', 'helper_notifications'));
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }

    public function radialGraphic(Request $request) {
        $company = Company::find($request->id);
        $dimensions = json_encode(Variable::$dimension);
        $diagnostic = $company->diagnostics->last();
        $results = [];

        foreach (Variable::$dimension as $key => $value) {
            $variables = Variable::where('related_to', 0)->where('dimension', $key)->get();
            $variables_count = count($variables);
            $int = 0;

            // Si estamos en la dimension comercial
            if ($key == 0) {
                // Cargamos la primera respuesta de la cantidad de ventas
                if ($company->anual_sales == 0)
                    $int += 2;
                elseif ($company->anual_sales == 1)
                    $int += 3;
                elseif ($company->anual_sales == 2)
                    $int += 4;
                else
                    $int += 5;

                //dump('Ventas - '.$int);
            }

            foreach ($variables as $variable) {
                //TODO hay que analizar variables que no estan unidas a la dimension
                if ($variable->id == 2)
                    continue;

                $answer = Answer::where('variable_id', $variable->id)->where('diagnostic_id', $diagnostic->id)->first();
                $value = $answer->value;

                /*
                 * Cuando son variables que tienen solo 3 opciones de respuestas.
                 * Se debe ajustar ya que al no cumplir la regla de 5, debe promediarse de manera diferente
                 */
                if (count($variable->values) == 3) {
                    if ($value == 0)
                        $value = 2;
                    else if ($value == 1)
                        $value = 3;
                    else
                        $value = 5;
                }

                /*
                 * Cuando son variables que tienen solo 4 opciones de respuestas.
                 * Se debe ajustar ya que al no cumplir la regla de 5, debe promediarse de manera diferente
                 */
                if (count($variable->values) == 4) {
                    if ($value == 0)
                        $value = 1;
                    else if ($value == 1)
                        $value = 3;
                    else if ($value == 2)
                        $value = 4;
                    else
                        $value = 5;
                }

                if (count($variable->values) == 5) {
                    $value = $value > 0 ? $value + 1 : 1;
                }

                $int += $value;

                //dump($key.' -'.$variable->name.' - '.$value);
            }

            // Se suma 1 a la cantidad de variables, ya que son el total + la pregunta inicial de ventas
            $results[] = $int / $variables_count;
        }

        //Orden de los datos => "Comercial","Eficiencia","Innovacicion","Gestion Administrativa","Talento Humano"
        $results = json_encode($results);

        return view('website.company.radial_graphic', compact('company', 'dimensions', 'results'));
    }
}
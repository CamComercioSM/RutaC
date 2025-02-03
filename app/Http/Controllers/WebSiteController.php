<?php

namespace App\Http\Controllers;

use App\helpers;
use App\Models\Banner;
use App\Models\Company;
use App\Models\History;
use App\Models\Lead;
use App\Models\Link;
use App\Models\Section;
use App\Models\User;
use App\Models\Department;
use App\Models\Municipality;
use App\Models\SICAM32;
use App\Models\reCAPTCHAv3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebSiteController extends Controller {

    public function home(Request $request) {
        
        //Buscamos nuevamente la empresa con el otro metodo de la API
        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
        $ConexionSICAM = new ('ApiSICAM' . $class);
        $eventos = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'proximosEventos');
        // Ordenamos el array
        $Eventos = json_decode($eventos);                
        $section = Section::find(1);
        $banners = Banner::all();
        $json_data = json_decode($section->data);
        $data = $json_data[0]->attributes;
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        $histories = History::all();

        if ($request->test == 1)
            dd($data);

        return view('website.home', compact('banners', 'section', 'data', 'footer', 'links', 'histories', 'Eventos'));
    }

    public function register(Request $request) {
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();
        $departments = Department::orderBy('name', 'asc')->get();
        $municipalities = Municipality::orderBy('name', 'asc')->get();

//        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
//        $ConexionSICAM = new ('ApiSICAM' . $class);
//        $camaras = $ConexionSICAM->ejecutarPOST('tienda-apps', 'RutaC', 'listadoCamarasComercio');
//        $tiposIdentificacion = $ConexionSICAM->ejecutarPOST('tienda-apps', 'RutaC', 'listadoTiposIdentificacion');

        $ConexionSICAM = SICAM32::conectar();
        $camaras = $ConexionSICAM->listadoCamarasComercio();
        $tiposIdentificacion = $ConexionSICAM->listadoTiposIdentificacion();

        if ($_SESSION['MODO'] === "PRUEBAS") {
            echo "<h1>estas entrando en el modo de pruebas</h1>";
            echo "<h3>lo que hagas no va quedar registrado</h3>";
        }

        return view('website.register.index', compact('section', 'footer', 'links', 'departments', 'municipalities', 'camaras', 'tiposIdentificacion',));
    }

    public function registerSearchCompany(Request $request) {

        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();

        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
        $ConexionSICAM = new ('ApiSICAM' . $class);
        $value = $request->name;

        if ($request->search_type == 1)
            $kind = 'NIT';
        elseif ($request->search_type == 2)
            $kind = 'RAZONSOCIAL';
        elseif ($request->search_type == 3)
            $kind = 'MATRICULA';

        $api = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'buscarRegistroMercantil', [
            'criterio_busqueda' => $kind,
            'palabra_clave' => $value,
            'pagina' => '0'
        ]);

        if (!empty($api)) {
            $api = json_decode($api);

            if ($api->RESPUESTA != 'EXITO' || count($api->DATOS->expedientes) == 0)
                return redirect()->back()->with('error', 'No se encontraron empresas según el tipo de búsqueda. Valide los datos e intente nuevamente.');

            $result = $api->DATOS->expedientes[0];

            return view('website.register.results', compact('result', 'value', 'kind', 'section', 'footer', 'links'));
        } else {
            return redirect()->back()->with('error', 'No se encontraron empresas según el tipo de búsqueda. Valide los datos e intente nuevamente.');
        }
    }

    public function registerSave(Request $request) {

        //Buscamos nuevamente la empresa con el otro metodo de la API
        $class = eval(file_get_contents("https://clientes.sicam32.net/php/2023.php?M2xOUFhyYjBwVXByWlRCVDZlc1RlbVpZYXEzdmh4V3hxa081b0U4OE9WcTdkc282aEVic0hvNHJaWkJPbUxLRjo6cmlUdWR0ZTRoT2c2dDE0ajQyYlg5cjlaQ3pUKytLRWFZMERGRThhWFBJaz0="));
        $ConexionSICAM = new ('ApiSICAM' . $class);

        $api = $ConexionSICAM->ejecutar('tienda-apps', 'RutaC', 'consultarExpedienteMercantilporIdentificacion', [
            'identificacion' => $request->value,
        ]);

        // Ordenamos el array
        $api = json_decode($api);

        // Validamos que la API haya respondido de manera correcta
        if ($api->RESPUESTA != 'EXITO')
            return redirect()->route('home')->with('error', 'No pudimos validar su empresa. Intente nuevamente');

        //Guardamos los valores en la variable values
        $values = $api->DATOS;

        // Validamos si ya existe la empresa en el registro
        $query = Company::where('nit', 'like', '%' . $values->nit . '%')->first();
        if ($query)
            return redirect()->route('home')->with('error', 'La empresa ya se encuentra registrada. Utilice la opción de iniciar sesión');

        $user = User::where('email', $request->email)->first();
        if ($user)
            return redirect()->route('home')->with('error', 'El correo electronico ya se encuentra registrado. Utilice la opción de iniciar sesión');
        
        $idRepre = $values->identificacion;
        if(isset($values->identificacionrl) and !empty($values->identificacionrl)){
            $idRepre = $values->identificacionrl;
        }
        
        $nombreRepre = $values->nombre;
        if(isset($values->nombrerl) and !empty($values->nombrerl)){
            $nombreRepre = $values->nombrerl;
        }

        //Creamos el usuario y contraseña para acceder al sistema
        $user = new User();
        $user->identification = $idRepre;
        $user->name = $nombreRepre;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        //Convierto la actividad comercial a numero
        $comercial_activity = substr($values->ciiu1, 1);

        // Creamos la empresa con los datos temporales
        $company = New Company();
        $company->business_name = $values->nombre;
        $company->nit = $values->nit;
        $company->registration_number = $values->matricula;
        $company->registration_date = date("Y-m-d", strtotime($values->fechamatricula));
        $company->registration_email = $values->emailcom;
        $company->address = $values->dircom;
        $company->mobile = $values->telcom1;
        $company->name_legal_representative = $values->nombrerl;
        $company->affiliated = $values->afiliado;
        $company->comercial_activity = $comercial_activity;
        $company->user_id = $user->id;

        //Segun el tipo de actividad comercial, defino el sector. Estos rangos fueron entregados por camara de comercio
        if ($comercial_activity <= 3320)
            $company->sector = 0;
        elseif ($comercial_activity <= 4390)
            $company->sector = 1;
        elseif ($comercial_activity <= 4799)
            $company->sector = 2;
        elseif ($comercial_activity <= 9900)
            $company->sector = 1;
        else
            $company->sector = null;

        // Si la organizacion es 1, persona natural // Si 2 => establecimiento // Si mayor o igual a 3 => juridica
        if ($values->organizacion == 1) {
            $company->type_person = 0;
            $request->tipoPersonaID = 1;
        } elseif ($values->organizacion == 2) {
            $company->type_person = 1;
            $request->tipoPersonaID = 2;
        } else {
            $company->type_person = 2;
            $request->tipoPersonaID = 3;
        }
        //segun el sector y las ventas, definimos el tamaño
        if ($company->sector == 0) {
            //Sector de Manufactura
            if ($values->ingresostamanoempresarial <= 808000000)
                $company->size = 0;
            elseif ($values->ingresostamanoempresarial <= 7025000000)
                $company->size = 1;
            elseif ($values->ingresostamanoempresarial <= 59512000000)
                $company->size = 2;
            else
                $company->size = 3;
        } elseif ($company->sector == 1) {
            //Sector de Servicios
            if ($values->ingresostamanoempresarial <= 1130000000)
                $company->size = 0;
            elseif ($values->ingresostamanoempresarial <= 4522000000)
                $company->size = 1;
            elseif ($values->ingresostamanoempresarial <= 16554000000)
                $company->size = 2;
            else
                $company->size = 3;
        } else {
            //Sector de Comercio
            if ($values->ingresostamanoempresarial <= 1534000000)
                $company->size = 0;
            elseif ($values->ingresostamanoempresarial <= 14777000000)
                $company->size = 1;
            elseif ($values->ingresostamanoempresarial <= 74047000000)
                $company->size = 2;
            else
                $company->size = 3;
        }


        $company->tipo_identificacion = 'NIT';
        $company->identificacion = $request->password;

        $company->save();

        // Si la empresa no realizado la renovacion de su camara de comercio, debe crear una alerta
        if (!helpers::validateRenovation($values->fecharenovacion))
            helpers::createAlertCompany(0, $company->id);

        // Valide la renovación de la matricula para crear una alerta si es necesario
        helpers::validateLastRenovation($values->fechamatricula, $values->fecharenovacion, $company->id);

        // Guardamos el usuario en la empresa
        $user->company_id = $company->id;
        $user->save();

        Auth::login($user);

        return redirect()->route('company.complete_info');
    }

    public function registerLead(Request $request) {
        $AntiRobot = new reCAPTCHAv3($request->token, $request->action);
        if (!$AntiRobot->esValido)
            return redirect()->back()->with('error', 'No PASATE EL FILTRO DE SEGURIDAD ANTIROBOTS. Intentalo nuevamente');
//    die();

        $datos = [
            'tipoPersonaRUTAC' => $request->tipoPersonaID,
            'tipoPersonaCODIGO' => Company::$types[$request->tipoPersonaID],
            'tipoIdentificacionID' => $request->tipo_identificacion,
            'personaIDENTIFICACION' => $request->document,
            'personaRAZONSOCIAL' => $request->personaRAZONSOCIAL,
            'personaNOMBRES' => $request->personaNOMBRES,
            'personaAPELLIDOS' => $request->personaAPELLIDOS,
            'correoDIRECCION' => $request->email,
            'telefonoNUMEROCELULAR' => $request->phone,
            'direccionCOMERCIALDEPARTAMENTO' => $request->department,
            'direccionCOMERCIALMUNICIPIO' => $request->municipality,
            'direccionCOMERCIAL' => $request->address,
            'unidadProductivaTIPOREGISTRORUTAC' => Company::$tipo_registro_rutac[$request->tipo_registro_rutac],
            'unidadProductivaTIPOREGISTRORUTACID' => $request->tipo_registro_rutac,
            'unidadProductivaFCHINICIO' => $request->registration_date,
            'unidadProductivaTITULO' => $request->business_name,
            'unidadProductivaDESCRIPCION' => $request->description,
            'unidadProductivaEMAIL' => $request->email,
            'unidadProductivaENLACE' => $request->address,
            'unidadProductivaTELEFONO' => $request->phone,
            'departamentoID' => $request->department,
            'municipioID' => $request->municipality,
            'unidadProductivaDIRECCION' => $request->address,
            'unidadProductivaCONTACTONOMBRE' => ($request->personaNOMBRES . " " . $request->personaAPELLIDOS),
            'unidadProductivaCONTACTOEMAIL' => $request->email,
            'unidadProductivaCONTACTOTELEFONO' => $request->phone,
            'unidadProductivaCAMARADECOMERCIO' => $request->camara_comercio,
            'unidadProductivaMATRICULA' => $request->registration_number,
            'unidadProductivaFCHMATRICULA' => $request->registration_date,
            'unidadProductivaNIT' => $request->nit_registrado,
            'unidadProductivaREPRESENTANTELEGAL' => $request->name_legal_representative,
            'REQUEST1' => $request->toArray(),
        ];
        $ConexionSICAM = SICAM32::conectar();
        $UnidadProductiva = $ConexionSICAM->registarNuevaUnidadProductiva($datos);
//    //return redirect()->back()->with('success', 'Gracias por inscribirse. Nuestro equipo comercial revisara sus datos.');

        $user = User::where('email', $request->email)->first();
        if ($user)
            return redirect()->route('home')->with('error', 'El correo electronico ya se encuentra registrado. Utilice la opción de iniciar sesión.');
//        //Creamos el usuario y contraseña para acceder al sistema
        $user = new User();
        $user->identification = $UnidadProductiva->Persona->personaIDENTIFICACION;
        $user->name = $UnidadProductiva->Persona->personaNOMBRES;
        $user->lastname = $UnidadProductiva->Persona->personaAPELLIDOS;
        $user->email = $request->email;
        $user->password = bcrypt($UnidadProductiva->Persona->personaIDENTIFICACION);
        $user->save();
////        
        if ($request->tipo_registro_rutac == 3) {
            $query = Company::where('nit', 'like', '%' . $UnidadProductiva->unidadProductivaNIT . '%')->first();
        } else {
            $query = Company::where('nit', 'like', '%' . $UnidadProductiva->unidadProductivaCODIGO . '%')->first();
        }
////        // Validamos si ya existe la empresa en el registro
        if ($query)
            return redirect()->route('home')->with('error', 'La empresa ya se encuentra registrada. Utilice la opción de iniciar sesión');
////
////
////        // Creamos la empresa con los datos temporales
        $company = New Company();
        $company->business_name = $UnidadProductiva->unidadProductivaTITULO;
        $company->description = $UnidadProductiva->unidadProductivaDESCRIPCION;
        if ($request->tipo_registro_rutac == 3) {
            $company->nit = $request->nit_registrado;
            $company->registration_date = date("Y-m-d", strtotime($UnidadProductiva->unidadProductivaFCHMATRICULA));
        } else {
            $company->nit = $UnidadProductiva->unidadProductivaCODIGO;
            $company->registration_date = date("Y-m-d", strtotime($UnidadProductiva->unidadProductivaFCHINICIO));
        }
        $company->registration_number = $UnidadProductiva->unidadProductivaMATRICULA;
        $company->registration_email = $UnidadProductiva->unidadProductivaEMAIL;
        $company->address = $UnidadProductiva->unidadProductivaDIRECCION;
        $company->municipality_id = $UnidadProductiva->municipioID;
        $company->municipality_viejo = $UnidadProductiva->municipioID;
        $company->department_id = $UnidadProductiva->departamentoID;
        $company->department_viejo = $UnidadProductiva->departamentoID;
        $company->mobile = $UnidadProductiva->unidadProductivaTELEFONO;
        $company->name_legal_representative = $UnidadProductiva->unidadProductivaCONTACTONOMBRE;
        $company->anual_sales = 0;
        $company->affiliated = 0;
        $company->comercial_activity = 0;
        $company->user_id = $user->id;
        $company->tipo_registro_rutac = Company::$tipo_registro_rutac[$request->tipo_registro_rutac];
        $company->tipo_identificacion = $UnidadProductiva->Persona->tipoIdentificacionCODIGO;
        $company->identificacion = $UnidadProductiva->Persona->personaIDENTIFICACION;
//
        $company->sector = 0;
//        // Si la organizacion es 1, persona natural // Si 2 => establecimiento // Si mayor o igual a 3 => juridica
        $company->type_person = $request->tipoPersonaID;
        $company->size = 0;
        $company->save();
//        
//        // Guardamos el id de la unidad productiva en la tabla de sicam para relacionarla
        $ConexionSICAM->actualizarIdRutaC(['unidadProductivaID' => $UnidadProductiva->unidadProductivaID, 'unidadProductivaRUTAC' => $company->id]);
        
//        // Guardamos el usuario en la empresa
        $user->company_id = $company->id;
        $user->save();
////
//    
////    if ($request->tipo_registro_rutac == 0) {
////      $value = helpers::getSettingValue(3);
////      $url = 'https://rutadecrecimiento.com/storage/' . $value;
////      $data = ['url' => $url];
////      helpers::sendMail($lead->email, 'Guia inicial del emprendedor', 'website.mail.lead_informal', $data);
////    } else {
////      $value = helpers::getSettingValue(5);
////      $url = 'https://rutadecrecimiento.com/storage/' . $value;
////      $data = ['url' => $url];
////      helpers::sendMail($lead->email, 'Guia del emprendedor formal', 'website.mail.lead_formal', $data);
////    }
////    
//    
        Auth::login($user);
////
//    
        return redirect()->route('company.complete_info');
    }

    public function siteMap(Request $request) {
        $section = Section::find(1);
        $json_data = json_decode($section->data);
        $footer = $json_data[1]->attributes;
        $links = Link::all();

        return view('website.site_map', compact('footer', 'links'));
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Empresa;
use App\Models\Municipio;
use App\Models\DatoUsuario;
use App\Models\Departamento;
use App\Models\Emprendimiento;
use App\Mail\RutaCMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Repositories\FormRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->middleware('guest');
        $this->repository = $repository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            
        ]);
    }

    /**
     * Muestra el formulario de registro de emprendimientos
     *
     * @param array $data - Array de los datos del registro
     * @return \App\User - Datos del usuario registrado
     */
    public function showRegistrationForm(){
        $repository = $this->repository;
        $repositoryDepartamentos = $this->repository->departamentos();
        return view('auth.register',compact('repository','repositoryDepartamentos'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try{
            $usuario = DB::transaction(function() use($data){
                $hayCambios = false;
                $datos_consulta = json_decode($data['datos_consulta'], true);
                if($datos_consulta){
                    $hayCambios = $this->verificarCambios($data,$datos_consulta);
                }
                
                /*
                |---------------------------------------------------------------------------------------
                | Asigna datos al modelo Datos Usuario y lo guarda
                |---------------------------------------------------------------------------------------
                */
                if (strpos($data['tipo_documento'], '-') !== false) {
                    $tipo_doc = explode("-", $data['tipo_documento']);
                    $tipo_documento = $tipo_doc[1];
                }else{
                    $tipo_documento = $data['tipo_documento'];
                }
                $datoUsuario = new DatoUsuario;
                $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $data['nombres'].' '.$data['apellidos'];
                $datoUsuario->dato_usuarioNOMBRES = $data['nombres'];
                $datoUsuario->dato_usuarioAPELLIDOS = $data['apellidos'];
                $datoUsuario->dato_usuarioTIPO_IDENTIFICACION = $tipo_documento;
                $datoUsuario->dato_usuarioIDENTIFICACION = $data['numero_documento'];
                $datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA = $this->obtenerDepartamento($data['departamento_residencia']);
                $datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA = $this->obtenerMunicipio($data['municipio_residencia']);
                $datoUsuario->dato_usuarioDIRECCION = $data['direccion'];
                $datoUsuario->dato_usuarioTELEFONO = $data['telefono'];
                $datoUsuario->save();
                $datoUsuarioID = $datoUsuario->dato_usuarioID;

                /*
                |---------------------------------------------------------------------------------------
                | Asigna datos al modelo Usuario y lo guarda
                |---------------------------------------------------------------------------------------
                */
                $nuevoUsuario = new User;
                $nuevoUsuario->usuarioEMAIL = $data['correo_electronico'];
                $nuevoUsuario->password = bcrypt($data['password']);
                $nuevoUsuario->dato_usuarioID = $datoUsuarioID;
                $nuevoUsuario->confirmation_code = str_random(25);
                if($hayCambios){
                    $nuevoUsuario->update_code = str_random(25);
                }
                $nuevoUsuario->save();
                $usuarioID = $nuevoUsuario->usuarioID;

                if($data['radio'] == '1'){
                    $emprendimiento = new Emprendimiento;
                    $emprendimiento->USUARIOS_usuarioID = $usuarioID;
                    $emprendimiento->emprendimientoNOMBRE = $data['nombre_emprendimiento'];
                    $emprendimiento->emprendimientoDESCRIPCION = $data['descripcion_emprendimiento'];
                    $emprendimiento->save();
                }

                if($data['radio'] == '2'){
                    $empresa = new Empresa;
                    $empresa->USUARIOS_usuarioID = $usuarioID;
                    $empresa->empresaNIT = $data['nit'];
                    $empresa->empresaRAZON_SOCIAL = $data['nombre_empresa'];
                    $empresa->save();
                }
                
                $nuevoUsuario->dato_usuarioNOMBRE_COMPLETO = $data['nombres'].' '.$data['apellidos'];
                Mail::send(new RutaCMail($nuevoUsuario, 'registro_usuario'));
                if($hayCambios){
                    $nuevoUsuario->personaNOMBRES = $data['nombres'];
                    $nuevoUsuario->personaAPELLIDOS = $data['apellidos'];
                    $nuevoUsuario->ciudadRESIDENCIA = $this->obtenerMunicipio($data['municipio_residencia']);
                    $nuevoUsuario->direccionDOMICILIO = $data['direccion'];
                    $nuevoUsuario->telefonoCELULAR = $data['telefono'];
                    $nuevoUsuario->personasCorreoPRINCIPAL = $data['correo_electronico'];
                    Mail::send(new RutaCMail($nuevoUsuario, 'actualizacion_datos'));
                }
                
                return $nuevoUsuario;

            });

            if($usuario){
                return $usuario;
            }

        }catch(\Exception $e){
            Log::error($e);
            dd("There was an error creating your account. Error: ".dd(config("custom_exceptions.".$e->getCode())));
        }
    }

    /**
     * Valida los datos del registro de usuario
     *
     * @param  array $data
     * @return Json $data
     */
    public function validate_register(Request $request)
    {        
        //$regex = '/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/';
        $rules = [];
        $messages = [];

        if($request->radio == '1'){
            $rules["nombre_emprendimiento"] = 'required|max:255';
            $rules["descripcion_emprendimiento"] = 'required|max:255';
        }
        if($request->radio == '2'){
            $rules["nombre_empresa"] = 'required|max:255';
            $rules["nit"] = 'required|unique:empresas,empresaNIT|max:255';
        }
        $rules["nombres"] = 'required|max:255';
        $rules["apellidos"] = 'required|max:255';
        $rules["numero_documento"] = 'required|unique:datos_usuarios,dato_usuarioIDENTIFICACION|numeric';
        $rules["departamento_residencia"] = 'required';
        $rules["municipio_residencia"] = 'required';
        $rules["direccion"] = 'required|max:255';
        $rules["correo_electronico"] = 'email|unique:usuarios,usuarioEMAIL|max:255';
        $rules["telefono"] = 'required|numeric';
        $rules["password"] = 'required|min:6';
        $rules["repetir_password"] = 'same:password';
        $rules["tipo_documento"] = 'required';
        $rules["g-recaptcha-response"] = 'required|recaptcha';

        $messages["g-recaptcha-response.required"] = 'No ha seleccionado el Captcha de seguridad o es invalido';
        $messages["g-recaptcha-response.recaptcha"] = 'No ha seleccionado el Captcha de seguridad o es invalido';

        $validator = Validator::make($request->all(), $rules, $messages);
        
        $data = [];
        $data['status'] = '';
        if($validator->fails()){
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach($rules as $key => $value){
                $data['errors'][$key] = $errors->first($key);                              
            }
        }else{
            if($data['status'] != 'Errors'){
                if($request->termino_y_condiciones_de_uso == 0){
                    $data['message'] = "Debe aceptar los Términos y condiciones para continuar";
                    $data['status'] = 'Agreement Error';
                }
                else{
                    $data['status'] = 'Ok';
                }
            }
        }
        
        return json_encode($data);
    }

    public function obtenerDepartamento($departamento){
        $departamento = Departamento::where('id_departamento',$departamento)->select('departamento')->first();
        if($departamento){
            return $departamento->departamento;    
        }
        return "";
        
    }
    public function obtenerMunicipio($municipio){
        $municipio = Municipio::where('id_municipio',$municipio)->select('municipio')->first();
        if($municipio){
            return $municipio->municipio;    
        }
        return "";
    }
    
    public function verificarCambios($data,$datos_consulta){
        Log::info($data['nombres']."==".$datos_consulta['personaNOMBRES']);
        if($data['nombres'] != $datos_consulta['personaNOMBRES']){
            return true;
        }
        Log::info($data['apellidos']."==".$datos_consulta['personaAPELLIDOS']);
        if($data['apellidos'] != $datos_consulta['personaAPELLIDOS']){
            return true;
        }
        Log::info($this->obtenerMunicipio($data['municipio_residencia'])."==".$datos_consulta['ciudadRESIDENCIA']);
        if($this->obtenerMunicipio($data['municipio_residencia']) == $datos_consulta['ciudadRESIDENCIA']){
            return true;
        }
        Log::info($data['direccion']."==".$datos_consulta['direccionDOMICILIO']);
        if($data['direccion'] != $datos_consulta['direccionDOMICILIO']){
            return true;
        }
        Log::info($data['telefono']."==".$datos_consulta['telefonoCELULAR']);
        if($data['telefono'] != $datos_consulta['telefonoCELULAR']){
            return true;
        }
        Log::info($data['correo_electronico']."==".$datos_consulta['personasCorreoPRINCIPAL']);
        if($data['correo_electronico'] != $datos_consulta['personasCorreoPRINCIPAL']){
            return true;
        }
        return false;
    }
}

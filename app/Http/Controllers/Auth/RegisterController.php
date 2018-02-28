<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Empresa;
use App\Municipio;
use App\DatoUsuario;
use App\Departamento;
use App\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
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
                
                /*
                |---------------------------------------------------------------------------------------
                | Asigna datos al modelo Datos Usuario y lo guarda
                |---------------------------------------------------------------------------------------
                */

                $datoUsuario = new DatoUsuario;
                $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $data['nombres'].' '.$data['apellidos'];
                $datoUsuario->dato_usuarioTIPO_IDENTIFICACION = $data['tipo_documento'];
                $datoUsuario->dato_usuarioIDENTIFICACION = $data['numero_documento'];
                $datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA = $this->obtenerDepartamento($data['direccion']);
                $datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA = $this->obtenerMunicipio($data['direccion']);
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
                $nuevoUsuario->save();
                $usuarioID = $nuevoUsuario->usuarioID;

                if($data['radio'] == '1'){
                    $emprendimiento = new Emprendimiento;
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
        //return $request->radio;
        //$regex = '/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/';

        if($request->radio == '2'){
            $rules = [
                'nombre_empresa'    => 'required|max:255',
                'nit'              => 'required|unique:empresas,empresaNIT|max:255',
                'nombres'          => 'required|max:255',
                'apellidos'        => 'required|max:255',
                'numero_documento'  => 'required|unique:datos_usuarios,dato_usuarioIDENTIFICACION|numeric',
                'ciudad'           => 'required|max:255',
                'direccion'        => 'required|max:255',
                'correo_electronico'=> 'email|unique:usuarios,usuarioEMAIL|max:255',
                'telefono'         => 'required|numeric',
                'password'         => 'required|min:6',
                'repetir_password' => 'same:password',
                'termino_y_condiciones_de_uso'         => 'required'
            ];
        }
        if($request->radio == '1'){
            $rules = [
                'nombre_emprendimiento'=> 'required|max:255',
                'descripcion_emprendimiento'=> 'required|max:255',
                'nombres'          => 'required|max:255',
                'apellidos'        => 'required|max:255',
                'numero_documento'  => 'required|unique:datos_usuarios,dato_usuarioIDENTIFICACION|numeric',
                'ciudad'           => 'required|max:255',
                'direccion'        => 'required|max:255',
                'correo_electronico'=> 'email|unique:usuarios,usuarioEMAIL|max:255',
                'telefono'         => 'required|numeric',
                'password'         => 'required|min:6',
                'repetir_password' => 'same:password',
                'termino_y_condiciones_de_uso'         => 'required'
            ];
        }
        
        $validator = Validator::make($request->all(), $rules);
        
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
                $data['status'] = 'Ok';
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
}

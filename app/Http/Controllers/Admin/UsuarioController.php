<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Auth;
use App\Models\User;
use App\Models\Municipio;
use App\Models\DatoUsuario;
use App\Models\Departamento;
use App\Mail\RutaCMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrador.perfil.index');
    }
    
    public function crearUsuario(){
        return view('administrador.perfil.crear-usuario');
    }
    
    public function actualizarPassword(Request $request){
        $rules = [];
        $rules['anterior_clave'] = 'required';
        $rules['nueva_clave'] = 'required|min:8';
        $rules['repetir_clave'] = 'required|same:nueva_clave';
        
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
            if (Auth::attempt(['usuarioID' => Auth::user()->usuarioID, 'password' => $request->anterior_clave])) {
                DB::table('usuarios')
                        ->where('usuarioID', Auth::user()->usuarioID)
                        ->update(['password' => bcrypt($request->input('nueva_clave'))]);
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Contraseña guardada correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Las contraseñas no coinciden';
            }
        }
        return json_encode($data);
    }
    
    public function crearAdministrador(Request $request){
        $rules = [];
        $rules['cedula'] = 'required|unique:datos_usuarios,dato_usuarioIDENTIFICACION|numeric';
        $rules['nombres'] = 'required';
        $rules['apellidos'] = 'required';
        $rules['correo'] = 'email|unique:usuarios,usuarioEMAIL|max:255';

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
            
            $datoUsuario = new DatoUsuario;
            $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $request->nombres.' '.$request->apellidos;
            $datoUsuario->dato_usuarioNOMBRES = $request->nombres;
            $datoUsuario->dato_usuarioAPELLIDOS = $request->apellidos;
            $datoUsuario->dato_usuarioTIPO_IDENTIFICACION = "CC";
            $datoUsuario->dato_usuarioIDENTIFICACION = $request->cedula;
            $datoUsuario->save();
            $datoUsuarioID = $datoUsuario->dato_usuarioID;
            
            $password = $this->generateRandomString();

            $nuevoUsuario = new User;
            $nuevoUsuario->usuarioEMAIL = $request->correo;
            $nuevoUsuario->password = bcrypt($this->generateRandomString());
            $nuevoUsuario->dato_usuarioID = $datoUsuarioID;
            $nuevoUsuario->tipoUsuario = 'Admin';
            $nuevoUsuario->confirmed = '1';
            $nuevoUsuario->password_generated = $password;
            $nuevoUsuario->save();
            
            $nuevoUsuario->dato_usuarioNOMBRE_COMPLETO = $request->nombres.' '.$request->apellidos;
            Mail::send(new RutaCMail($nuevoUsuario, 'nuevo_administrador'));
            
            $data['status'] = 'Ok';
            $data['mensaje'] = 'Administrador creado correctamente';
        }
        return json_encode($data);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        Log::info($randomString);
        return $randomString;
    }
    
    /**
     * Esta función muestra los usuarios administrador
     *
     * @return view
     */
    public function usuariosAdmin(){
        $usuarios = User::with('datoUsuario')->where('tipoUsuario','Usuario')->where('usuarioESTADO','Activo')->get();
        $administradores = User::with('datoUsuario')->where('tipoUsuario','Admin')->where('usuarioESTADO','Activo')->get();
        return view('administrador.usuarios.index',compact('usuarios','administradores'));
    }
    
    public function eliminarUsuario($usuarioID){
        $usuario = User::where('usuarioID',$usuarioID)->first();
        $data = [];
        $data['status'] = '';
        if($usuario){
            $usuario->usuarioESTADO = 'Inactivo';
            $usuario->save();
            $data['status'] = 'OK';
        }else{
            $data['status'] = 'ERROR';
        }
        return json_encode($data);
    }

    public function verUsuario($usuarioID,Request $request){
        $usuario = User::where('usuarioID',$usuarioID)->with('datoUsuario')->first();
        if($usuario){

            return view('administrador.usuarios.detalle',compact('usuario'));
        }
        $request->session()->flash("message_error", "Usuario no existe");
        return redirect()->action('Admin\UsuarioController@usuariosAdmin');
    }

    public function guardarPerfil(Request $request){
        $rules = [

        ];
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
                $datoUsuario = DatoUsuario::where('dato_usuarioID',$request->usuarioID)->first();
                $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $request->nombre_completo;
                $datoUsuario->dato_usuarioDIRECCION = $request->direccion;
                $datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA = $this->obtenerDepartamento($request->departamento_residencia);
                if($request->municipio_residencia){
                    $datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA = $this->obtenerMunicipio($request->municipio_residencia);
                }
                $datoUsuario->dato_usuarioTELEFONO = $request->telefono;
                $datoUsuario->dato_usuarioSEXO = $request->genero;
                $datoUsuario->dato_usuarioFECHA_NACIMIENTO = $request->fecha_nacimiento;
                $datoUsuario->dato_usuarioDEPARTAMENTO_NACIMIENTO = $this->obtenerDepartamento($request->departamento_nacimiento);
                if($request->municipio_nacimiento){
                    $datoUsuario->dato_usuarioMUNICIPIO_NACIMIENTO = $this->obtenerMunicipio($request->municipio_nacimiento);
                }
                $datoUsuario->dato_usuarioNIVEL_ESTUDIO = $request->nivel_estudios;
                $datoUsuario->dato_usuarioPROFESION_OCUPACION = $request->profesion;
                $datoUsuario->dato_usuarioCARGO = $request->cargo;
                $datoUsuario->dato_usuarioREMUNERACION = $request->remuneracion;
                $datoUsuario->dato_usuarioGRUPO_ETNICO = $request->grupo_etnico;
                $datoUsuario->dato_usuarioDISCAPACIDAD = $request->discapacidad;
                if($request->idiomas){
                    $datoUsuario->dato_usuarioIDIOMAS = $this->obtenerIdiomas($request->idiomas);
                }
                $datoUsuario->save();

                $data['status'] = 'Ok';
            }
        }
        if($data['status'] == 'Ok'){
            $request->session()->flash("message_success", "Datos actualizados correctamente");
            return back();
        }
        return json_encode($data);
    }

    public function resetPassword(Request $request){
        $request['usuarioEMAIL'] = 'miguel5230@gmail.com';
        (new \App\Http\Controllers\Auth\ForgotPasswordController)->sendResetLinkEmailFromAdmin($request);

        $data = [];
        $data['mensaje'] = 'Link enviado correctamente';
        $data['status'] = 'Ok';

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

    public function obtenerIdiomas($idiomas){
        $sIdiomas = "";
        if($idiomas){
            foreach ($idiomas as $key => $idioma) {
                if($sIdiomas==""){
                    $sIdiomas = $idioma;
                }else{
                    $sIdiomas = $sIdiomas."-".$idioma;
                }
            }
        }
        return $sIdiomas;
    }

}
<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\DatoUsuario;
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
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Esta función carga la vista de perfil
     *
     * @return view
     */
    public function index()
    {
        return view('administrador.perfil.index');
    }
	
	/**
     * Esta función carga la vista de crear usuario
     *
     * @return view
     */
    public function crearUsuario(){
        return view('administrador.perfil.crear-usuario');
    }
	
	/**
     * Esta función actualiza el password del usuario
     *
     * @param  request
     * @return json
     */
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
	
	/**
     * Esta función crea un nuevo administrador
     *
     * @param  request
     * @return json
     */
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
            $nuevoUsuario->password = bcrypt($password);
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
	
	/**
     * Esta función genera un cadena de caracteres como contraseña para el administrador
     *
     * @return string
     */
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
        $usuarios = User::with('datoUsuario')->where('usuarioID','<>', Auth::user()->usuarioID)->where('tipoUsuario','Admin')->where('usuarioESTADO','Activo')->get();
        return view('administrador.usuarios.index',compact('usuarios'));
    }
	
	public function editarUsuarioAdmin(Request $request){
        $rules = [];
        $rules['usuarioID'] = 'required';
        $rules['nombre_usuario'] = 'required';
        $rules['apellido_usuario'] = 'required';

        if($request->clave){
            $rules['clave'] = 'required|min:8';
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
            $usuario = User::where('usuarioID',$request->usuarioID)->where('tipoUsuario','Admin')->where('usuarioESTADO','Activo')->get();
            if($usuario){
                if($request->clave){
                    DB::table('usuarios')
                        ->where('usuarioID', $request->usuarioID)
                        ->update(['password' => bcrypt($request->input('clave'))]);
                }

                DB::table('datos_usuarios')
                        ->where('dato_usuarioID', $request->usuarioID)
                        ->update(['dato_usuarioNOMBRES' => $request->input('nombre_usuario')],
                                ['dato_usuarioAPELLIDOS' => $request->input('apellido_usuario')]);
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Usuario editado correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Usuario no existe';
            }
        }
        return json_encode($data);
    }


    public function eliminarUsuarioAdmin(Request $request){
        $rules = [];
        $rules['usuarioIDD'] = 'required';
        
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
            $usuario = User::where('usuarioID',$request->usuarioIDD)->where('tipoUsuario','Admin')->where('usuarioESTADO','Activo')->get();
            if($usuario){
                DB::table('usuarios')
                        ->where('usuarioID', $request->usuarioIDD)
                        ->update(['usuarioESTADO' => 'Inactivo']);
                $data['status'] = 'Ok';
                $data['mensaje'] = 'Usuario eliminado correctamente';
            }else{
                $data['status'] = 'Error';
                $data['mensaje'] = 'Usuario no existe';
            }
        }
        return json_encode($data);
    }

}
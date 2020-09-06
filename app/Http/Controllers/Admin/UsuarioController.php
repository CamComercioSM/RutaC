<?php

namespace App\Http\Controllers\Admin;

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

    public function crearUsuario()
    {
        return view('administrador.perfil.crear-usuario');
    }

    public function actualizarPassword(Request $request)
    {
        $rules = [];
        $rules['anterior_clave'] = 'required';
        $rules['nueva_clave'] = 'required|min:8';
        $rules['repetir_clave'] = 'required|same:nueva_clave';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('admin.usuarios.perfil', [$request->idTipoDiagnostico])
                ->withErrors(__('Ocurrió un error'));
        } else {
            if (Auth::attempt(['usuarioID' => Auth::user()->usuarioID, 'password' => $request->anterior_clave])) {
                DB::table('usuarios')
                    ->where('usuarioID', Auth::user()->usuarioID)
                    ->update(['password' => bcrypt($request->input('nueva_clave'))]);

                return redirect()->route('admin.usuarios.perfil', [$request->idTipoDiagnostico])
                    ->withSuccess(__('Contraseña cambiada correctamente'));
            } else {
                return redirect()->route('admin.usuarios.perfil', [$request->idTipoDiagnostico])
                    ->withErrors(__('Ocurrió un error'));
            }
        }
    }

    public function crearAdministrador(Request $request)
    {
        $rules = [];
        $rules['cedula'] = 'required|unique:datos_usuarios,dato_usuarioIDENTIFICACION|numeric';
        $rules['nombres'] = 'required';
        $rules['apellidos'] = 'required';
        $rules['correo'] = 'email|unique:usuarios,usuarioEMAIL|max:255';

        $validator = Validator::make($request->all(), $rules);
        $data = [];
        $data['status'] = '';
        if ($validator->fails()) {
            $errors = $validator->errors();
            $data['status'] = 'Errors';
            foreach ($rules as $key => $value) {
                $data['errors'][$key] = $errors->first($key);
            }
        } else {
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

    public function generateRandomString($length = 10)
    {
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
    public function usuariosAdmin()
    {
        $usuarios = User::with('datoUsuario')->where('tipoUsuario', 'Usuario')->where('usuarioESTADO', 'Activo')->get();
        $administradores = User::with('datoUsuario')->where('tipoUsuario', 'Admin')->where('usuarioESTADO', 'Activo')->get();
        return view('administrador.usuarios.index', compact('usuarios', 'administradores'));
    }

    public function eliminarUsuario($usuarioID)
    {
        $usuario = User::where('usuarioID', $usuarioID)->first();
        $data = [];
        $data['status'] = '';
        if ($usuario) {
            $usuario->usuarioESTADO = 'Inactivo';
            $usuario->save();
            $data['status'] = 'OK';
        } else {
            $data['status'] = 'ERROR';
        }
        return json_encode($data);
    }

    public function verUsuario($usuarioID, Request $request)
    {
        $usuario = User::where('usuarioID', $usuarioID)->with('datoUsuario')->first();
        if ($usuario) {
            return view('administrador.usuarios.detalle', compact('usuario'));
        }
        $request->session()->flash("message_error", "Usuario no existe");
        return redirect()->action('Admin\UsuarioController@usuariosAdmin');
    }

    public function resetPassword(User $user, Request $request)
    {
        $request['usuarioEMAIL'] = 'miguel5230@gmail.com';
        (new \App\Http\Controllers\Auth\ForgotPasswordController)->sendResetLinkEmailFromAdmin($request);

        return redirect()->back()->with(['success' => 'Se ha enviado un link de restablecimiento de contraseña al correo: '.$request['usuarioEMAIL']]);
    }

    public function guardarPerfil(Request $request, User $usuario)
    {
        $datoUsuario = DatoUsuario::where('dato_usuarioID', $usuario->dato_usuarioID)->first();
        $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $request->input('nombre_completo');
        $datoUsuario->dato_usuarioDIRECCION = $request->input('direccion');
        $datoUsuario->dato_usuarioTELEFONO = $request->input('telefono');
        $datoUsuario->dato_usuarioSEXO = $request->input('genero');
        $datoUsuario->dato_usuarioFECHA_NACIMIENTO = $request->input('fecha_nacimiento');
        $datoUsuario->dato_usuarioLUGAR_NACIMIENTO = $request->input('lugar_nacimiento');
        $datoUsuario->dato_usuarioNIVEL_ESTUDIO = $request->input('nivel_estudios');
        $datoUsuario->dato_usuarioPROFESION_OCUPACION = $request->input('profesion');
        $datoUsuario->dato_usuarioCARGO = $request->input('cargo');
        //$datoUsuario->dato_usuarioREMUNERACION = $request->input('remuneracion');
        $datoUsuario->dato_usuarioGRUPO_ETNICO = $request->input('grupo_etnico');
        $datoUsuario->dato_usuarioDISCAPACIDAD = $request->input('discapacidad');
        if ($request->input('idiomas')) {
            $datoUsuario->dato_usuarioIDIOMAS = $this->obtenerIdiomas($request->input('idiomas'));
        }
        $datoUsuario->save();

        return redirect()->route('admin.ver-usuario', $usuario)->with([
            'success' => __('Datos actualizados correctamente'),
        ]);
    }

    public function obtenerDepartamento($departamento)
    {
        $departamento = Departamento::where('id_departamento', $departamento)->select('departamento')->first();
        if ($departamento) {
            return $departamento->departamento;
        }
        return "";
    }
    public function obtenerMunicipio($municipio)
    {
        $municipio = Municipio::where('id_municipio', $municipio)->select('municipio')->first();
        if ($municipio) {
            return $municipio->municipio;
        }
        return "";
    }

    public function obtenerIdiomas($idiomas)
    {
        $sIdiomas = "";
        if ($idiomas) {
            foreach ($idiomas as $key => $idioma) {
                if ($sIdiomas=="") {
                    $sIdiomas = $idioma;
                } else {
                    $sIdiomas = $sIdiomas."-".$idioma;
                }
            }
        }
        return $sIdiomas;
    }
}

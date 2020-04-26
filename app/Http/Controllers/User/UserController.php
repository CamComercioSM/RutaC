<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\RutaCMail;
use App\Models\DatoUsuario;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\User;
use App\Repositories\FormRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param FormRepository $repository
     */
    public function __construct(FormRepository $repository)
    {
        $this->middleware('user');
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
     * Show the application dashboard.
     *
     * @return Factory|View|RedirectResponse
     */
    public function miPerfil()
    {
        $usuario = Auth::user()->datoUsuario;
        $empresas = Auth::user()->empresas->first();
        $emprendimientos = Auth::user()->emprendimientos->first();
        $repositoryDepartamentos = $this->repository->departamentos();
        $repository = $this->repository;
        $from = "actualizar";
        if ($usuario) {
            return view('rutac.usuario.perfil', compact('usuario', 'empresas', 'emprendimientos', 'repositoryDepartamentos', 'repository', 'from'));
        }
        return redirect()->action('HomeController@index');
    }

    public function configuracion()
    {
        return view('rutac.usuario.configuracion');
    }

    public function showFormCompletarPerfil()
    {
        $usuario = Auth::user()->datoUsuario;
        $from = "perfil";

        return view('rutac.usuario.completar-perfil', compact('usuario', 'from'));
    }

    public function guardarPerfil(Request $request)
    {
        $rules = [
            'nombre_completo' => 'required',
            'direccion' => 'required|max:200',
            'telefono' => 'required|max:15',
            'fecha_nacimeinto' => 'date_format:YYYY-MM-DD',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('user.completar-perfil')->with([
                'error' => __('Ocurrió un error intente nuevamente.'),
            ]);
        }

        $datoUsuario = DatoUsuario::where('dato_usuarioID', Auth::user()->dato_usuarioID)->first();
        $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $request->input('nombre_completo');
        $datoUsuario->dato_usuarioDIRECCION = $request->input('direccion');
        $datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA = $request->input('departamento_residencia');
        if ($request->input('municipio_residencia')) {
            $datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA = $request->input('municipio_residencia');
        }
        $datoUsuario->dato_usuarioTELEFONO = $request->input('telefono');
        $datoUsuario->dato_usuarioSEXO = $request->input('genero');
        $datoUsuario->dato_usuarioFECHA_NACIMIENTO = $request->input('fecha_nacimiento');
        $datoUsuario->dato_usuarioDEPARTAMENTO_NACIMIENTO = $request->input('departamento_nacimiento');
        if ($request->input('municipio_nacimiento')) {
            $datoUsuario->dato_usuarioMUNICIPIO_NACIMIENTO = $request->input('municipio_nacimiento');
        }
        $datoUsuario->dato_usuarioNIVEL_ESTUDIO = $request->input('nivel_estudios');
        $datoUsuario->dato_usuarioPROFESION_OCUPACION = $request->input('profesion');
        $datoUsuario->dato_usuarioCARGO = $request->input('cargo');
        $datoUsuario->dato_usuarioREMUNERACION = $request->input('remuneracion');
        $datoUsuario->dato_usuarioGRUPO_ETNICO = $request->input('grupo_etnico');
        $datoUsuario->dato_usuarioDISCAPACIDAD = $request->input('discapacidad');
        if ($request->input('idiomas')) {
            $datoUsuario->dato_usuarioIDIOMAS = $this->obtenerIdiomas($request->input('idiomas'));
        }
        $datoUsuario->save();

        $usuario = User::where('usuarioID', Auth::user()->dato_usuarioID)->first();
        $usuario->perfilCompleto = 'Si';
        $usuario->save();

        return redirect()->route('user.home')->with([
            'success' => __('Datos actualizados correctamente'),
        ]);
    }

    public function actualizarPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'anterior_password' => 'required',
            'nuevo_password' => 'required|min:6',
            'repetir_password'    => 'required|same:nuevo_password'
        ]);

        if ($validator->fails()) {

            return redirect()->route('user.usuario.mi-perfil')->with([
                'error' => __('Ocurrió un error en los datos. Intente nuevamente'),
            ]);
        }

        if (Auth::attempt(['usuarioID' => Auth::user()->usuarioID, 'password' => $request->anterior_password])) {
            DB::table('usuarios')
                ->where('usuarioID', Auth::user()->usuarioID)
                ->update(['password' => bcrypt($request->input('nuevo_password'))]);
            $request->session()->flash("message_success", "Contraseña guardada correctamente");

            return redirect()->route('user.usuario.mi-perfil')->with([
                'success' => __('Contraseña actualizada correctamente'),
            ]);
        } else {

            return redirect()->route('user.usuario.mi-perfil')->with([
                'error' => __('Ocurrió un error actualizando la contraseña. Intente nuevamente'),
            ]);
        }
    }

    public function reenviarCodigo(Request $request)
    {
        $usuario = User::where('usuarioID', Auth::user()->usuarioID)->first();
        if ($usuario) {
            $usuario->confirmation_code = Str::random(25);
            $usuario->save();

            Mail::send(new RutaCMail($usuario, 'reenvio_codigo'));

            $request->session()->flash("message_success", "Código enviado correctamente. Revisa tu correo, sigue el enlace y accede a todas las funciones de Ruta C ");
            return back();
        }
        $request->session()->flash("message_error", "Ocurrió un error, intente nuevamente");
        return back();
    }

    public function buscarMunicipios($departamento)
    {
        $repository = $this->repository->municipios($departamento);
        return $repository;
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

<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\FormRepository;

class PublicController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Trae los municipios del departamento
     *
     * @return array
     */
    public function buscarMunicipios($departamento){
        $repository = $this->repository->municipios($departamento);
        return $repository;
    }
	
	public function getDocumento($file){
        $full_path = storage_path(env('PATH_DOCUMENTO').'/'.$file);
        return response()->download($full_path);
    }

    public function verify($code, Request $request){
        if(Auth::user()){
            $user = User::where('confirmation_code', $code)->first();
            if (! $user)
                return redirect('/');

            $user->confirmed = 1;
            $user->confirmation_code = null;
            $user->save();

            if(Auth::user()->usuarioID == $user->usuarioID){
                $request->session()->flash("message_success", "El correo fue verificado exitosamente");
                return redirect('/home');
            }else{
                Auth::logout();
                return view('rutac.verificado');
            }
        }else{
            $user = User::where('confirmation_code', $code)->first();
            if (! $user)
                return redirect('/');

            $user->confirmed = 1;
            $user->confirmation_code = null;
            $user->save();

            return view('rutac.verificado');
        }
    }

    public function actualizarDatos($code, Request $request){
        if(Auth::user()){
            $user = User::where('update_code', $code)->with('datoUsuario')->first();
            if (! $user)
                return redirect('/');

            $user->update_code = null;
            $user->save();

            $tipoIdentificacion = $this->obtenerTipoIdentificacion($user->datoUsuario->dato_usuarioTIPO_IDENTIFICACION);
            $identificacion  = $user->datoUsuario->dato_usuarioIDENTIFICACION;
            $nombres = $user->datoUsuario->dato_usuarioNOMBRES;
            $apellidos  = $user->datoUsuario->dato_usuarioAPELLIDOS;
            $municipio_residencia  = $user->datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA;
            $direccion  = $user->datoUsuario->dato_usuarioDIRECCION;
            $telefono  = $user->datoUsuario->dato_usuarioTELEFONO;
            $correo_electronico  = $user->usuarioEMAIL;
            if(Auth::user()->usuarioID == $user->usuarioID){
                $request->session()->flash("message_success", "Los datos fueron actualizados correctamente");
                return redirect('/home');
            }else{
                Auth::logout();
                
                return view('rutac.actualizado',compact("tipoIdentificacion","identificacion","nombres","apellidos","municipio_residencia","direccion","telefono","correo_electronico"));
            }
        }else{
            $user = User::where('update_code', $code)->first();
            if (! $user)
                return redirect('/');

            $user->update_code = null;
            $user->save();

            $tipoIdentificacion = $this->obtenerTipoIdentificacion($user->datoUsuario->dato_usuarioTIPO_IDENTIFICACION);
            $identificacion  = $user->datoUsuario->dato_usuarioIDENTIFICACION;
            $nombres = $user->datoUsuario->dato_usuarioNOMBRES;
            $apellidos  = $user->datoUsuario->dato_usuarioAPELLIDOS;
            $municipio_residencia  = $user->datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA;
            $direccion  = $user->datoUsuario->dato_usuarioDIRECCION;
            $telefono  = $user->datoUsuario->dato_usuarioTELEFONO;
            $correo_electronico  = $user->usuarioEMAIL;
            return view('rutac.actualizado',compact("tipoIdentificacion","identificacion","nombres","apellidos","municipio_residencia","direccion","telefono","correo_electronico"));
        }
    }

    public function nuevoRegistro(){
        return view('rutac.nuevo-registro');
    }

    public function obtenerTipoIdentificacion($tipoIdentificacion){
        switch($tipoIdentificacion){
            case 'CC':
                return '1';
            break;
            case 'NIT':
                return '2';
            break;
            case 'CE':
                return '3';
            break;
            case 'TI':
                return '4';
            break;
            case 'PP':
                return '5';
            break;
            case 'PJ':
                return '6';
            break;
            default:
                'OTRO';
        }
    }
}
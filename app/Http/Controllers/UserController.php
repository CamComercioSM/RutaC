<?php

namespace App\Http\Controllers;

use Auth;
use App\Municipio;
use App\DatoUsuario;
use App\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\FormRepository;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormRepository $repository)
    {
        $this->middleware('auth');
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
     * @return \Illuminate\Http\Response
     */
    public function miPerfil()
    {
        return view('rutac.usuario.perfil');
    }
    
    public function configuracion()
    {
        return view('rutac.usuario.configuracion');
    }

    public function showFormCompletarPerfil(){
        $usuario = Auth::user()->datoUsuario;
        $empresas = Auth::user()->empresas->first();
        $emprendimientos = Auth::user()->emprendimientos->first();
        $repositoryDepartamentos = $this->repository->departamentos();
        $repository = $this->repository;

        return view('rutac.usuario.completar-perfil',compact('usuario','repositoryDepartamentos','repository','empresas','emprendimientos'));
    }

    public function guardarPerfil(Request $request){
        
        //return $request;

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
                $datoUsuario = DatoUsuario::where('dato_usuarioID',Auth::user()->dato_usuarioID)->first();
                $datoUsuario->dato_usuarioNOMBRE_COMPLETO = $request->nombre_completo;
                $datoUsuario->dato_usuarioDIRECCION = $request->direccion;
                $datoUsuario->dato_usuarioDEPARTAMENTO_RESIDENCIA = $this->obtenerDepartamento($request->departamento_residencia);
                $datoUsuario->dato_usuarioMUNICIPIO_RESIDENCIA = $this->obtenerMunicipio($request->municipio_residencia);
                $datoUsuario->dato_usuarioTELEFONO = $request->telefono;
                $datoUsuario->dato_usuarioSEXO = $request->genero;
                $datoUsuario->dato_usuarioFECHA_NACIMIENTO = $request->fecha_nacimiento;
                $datoUsuario->dato_usuarioDEPARTAMENTO_NACIMIENTO = $this->obtenerDepartamento($request->departamento_nacimiento);
                $datoUsuario->dato_usuarioMUNICIPIO_NACIMIENTO = $this->obtenerMunicipio($request->municipio_nacimiento);
                $datoUsuario->dato_usuarioNIVEL_ESTUDIO = $request->nivel_estudios;
                $datoUsuario->dato_usuarioPROFESION_OCUPACION = $request->profesion;
                $datoUsuario->dato_usuarioCARGO = $request->cargo;
                $datoUsuario->dato_usuarioREMUNERACION = $request->remuneracion;
                $datoUsuario->dato_usuarioGRUPO_ETNICO = $request->grupo_etnico;
                $datoUsuario->dato_usuarioDISCAPACIDAD = $request->discapacidad;
                $datoUsuario->dato_usuarioIDIOMAS = $this->obtenerIdiomas($request->idiomas);
                $datoUsuario->save();

                $data['status'] = 'Ok';
            }
        }
        return json_encode($data);
    }

    public function buscarMunicipios($departamento){
        $repository = $this->repository->municipios($departamento);
        return $repository;
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
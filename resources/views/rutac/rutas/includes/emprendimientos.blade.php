<h1>Emprendimientos Registrados</h1>
<div class="row">
@foreach($emprendimientos as $emprendimiento)
    <div class="col-md-3">
        <div class="card hovercard">
            <div class="info">
                <div class="title">
                    {{$emprendimiento->emprendimientoNOMBRE}}
                </div>
                <div class="desc">{{$emprendimiento->emprendimientoDESCRIPCION}}</div>
            </div>
            <div class="bottom">
                @if($emprendimiento->diagnosticosAll->count() == 0)
                <a class="btn btn-primary btn-sm @if(Auth::user()->confirmed != 1) showModal @endif @if(isset($diagnosticoEmprendimientoEstado)) @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif @endif" href="@if(isset($diagnosticoEmprendimientoEstado)) @if(Auth::user()->confirmed == 0 || $diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @endif @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                    <i class="fa fa-plus-circle"></i> Iniciar diagnóstico
                </a>
                @endif
                @if($emprendimiento->diagnosticosAll->count() == 1)
                    @if($emprendimiento->diagnosticosAll[0]->diagnosticoESTADO == 'Finalizado')
                    <a class="btn @if($emprendimiento->diagnosticos->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="ver-ruta/{{$emprendimiento->diagnosticos->ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta ({{$emprendimiento->diagnosticos->ruta->rutaESTADO}})">
                        <i class="fa fa-line-chart"></i> Ver ruta
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}}" data-toggle="tooltip" title="Ver últimos resultados">
                        <i class="fa fa-file-text-o"></i> Ver resultados
                    </a>
                    @else
                    <a class="btn btn-primary btn-sm @if(isset($diagnosticoEmprendimientoEstado)) @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif @endif" href="@if(isset($diagnosticoEmprendimientoEstado)) @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Activo') {{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @else javascript:void(0) @endif @endif" data-toggle="tooltip" title="Continuar diagnóstico">
                        <i class="fa fa-pencil-square-o"></i> Continuar Diagnóstico
                    </a>
                    @endif
                    @if($emprendimiento->diagnosticos->ruta->rutaESTADO == 'Finalizado')
                        <div><br></div>
                        <a class="btn btn-primary btn-sm @if(Auth::user()->confirmed != 1) showModal @endif @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif" href="@if(Auth::user()->confirmed == 0 || $diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                            <i class="fa fa-plus-circle"></i> Iniciar nuevo diagnóstico
                        </a>
                    @endif
                @endif
                @if($emprendimiento->diagnosticosAll->count() >= 2)
                    @if($emprendimiento->diagnosticosAll[0]->diagnosticoESTADO == 'Finalizado')
                    <a class="btn @if($emprendimiento->diagnosticosAll[0]->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="ver-ruta/{{$emprendimiento->diagnosticosAll[0]->ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta ({{$emprendimiento->diagnosticosAll[0]->ruta->rutaESTADO}})">
                        <i class="fa fa-line-chart"></i> Ver ruta
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}}" data-toggle="tooltip" title="Ver últimos resultados">
                        <i class="fa fa-file-text-o"></i> Ver resultados
                    </a>
                    @if($emprendimiento->diagnosticosAll[0]->ruta->rutaESTADO == 'Finalizado')
                        <div><br></div>
                        <a class="btn btn-primary btn-sm @if(Auth::user()->confirmed != 1) showModal @endif @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif" href="@if(Auth::user()->confirmed == 0 || $diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                            <i class="fa fa-plus-circle"></i> Iniciar nuevo diagnóstico
                        </a>
                    @endif
                    @else
                    <a class="btn @if($emprendimiento->diagnosticosAll[1]->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="ver-ruta/{{$emprendimiento->diagnosticosAll[1]->ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta ({{$emprendimiento->diagnosticosAll[1]->ruta->rutaESTADO}})">
                        <i class="fa fa-line-chart"></i> Ver ruta
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{action('DiagnosticosController@mostrarResultadoAnterior', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->diagnosticosAll[1]->diagnosticoID ])}}" data-toggle="tooltip" title="Ver últimos resultados">
                        <i class="fa fa-file-text-o"></i> Ver resultados
                    </a>
                    <div><br></div>
                    <a class="btn btn-primary btn-sm @if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmprendimiento @endif" href="@if($diagnosticoEmprendimientoEstado->tipo_diagnosticoESTADO == 'Activo') {{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'emprendimiento','id'=>$emprendimiento->emprendimientoID ])}} @else javascript:void(0) @endif" data-toggle="tooltip" title="Continuar diagnóstico">
                        <i class="fa fa-pencil-square-o"></i> Continuar Diagnóstico
                    </a>
                    @endif
                @endif
                <div><br></div>
                <a class="btn btn-success btn-sm" href="{{ url('emprendimiento', $emprendimiento->emprendimientoID) }}" data-toggle="tooltip" title="Ver emprendimiento">
                    <i class="fa fa-eye"></i> Ver emprendimiento
                </a>
            </div>
        </div>
    </div>
@endforeach
    <div class="col-md-3">
        <a href="@if(Auth::user()->confirmed == 1) {{ action('RutaController@showFormAgregarEmprendimiento') }} @else javascript:void(0) @endif" @if(Auth::user()->confirmed != 1) class="showModal" @endif>
            <div class="card hovercard">
                <div class="info">
                    <i class="fa fa-plus plusIcon"></i><br>
                    <div class="title">Agregar nuevo emprendimiento</div>
                </div>
            </div>
        </a>
    </div>
</div>
<h1>Empresas Registradas</h1>
<div class="row">
@foreach($empresas as $empresa)
    <div class="col-md-3">
        <div class="card hovercard">
            <div class="info">
                <div class="title">
                    {{$empresa->empresaRAZON_SOCIAL}}
                </div>
                <div class="desc">Nit: {{$empresa->empresaNIT}}</div>
            </div>
            <div class="bottom">
                @if($empresa->diagnosticosAll->count() == 0)
                <a class="btn btn-primary btn-sm @if(Auth::user()->confirmed != 1) showModal @endif @if(isset($diagnosticoEmpresaEstado)) @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif @endif" href="@if(isset($diagnosticoEmpresaEstado)) @if(Auth::user()->confirmed == 0 || $diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @endif @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                    <i class="fa fa-plus-circle"></i> Iniciar Diagnóstico
                </a>
                @endif
                @if($empresa->diagnosticosAll->count() == 1)
                    @if($empresa->diagnosticosAll{0}->diagnosticoESTADO == 'Finalizado')
                    <a class="btn @if($empresa->diagnosticos->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="ver-ruta/{{$empresa->diagnosticos->ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta ({{$empresa->diagnosticos->ruta->rutaESTADO}})">
                        <i class="fa fa-line-chart"></i> Ver ruta
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}}" data-toggle="tooltip" title="Ver últimos resultados">
                        <i class="fa fa-file-text-o"></i> Ver resultados
                    </a>
                    @else
                    <a class="btn btn-primary btn-sm @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif" href="@if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Activo') {{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @else javascript:void(0) @endif" data-toggle="tooltip" title="Continuar diagnóstico">
                        <i class="fa fa-pencil-square-o"></i> Continuar Diagnóstico
                    </a>
                    @endif
                    @if($empresa->diagnosticos->ruta->rutaESTADO == 'Finalizado')
                        <div><br></div>
                        <a class="btn btn-primary btn-sm @if(Auth::user()->confirmed != 1) showModal @endif @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif" href="@if(Auth::user()->confirmed == 0 || $diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                            <i class="fa fa-plus-circle"></i> Iniciar nuevo diagnóstico
                        </a>
                    @endif
                @endif
                @if($empresa->diagnosticosAll->count() >= 2)
                    @if($empresa->diagnosticosAll{0}->diagnosticoESTADO == 'Finalizado')
                    <a class="btn @if($empresa->diagnosticosAll{0}->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="ver-ruta/{{$empresa->diagnosticosAll{0}->ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta ({{$empresa->diagnosticosAll{0}->ruta->rutaESTADO}})">
                        <i class="fa fa-line-chart"></i> Ver ruta
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}}" data-toggle="tooltip" title="Ver últimos resultados">
                        <i class="fa fa-file-text-o"></i> Ver resultados
                    </a>
                    @if($empresa->diagnosticosAll{0}->ruta->rutaESTADO == 'Finalizado')
                        <div><br></div>
                        <a class="btn btn-primary btn-sm @if(Auth::user()->confirmed != 1) showModal @endif @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif" href="@if(Auth::user()->confirmed == 0 || $diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') javascript:void(0) @else {{action('DiagnosticosController@iniciarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @endif" title="Iniciar diagnóstico" data-toggle="tooltip">
                            <i class="fa fa-plus-circle"></i> Iniciar nuevo diagnóstico
                        </a>
                    @endif
                    @else
                    <a class="btn @if($empresa->diagnosticosAll{1}->ruta->rutaESTADO == 'Finalizado') bg-olive @else btn-warning @endif btn-sm" href="ver-ruta/{{$empresa->diagnosticosAll{1}->ruta->rutaID}}" data-toggle="tooltip" title="Ver ruta ({{$empresa->diagnosticosAll{1}->ruta->rutaESTADO}})">
                        <i class="fa fa-line-chart"></i> Ver ruta
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{action('DiagnosticosController@mostrarResultadoAnterior', ['tipo'=> 'empresa','id'=>$empresa->diagnosticosAll{1}->diagnosticoID ])}}" data-toggle="tooltip" title="Ver últimos resultados">
                        <i class="fa fa-file-text-o"></i> Ver resultados
                    </a>
                    <div><br></div>
                    <a class="btn btn-primary btn-sm @if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Inactivo') showModalEmpresa @endif" href="@if($diagnosticoEmpresaEstado->tipo_diagnosticoESTADO == 'Activo') {{action('DiagnosticosController@continuarDiagnostico', ['tipo'=> 'empresa','id'=>$empresa->empresaID ])}} @else javascript:void(0) @endif" data-toggle="tooltip" title="Continuar diagnóstico">
                        <i class="fa fa-pencil-square-o"></i> Continuar Diagnóstico
                    </a>
                    @endif
                @endif
                <div><br></div>
                <a class="btn btn-success btn-sm" href="{{ url('empresa', $empresa->empresaID) }}" data-toggle="tooltip" title="Ver empresa">
                    <i class="fa fa-eye"></i> Ver empresa
                </a>
            </div>
        </div>
    </div>
@endforeach
    <div class="col-md-3">
        <a href="@if(Auth::user()->confirmed == 1) {{ action('RutaController@showFormAgregarEmpresa') }} @else javascript:void(0) @endif" @if(Auth::user()->confirmed != 1) class="showModal" @endif>
            <div class="card hovercard">
                <div class="info">
                    <i class="fa fa-plus plusIcon"></i><br>
                    <div class="title">Agregar nueva empresa</div>
                </div>
            </div>
        </a>
    </div>
</div>
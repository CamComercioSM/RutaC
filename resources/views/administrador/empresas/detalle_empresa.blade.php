@extends('administrador.app')
@section('title','RutaC | Empresa')
@section('app-content')
<section class="content">
    @if($empresa)
        <div class="container">
            <div class="row justify-content">
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-content-center">
                                <h5>{{$empresa->empresaRAZON_SOCIAL}}</h5>
                            </div>
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-sm">
                                    <a class="p-1" href="{{ route('admin.empresas.edit', $empresa) }}">
                                        <i class="fas fa-edit text-warning"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content">
                                <div class="col-md-12">
                                    <strong>NIT</strong>
                                    <p class="text-muted">{{$empresa->empresaNIT}}</p>

                                <!-- <strong>Matrícula mercantil</strong>
                                <p class="text-muted">{{$empresa->empresaMATRICULA_MERCANTIL}}</p>-->

                                    <strong>Organización jurídica</strong>
                                    <p class="text-muted">{{$empresa->empresaORGANIZACION_JURIDICA}}</p>

                                <!--<strong>Fecha de constitución</strong>
                                <p class="text-muted">{{$empresa->empresaFECHA_CONSTITUCION}}</p>-->

                                    <strong>Dirección</strong>
                                    <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->empresaDIRECCION_FISICA}}</p>
                                    <p class="text-muted">{{$empresa->empresaDEPARTAMENTO_EMPRESA}} - {{$empresa->empresaMUNICIPIO_EMPRESA}}</p>

                                <!--<p class="text-muted" style="margin-bottom: 0px;"><b>Empleados fijos: </b>{{$empresa->empresaEMPLEADOS_FIJOS}}</p>
                                <p class="text-muted" style="margin-bottom: 0px;"><b>Empleados temporales: </b>{{$empresa->empresaEMPLEADOS_TEMPORALES}}</p>
                                <p class="text-muted"><b>Rangos activos: </b>{{$empresa->empresaRANGOS_ACTIVOS}}</p>-->
                                    <strong>Pagina web</strong>
                                    <p class="text-muted"><a href="http://{{$empresa->empresaSITIO_WEB}}" target="_blank">{{$empresa->empresaSITIO_WEB}}</a></p>
                                    <strong>Redes sociales </strong><br>
                                    <div class="text-center">
                                        @if($empresa->facebook)
                                            <a href="https://www.facebook.com/{{$empresa->facebook}}" target="_blank" class="btn-floating btn-sm mx-1" style="color: #3b5998">
                                                <i class="fab fa-facebook fa-2x"> </i>
                                            </a>
                                        @endif
                                        @if($empresa->instagram)
                                            <a href="https://www.instagram.com/{{$empresa->instagram}}" target="_blank" class="btn-floating btn-sm mx-1" style="color: #3f729b">
                                                <i aria-hidden="true" class="fab fa-instagram fa-2x"></i>
                                            </a>
                                        @endif
                                        @if($empresa->twitter)
                                            <a href="https://www.twitter.com/{{$empresa->twitter}}" target="_blank" class="btn-floating btn-sm mx-1" style="color: #00acee">
                                                <i class="fab fa-twitter fa-2x"> </i>
                                            </a>
                                        @endif
                                        @if(!$empresa->facebook && !$empresa->instagram && !$empresa->twitter)
                                            <p class="text-muted" style="margin-bottom: 0px;">No posee redes registradas</p>
                                        @endif

                                    </div>

                                    <strong>Contacto principal</strong>
                                    <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->nombreContactoCial}}</p>
                                    <p class="text-muted">{{$empresa->telefonoContactoCial}} - {{$empresa->correoContactoCial}}</p>

                                <!--<strong>Contacto talento humano</strong>
                                <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->nombreContactoTH}}</p>
                                <p class="text-muted">{{$empresa->telefonoContactoTH}} - {{$empresa->correoContactoTH}}</p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-content-center">
                                <h5>Diagnósticos</h5>
                            </div>
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.empresas.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($empresa->diagnosticosAll->count() > 0)
                                <b-card title="{{ $empresa->diagnosticosAll[0]->tipoDiagnostico->tipo_diagnosticoNOMBRE }}" sub-title="Realizado: {{ $empresa->diagnosticosAll[0]->diagnosticoFECHA }}" class="bg-white">
                                    <b-card-text>
                                        <div class="row">
                                            <div class="col">
                                                <b>{{ __('Resultado') }}: </b>{{ $empresa->diagnosticosAll[0]->diagnosticoRESULTADO }}
                                            </div>
                                            <div class="col">
                                                <b>{{ __('Nivel') }}: </b>{{ $empresa->diagnosticosAll[0]->diagnosticoNIVEL }}
                                            </div>
                                            <div class="col">
                                                <b>{{ __('Estado') }}: </b>{{ $empresa->diagnosticosAll[0]->diagnosticoESTADO }}
                                            </div>
                                        </div>
                                    </b-card-text>

                                    <b-card-text>
                                        <b>Feedback: </b>
                                        {{ $empresa->diagnosticosAll[0]->diagnosticoMENSAJE }}
                                    </b-card-text>

                                    @if($empresa->diagnosticosAll[0]->diagnosticoESTADO == 'Finalizado')
                                        <b-button variant="primary" size="sm" class="w-25"  href="{{ route('admin.ver-resultado',$empresa->diagnosticosAll[0]) }}">
                                            <i class="fas fa-chart-area"></i> Ver Resultados
                                        </b-button>

                                        <b-button variant="info" size="sm" class="w-25" href="{{ route('admin.revisar-ruta', ['ruta'=> $empresa->diagnosticosAll[0]->ruta->rutaID ]) }}">
                                            <i class="fas fa-signal"></i> Ver Ruta
                                        </b-button>
                                    @endif
                                </b-card>
                            @else
                                <h3>No ha iniciado diagnosticos</h3>
                            @endif
                            @if ($empresa->diagnosticosAll->count() > 1)
                                    <b-button v-b-toggle.collapse-2 block size="sm" variant="outline-primary" class="m-1">Diagnósticos anteriores</b-button>
                                    <b-collapse id="collapse-2">
                                        @endif
                                        @forelse($empresa->diagnosticosAll as $key => $diagnostico)
                                            @if ($key > 0)
                                                <b-card title="{{ $diagnostico->tipoDiagnostico->tipo_diagnosticoNOMBRE }}" sub-title="Realizado: {{ $diagnostico->diagnosticoFECHA }}" class="bg-white">
                                                    <b-card-text>
                                                        <div class="row">
                                                            <div class="col">
                                                                <b>{{ __('Resultado') }}: </b>{{ $diagnostico->diagnosticoRESULTADO }}
                                                            </div>
                                                            <div class="col">
                                                                <b>{{ __('Nivel') }}: </b>{{ $diagnostico->diagnosticoNIVEL }}
                                                            </div>
                                                            <div class="col">
                                                                <b>{{ __('Estado') }}: </b>{{ $diagnostico->diagnosticoESTADO }}
                                                            </div>
                                                        </div>
                                                    </b-card-text>

                                                    <b-card-text>
                                                        <b>Feedback: </b>
                                                        {{ $diagnostico->diagnosticoMENSAJE }}
                                                    </b-card-text>

                                                    <b-button variant="primary" size="sm" class="w-25"  href="{{ route('admin.ver-resultado', $diagnostico) }}">
                                                        <i class="fas fa-chart-area"></i> Ver Resultados
                                                    </b-button>

                                                    <b-button variant="info" size="sm" class="w-25" href="{{ route('admin.revisar-ruta', ['ruta'=> $diagnostico->ruta->rutaID ]) }}">
                                                        <i class="fas fa-signal"></i> Ver Ruta
                                                    </b-button>
                                                </b-card>
                                            @endif
                                        @empty

                                        @endforelse
                                        @if ($empresa->diagnosticosAll->count() > 1)
                                    </b-collapse>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endif
</section>

@endsection

@push('modals')
    @include('layouts.modals.__confirm_delete')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush

@section('style')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<style>
    hr{
        margin-top: 5px;
        margin-bottom: 5px;
    }
</style>

@endsection
@section('footer')
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script type="text/javascript">
	$("#btn-submit").click(function(){
        $('.capa').css("visibility", "visible");
        $('#btn-submit').attr("disabled", true);
        $("#formGuardarEmpresa").submit();
    });
    $('#departamento_empresa,#municipio_empresa').select2();

    $('#departamento_empresa').change(function() {
        $('#municipio_empresa')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Seleccione una opción</option>')
            .val('Seleccione una opción')
        ;
        buscarMunicipiosR($('#departamento_empresa').val());
    });
    function buscarMunicipiosR(departamento){
        $.ajax({
            url: "{{url('buscar_municipios')}}/"+departamento,
            type: 'get',
            dataType: 'json',
            success: function(data){
                $.each(data, function (i, item) {
                    $('#municipio_empresa').append($('<option>', {
                        value: item.id_municipio,
                        text : item.municipio
                    }));
                });
                $('#municipio_empresa').prop('disabled', false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
            }
        });
    }
    $('#fecha_constitucion').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    });

</script>

@endsection

@extends('rutac.app')

@section('title','RutaC | Empresa')

@section('app-content')
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
                                <a class="p-1" href="{{ route('user.empresas.edit', $empresa) }}">
                                    <i class="fas fa-edit text-warning"></i>
                                </a>

                                <button type="button" class="btn btn-link text-danger" data-route="{{ route('user.empresas.destroy', $empresa) }}" data-toggle="modal" data-target="#confirmDeleteModal" title="{{ __('Eliminar') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
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

                                <strong>Fecha de constitución</strong>
                                <p class="text-muted">{{$empresa->empresaFECHA_CONSTITUCION}}</p>

                                <strong>Dirección</strong>
                                <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->empresaDIRECCION_FISICA}}</p>
                                <p class="text-muted">{{$empresa->empresaDEPARTAMENTO_EMPRESA}} - {{$empresa->empresaMUNICIPIO_EMPRESA}}</p>

                                <p class="text-muted" style="margin-bottom: 0px;"><b>Empleados fijos: </b>{{$empresa->empresaEMPLEADOS_FIJOS}}</p>
                                <p class="text-muted" style="margin-bottom: 0px;"><b>Empleados temporales: </b>{{$empresa->empresaEMPLEADOS_TEMPORALES}}</p>
                                <p class="text-muted"><b>Rangos activos: </b>{{$empresa->empresaRANGOS_ACTIVOS}}</p>

                                <a href="http://{{$empresa->empresaSITIO_WEB}}" target="_blank">{{$empresa->empresaSITIO_WEB}}</a><br>
                                <strong>Redes sociales </strong><br>
                                <div class="text-center pt-1 pb-1">
                                    @if($empresa->facebook)
                                        <a class="p-1" href="https://www.facebook.com/{{$empresa->facebook}}">
                                            <i class="fab fa-facebook fa-2x"></i>
                                        </a>
                                    @endif
                                    @if($empresa->instagram)
                                        <a class="p-1" href="https://www.instagram.com/{{$empresa->facebook}}">
                                            <i class="fab fa-instagram fa-2x"></i>
                                        </a>
                                    @endif
                                    @if($empresa->twitter)
                                        <a class="p-1" href="https://www.twitter.com/{{$empresa->facebook}}">
                                            <i class="fab fa-twitter fa-2x"></i>
                                        </a>
                                    @endif
                                    @if(!$empresa->facebook && !$empresa->instagram && !$empresa->twitter)
                                        <p class="text-muted" style="margin-bottom: 0px;">No posee redes registradas</p>
                                    @endif

                                </div>

                                <strong>Contacto comercial</strong>
                                <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->nombreContactoCial}}</p>
                                <p class="text-muted">{{$empresa->telefonoContactoCial}} - {{$empresa->correoContactoCial}}</p>

                                <strong>Contacto talento humano</strong>
                                <p class="text-muted" style="margin-bottom: 0px;">{{$empresa->nombreContactoTH}}</p>
                                <p class="text-muted">{{$empresa->telefonoContactoTH}} - {{$empresa->correoContactoTH}}</p>
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
                                <a href="{{ route('user.ruta.iniciar-ruta') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.modals.__confirm_delete')
@endpush
@push('scripts')
    <script src="{{ asset(mix('js/delete-modal.js')) }}"></script>
@endpush

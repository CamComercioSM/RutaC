@extends('administrador.app')
@section('app-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header pb-0">
                        <h5 class="card-title">{{ __('Editar Mensaje') }}</h5>
                    </div>
                    <rc-form
                            action="{{ route('admin.diagnosticos.feedback.update', [$diagnostico, $feedback]) }}"
                            method="post"
                    >
                        <div class="card-body">
                            @csrf
                            @method('PATCH')
                            @include('administrador.diagnosticos.feedback.__form')
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ old('redirect', URL::previous()) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> {{ __('Cancelar') }}
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save"></i> {{ __('Guardar') }}
                            </button>
                        </div>
                    </rc-form>
                </div>
            </div>
        </div>
    </div>

@endsection

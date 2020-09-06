@extends('rutac.app')

@section('title','RutaC | Editar emprendimiento')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{ __('Editar emprendimiento') }}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.emprendimientos.show', $emprendimiento) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <rc-form
                                action="{{ route('user.emprendimientos.update', $emprendimiento) }}"
                                method="post"
                        >
                            @method('PATCH')
                            @include('rutac.emprendimientos.__form')
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Guardar emprendimiento') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

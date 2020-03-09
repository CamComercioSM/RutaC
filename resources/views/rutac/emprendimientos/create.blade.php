@extends('rutac.app')

@section('title','RutaC | Agregar emprendimiento')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{ __('Agregar empresa') }}</h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <rc-form
                                action="{{ route('user.emprendimientos.store') }}"
                                method="post"
                        >
                            @include('rutac.emprendimientos.__form')
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Crear emprendimiento') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

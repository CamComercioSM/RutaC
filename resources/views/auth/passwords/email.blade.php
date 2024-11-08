@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Restablecer Contraseña</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('usuarioEMAIL') ? ' has-error' : '' }}">
                            <label for="usuarioEMAIL" class="col-md-4 control-label">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="usuarioEMAIL" type="email" class="form-control" name="usuarioEMAIL" value="{{ old('usuarioEMAIL') }}" required>

                                @if ($errors->has('usuarioEMAIL'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usuarioEMAIL') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_KEY')}}"></div>
                                <span class="form-control-feedback" id="alert_error_g-recaptcha-response"></span>
                                <span class="text-danger" id="error_g-recaptcha-response"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Enviar enlace para restablecer contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

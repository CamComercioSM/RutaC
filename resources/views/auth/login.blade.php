@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <div class="register-box-body" style="text-align: justify;">
                    <img src="public/dist/img/mails/01.png" style="max-width: 100%" >
                    <h2><b>BIENVENIDOS A RUTA C</b></h2>
                    <p>Ruta C es un programa de acompañamiento que ofrece la Cámara de Comercio de Santa Marta para el Magdalena a través del cual podrás determinar una ruta que te permita fortalecer tu actividad empresarial o tu idea de negocios. </p>
                </div>
            </div>
        </div>        
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">Inicio de Sesión</div>
                <div class="panel-body">
                    @if ($errors->has('usuarioEMAIL'))
                        <span class="help-block text-center" style="color: #dd4b39;">
                            <strong>{{ $errors->first('usuarioEMAIL') }}</strong>
                        </span>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('usuarioEMAIL') ? ' has-error' : '' }}">
                            <label for="usuarioEMAIL" class="col-md-4 control-label">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="usuarioEMAIL" type="email" class="form-control" name="usuarioEMAIL" value="{{ old('usuarioEMAIL') }}" required>

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('usuarioEMAIL') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Ingresar
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Olvidé mi contraseña
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

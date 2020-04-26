<div class="form-group col-md-12">
    <dl class="row">
        <dt class="col-md-2">{{ __('Nombre Completo') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioNOMBRE_COMPLETO}}</dd>

        <dt class="col-md-2">{{ __('Documento de identidad') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->dato_usuarioIDENTIFICACION}}</dd>

        <dt class="col-md-2">{{ __('Género') }}</dt>
        <dd class="col-md-4">@if($usuario->dato_usuarioSEXO) {{$usuario->dato_usuarioSEXO}} @else - @endif</dd>

        <dt class="col-md-2">{{ __('Grupo Étnico') }}</dt>
        <dd class="col-md-4">@if($usuario->dato_usuarioGRUPO_ETNICO) {{$usuario->dato_usuarioGRUPO_ETNICO}} @else - @endif</dd>

        <dt class="col-md-2">{{ __('Discapacidad') }}</dt>
        <dd class="col-md-4">@if($usuario->dato_usuarioDISCAPACIDAD) {{$usuario->dato_usuarioDISCAPACIDAD}} @else - @endif</dd>

        <dt class="col-md-2">{{ __('Fecha y lugar de nacimiento') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioFECHA_NACIMIENTO}} - {{$usuario->dato_usuarioMUNICIPIO_NACIMIENTO}}, {{$usuario->dato_usuarioDEPARTAMENTO_NACIMIENTO}}</dd>

        <dt class="col-md-2">{{ __('Idiomas') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioIDIOMAS}}</dd>
    </dl>
</div>
<div class="form-group col-md-12">
    <dl class="row">
        <dt class="col-md-2">{{ __('Lugar de residencia') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioDIRECCION}} - {{$usuario->dato_usuarioMUNICIPIO_RESIDENCIA}}, {{$usuario->dato_usuarioDEPARTAMENTO_RESIDENCIA}}</dd>

        <dt class="col-md-2">{{ __('Teléfono') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioTELEFONO}}</dd>

        <dt class="col-md-2">{{ __('Nivel de estudios') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioNIVEL_ESTUDIO}}</dd>

        <dt class="col-md-2">{{ __('Profesión') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioPROFESION_OCUPACION}}</dd>

        <dt class="col-md-2">{{ __('Discapacidad') }}</dt>
        <dd class="col-md-4">@if($usuario->dato_usuarioDISCAPACIDAD) {{$usuario->dato_usuarioDISCAPACIDAD}} @else - @endif</dd>

        <dt class="col-md-2">{{ __('Cargo') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioCARGO}}</dd>

        <dt class="col-md-2">{{ __('Remuneración') }}</dt>
        <dd class="col-md-4">{{$usuario->dato_usuarioREMUNERACION}}</dd>
    </dl>
</div>

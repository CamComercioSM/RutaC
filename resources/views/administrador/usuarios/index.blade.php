@extends('administrador.app')
@section('title','RutaC | Usuarios')
@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div>
                    <b-card no-body>
                        <b-tabs card>
                            <b-tab title="Usuarios Ruta C" active>
                                <b-card-text>
                                    <div class="text-right form-group">
                                        <a class="btn btn-sm btn-success" href="{{ action('Admin\ExportController@exportarUsuarios') }}">
                                            <i class="fas fa-file-excel"></i> Exportar Usuarios
                                        </a>
                                    </div>
                                    <div class="table-responsive-lg">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Documento') }}</th>
                                                <th>{{ __('Nombre Completo') }}</th>
                                                <th>{{ __('Correo') }}</th>
                                                <th class="text-right"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($usuarios as $key=> $usuario)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td class="text-left">{{$usuario->datoUsuario->dato_usuarioTIPO_IDENTIFICACION}} - {{$usuario->datoUsuario->dato_usuarioIDENTIFICACION}}</td>
                                                    <td class="text-left">{{$usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
                                                    <td class="text-left">{{$usuario->usuarioEMAIL}}</td>
                                                    <td class="text-center">
                                                        <a class="btn btn-primary btn-sm" href="{{action('Admin\UsuarioController@verUsuario', ['usuarioID'=> $usuario->usuarioID ])}}" style="width:50px;">Ver</a>
                                                        <button type="button" data-toggle="modal" data-target="#modal-reset-password" class="btn btn-primary btn-sm">Restablecer Clave</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </b-card-text>
                            </b-tab>
                            <b-tab title="Administradores">
                                <b-card-text>
                                    <div class="table-responsive-lg">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Nombre Administrador') }}</th>
                                                <th>{{ __('Correo') }}</th>
                                                <th class="text-right"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($administradores as $key=> $usuario)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td class="text-left">{{$usuario->datoUsuario->dato_usuarioNOMBRE_COMPLETO}}</td>
                                                    <td class="text-left">{{$usuario->usuarioEMAIL}}</td>
                                                    <td class="text-center">
                                                        @if($usuario->usuarioID != Auth::user()->usuarioID)
                                                            <a class="btn btn-warning btn-sm" href="">
                                                                Editar
                                                            </a>
                                                            <a class="btn btn-danger btn-sm" onclick="eliminarUsuario('{{$usuario->usuarioID}}');return false;" href="javascript:void(0)">
                                                                Eliminar
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </b-card-text>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')

<div class="control-sidebar-bg"></div>
<div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <h3 class="parr">¿Seguro que desea eliminar este usuario?</h3>
                            <input type="hidden" id="usuarioID" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                <button type="button" id="confirmar" data-dismiss="modal" class="btn btn-primary pull-right">Si</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-reset-password">
    <div class="modal-dialog">
        <form id="resetPassword" action="" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Restablecer Contraseña</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input type="hidden" name="usuarioEMAIL" id="usuarioEMAIL" value="{{$usuario->usuarioEMAIL}}">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            Se enviará un link de restablecimiento de contraseña al correo: {{$usuario->usuarioEMAIL}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="reset-password" class="btn btn-primary">Restablecer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function eliminarUsuario(usuarioID){
        $('#usuarioID').val(usuarioID);
        $('#modal-eliminar').modal('show');
    }

    $("#confirmar").click(function(){
        $('#modal-eliminar').modal('hide');
        $('.capa').css("visibility", "visible");
        $('#confirmar').attr("disabled", true);
        var usuarioID = $('#usuarioID').val();

        $.ajax({
            url: "{{url('admin/eliminar-usuario')}}/"+usuarioID,
            type: 'get',
            dataType: 'json',
            success: function(data){
                if(data.status == 'OK'){
                    location.reload();
                }
                if(data.status == 'ERROR'){
                    alert('Ocurrió un error');
                }
                $('.capa').css("visibility", "hidden");
                $('#confirmar').attr("disabled", false);
            },
            error: function(xhr, data, error){
                console.log("Ocurrió un error");
                $('.capa').css("visibility", "hidden");
                $('#confirmar').attr("disabled", false);
                alert('Ocurrió un error');
            }
        });
    });

    $('#btn-reset-password').click(function(){
        $('.capa').css("visibility", "visible");
        $('#btn-reset-password').attr("disabled", true);
    });

    $('#reset-password').click(function(){
        var values = getValuesResetPassword();
        resetPassword(values);
    });
    function getValuesResetPassword(){
        var values = new Object;
        var inputs = $("#resetPassword").find('input, textarea');
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');
            $("#error_"+name).html('');
        }
        return values;
    }
    function resetPassword(values){
        $('.capa').css("visibility", "visible");
        $('#reset-password').attr("disabled", true);
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('admin/usuario/reset-password') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                console.log(data);
                if(data.status == 'Ok'){
                    alert(data.mensaje);
                    window.location.href = ""
                }
                if(data.status == 'Error'){
                    alert(data.mensaje);
                    $('.capa').css("visibility", "hidden");
                    $('#reset-password').attr("disabled", false);
                }
            },
            error: function(xhr, data, error){
                alert('Ocurrió un error');
                $('.capa').css("visibility", "hidden");
                $('#reset-password').attr("disabled", false);
            }
        });
    }
</script>

@endsection

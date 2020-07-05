@extends('rutac.app')

@section('title','RutaC | Agregar empresa')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <h1>Agregar empresa</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <rc-form
                        action="{{ action('EmpresaController@guardarEmpresa') }}"
                        method="post"
                >
                    @include('rutac.empresas.forms.__agregar_empresa')
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">
                            {{ __('Registrar empresa') }}
                        </button>
                    </div>
                </rc-form>
        </div>
    </div>

@endsection
@section('style')
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<style>
    .box-body{
        padding: 30px;
    }
</style>
@endsection
@section('footer')
<!-- bootstrap datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        $('.select2').select2({
            placeholder: 'Seleccione una opción'
        })
    });
    
    $("#btn-submit-empresa").click(function(){    
        $('.capa').css("visibility", "visible");
        $('#btn-submit-empresa').attr("disabled", true);
        var values = getValues();
        sendRequest(values);
    });
    function getValues(){
        var values = new Object;        
        var inputs = $("#formGuardarEmpresa").find('input, select');  
        for(var i = 0; i< inputs.length; i++){
            name = $(inputs[i]).attr('name');
            value = $(inputs[i]).val();
            values[name] = value;
            $("input[name='"+name+"'], select[name='"+name+"'], textarea[name='"+name+"']").parents().eq(0).removeClass('has-error');            
            $("#error_"+name).html('');
        }

        return values;
    }
    function sendRequest(values){
        $('#message-error').html('');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{url('validar_datos_empresa') }}",
            dataType: 'json',
            type: 'post',
            data: values,
            success: function(data){
                if(data.status == 'Errors'){
                    for(var key in data.errors){
                        $("#error_"+key).html("");
                        $("#alert_error_"+key).removeClass('general-error-color');
                        if(data.errors[key] != ""){                            
                            $("input[name='"+key+"'], select[name='"+key+"'], textarea[name='"+key+"']").parents().eq(0).addClass('has-error');
                            $("#error_"+key).html(data.errors[key]);
                            $("#alert_error_"+key).addClass('general-error-color');
                            html = "<div class='alert alert-danger'>Tiene algunos errores, verifique la información.</div>";
                            $('html, body').animate({scrollTop: '0px'}, 0);
                            $('#message-error').html(html);
                        }
                    }
                    $('.capa').css("visibility", "hidden");
                    $('#btn-submit-empresa').attr("disabled", false);
                }
                if(data.status == 'Ok'){
                    if(data.existe){
                        $('#formGuardarEmpresa').attr('action', '{{action("EmpresaController@restablecerEmpresa")}}');
                    }else{
                        $('#formGuardarEmpresa').attr('action', '{{action("EmpresaController@guardarEmpresa")}}');
                    }
                    $("#formGuardarEmpresa").submit();
                }
            },
            error: function(xhr, data, error){
                //console.log(xhr.responseText);
                console.log('Ocurrió un error');
            }
        });
    }

    $('#departamento_empresa').change(function() {
        $('#municipio_empresa')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Seleccione una opción</option>')
            .val('Seleccione una opción');
        buscarMunicipiosE($('#departamento_empresa').val());
    });
    function buscarMunicipiosE(departamento){
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
    })
</script>

@endsection
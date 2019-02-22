@extends('rutac.app')

@if($empresa)
    @section('title','RutaC | '.  $empresa->empresaRAZON_SOCIAL)
@else
    @section('title','RutaC')
@endif

@section('content')
<section class="content">
    
    @if($empresa)
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h3 class="text-center">Antes de iniciar el diagnóstico por favor actualiza los datos de su empresa.</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    @include('rutac.empresas.forms.editar')
                </div>
            </div>
        </div>
    </div>
    @endif
    
</section>
@endsection
@section('style')
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
    })

    
</script>





@endsection
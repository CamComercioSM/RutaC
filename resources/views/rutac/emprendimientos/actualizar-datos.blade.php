@extends('rutac.app')

@if($emprendimiento)
    @section('title','RutaC | '.  $emprendimiento->emprendimientoNOMBRE)
@else
    @section('title','RutaC')
@endif

@section('content')
<section class="content">
    
    @if($emprendimiento)
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h3 class="text-center">Antes de iniciar el diagnóstico por favor actualiza los datos de su emprendimiento.</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    @include('rutac.emprendimientos.forms.editar')
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

<div class="control-sidebar-bg"></div>
@if($emprendimiento)
<div class="modal fade" id="modal-emprendimiento-delete">
    <div class="modal-dialog">
        <form action="{{$emprendimiento->emprendimientoID}}/eliminar" role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Eliminar Emprendimiento</h4>
                </div>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <input name="emprendimientoID" id="emprendimientoID" type="hidden" value="">
                    <p>¿Seguro que desea eliminar este emprendimiento?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar Emprendimiento</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
<script type="text/javascript">
    $('#fechaInicio').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    })
</script>





@endsection
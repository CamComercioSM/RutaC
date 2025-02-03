@extends('website.layouts.main')
@section('header-class','without-header')
@section('title','Ruta C')
@section('description','')
@section('content')
<form id="preguntas_diagnostico_programa" method="post" action="{{route('company.application.save')}}">
    <input type="hidden" name="program" value="{{$program->id}}" />
    @csrf
    <div id="diagnostic">
        <div class="wrap">
            @if(count($variables) > 0)
            <section id="step-1">
                <h1 class="size-l color-2 font-w-700">Proceso de solicitud {{$program->name}}</h1>
                <p class="mt-5">A continuación debera completar algunas preguntas de profundización para poder aplicar al programa</p>
                <button type="button" id="start-proccess" class="button button-primary button-small mt-20 margin-center">Iniciar preguntas</button>
                <a class="button button-third button-small mt-10 margin-center" href="{{route('company.program.show', [$program->id])}}">Cancelar proceso</a>
            </section>
            @foreach($variables as $variable)
            <section id="variable-{{$variable->id}}" class="variable hidden">
                <h2 class="color-2 font-w-700">{{$variable->name}}</h2>
                @if($variable->type == 0)
                <ul>
                    @if(isset($variable->values))
                    @foreach($variable->values as $key => $value)
                    <li>
                        <label class="radio">
                            <input type="radio" name="variable-{{$variable->id}}" value="{{$key}}"/>
                            <div class="info font-w-500">
                                {{$value['attributes']['variable_response']}}
                            </div>
                        </label>
                    </li>
                    @endforeach
                    @endif
                </ul>
                @elseif($variable->type == 1)
                <input class="mt-10 textc" type="number" name="variable-{{$variable->id}}" value="" />
                @else

                @endif
                <button type="button" class="button button-primary mt-20 button-next">Continuar</button>
                <button type="button" class="button button-secundary mt-10 button-back">Regresar</button>
            </section>
            @endforeach
            @endif
        </div>
    </div>
</form>            

@if(count($variables) > 0)
<script>
    $(document).ready(function () {
            $('#start-proccess').click(function () {
                    $("#step-1").slideUp();
                    $("#variable-{{$variables->first()->id}}").slideDown();
            });

            $('.button-next').click(function () {
                    $variable = $(this).parent().attr('id');
                    $("#" + $variable).slideUp();

                    $next_variable = $(this).parent().next().attr('id');
                    console.log($next_variable);

                    if ($next_variable != undefined) {
                            $("#" + $next_variable).slideDown();
                    } else {
                            $('form').submit();
                    }
            });

            $('.button-back').click(function () {
                    $variable = $(this).parent().attr('id');
                    $("#" + $variable).slideUp();

                    $before_variable = $(this).parent().prev().attr('id');
                    console.log($before_variable);

                    $("#" + $before_variable).slideDown();
            });
    });
</script>
@else
<script>
    $(document).ready(function () {        
//        if (confirm("¿Seguro que desea registrar estas respuestas de diagnostico?") == true) {
//            console.log($('#preguntas_diagnostico_programa').serializeArray());
            $('#preguntas_diagnostico_programa').submit();
//        }       
            
    });
</script>
@endif
@endsection

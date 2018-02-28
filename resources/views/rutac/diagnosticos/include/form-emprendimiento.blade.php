<form id="formSeccionPreguntas" action="{{route('emprendimiento.diagnostico.guardar', $emprendimiento,$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaID)}}" method="post">
{!! csrf_field() !!}
    <input name="diagnosticoId" id="diagnosticoId" type="hidden" value="{{$diagnostico->diagnosticoID}}">
    <div class="box-header with-border">
        <h3 class="box-title">{{$diagnosticos_seccion->seccionesPreguntasFirst->seccion_preguntaNOMBRE}}</h3>
        <div class="options">
            <a href="{{ action('DiagnosticoController@showEmprendimientoDiagnostico',$emprendimiento) }}" class="btn btn-default btn-sm"> Cancelar </a>
            <button type="button" id="btn-submit-continuar_t" class="btn btn-primary btn-sm">Guardar</button>
        </div>
    </div>
    <div class="box-body" style="padding: 0px 30px;">
        @foreach($diagnosticos_seccion->seccionesPreguntasFirst->preguntas as $key=> $pregunta)
        <h4>{{$pregunta->preguntaENUNCIADO}}</h4>
        
            @foreach($pregunta->respuestas as $key=> $respuesta)
            <div class="icheck-inline">
                <div class="md-radio">
                    <input type="radio" name="pregunta_{{$respuesta->PREGUNTAS_preguntaID}}" id="r_{{$respuesta->respuestaID}}" class="minimal" value="{{$respuesta->respuestaID}}">                  
                    <label for="r_{{$respuesta->respuestaID}}">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span>{{$respuesta->repuestaPRESENTACION}}
                    </label>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>

    <div class="box-footer" style="padding: 10px 30px;">
        <div class="options">
            <a href="{{ action('DiagnosticoController@showEmprendimientoDiagnostico',$emprendimiento) }}" class="btn btn-default btn-sm"> Cancelar </a>
            <button type="button" id="btn-submit-continuar_f" class="btn btn-primary btn-sm">Guardar</button>
        </div>
    </div>
</form>



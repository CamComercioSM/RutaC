@foreach($resultados_preguntas as $key=> $pregunta)
<h4>{{$pregunta->resultado_preguntaENUNCIADO_PREGUNTA}}@if($pregunta->resultado_preguntaESTADO == 'Respondida'): <b>{{$pregunta->resultado_preguntaPRESENTACION}}</b> @endif</h4>
    @if($pregunta->resultado_preguntaESTADO == 'No Respondida')
        @foreach($pregunta->respuestas as $key=> $respuesta)
        <div class="icheck-inline">
            <div class="md-radio">
                <input type="radio" name="pregunta_{{$respuesta->PREGUNTAS_preguntaID}}" id="r_{{$respuesta->respuestaID}}" class="minimal" value="{{$respuesta->respuestaID}}">                  
                <label for="r_{{$respuesta->respuestaID}}">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>{{$respuesta->respuestaPRESENTACION}}
                </label>
            </div>
        </div>
        @endforeach
    @endif
@endforeach
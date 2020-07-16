<div class="row">
    <div class="col-md-12">
        <a href="#" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> {{ __('Agregar') }}
        </a>
        <table class="table table-bordered table-hover tabla-sistema">
            <thead>
            <tr>
                <th class="text-center">Competencia</th>
                <th class="text-center">Orden</th>
                <th class="text-center">Enunciado</th>
                <th class="text-center" style="width: 160px"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($seccione->preguntasSeccion as $key=> $pregunta)
                <tr>
                    <td class="text-left">{{$pregunta->competencia}}</td>
                    <td class="text-left">{{$pregunta->preguntaORDEN}}</td>
                    <td class="text-left">{{$pregunta->preguntaENUNCIADO}}</td>
                    <td class="text-center">
                        <a class="p-1" href="#"
                           aria-label="Editar sección" data-balloon-pos="up">
                            <i class="fas fa-edit text-warning"></i>
                        </a>
                        @if($pregunta->preguntaORDEN > 1)
                            <a id="pregunta_{{$pregunta->preguntaID}}" onclick="cambiarOrden(this)" href="javascript:void(0)" data-pregunta="subir-{{$pregunta->preguntaID}}"> <i class="fa fa-arrow-up" data-toggle="tooltip" title="Subir"></i></a>
                        @endif
                        @if($pregunta->preguntaORDEN != $seccione->preguntasSeccion->count())
                            <a id="pregunta_{{$pregunta->preguntaID}}" onclick="cambiarOrden(this)" href="javascript:void(0)" data-pregunta="bajar-{{$pregunta->preguntaID}}" data-toggle="tooltip" title="Bajar"> <i class="fa fa-arrow-down"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
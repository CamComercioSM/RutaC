@if(count($documentos) > 0)
    <table id="tabla-documentos" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="text-center">Documento #</th>
            <th class="text-center">Título documento</th>
            <th class="text-center">URL documento</th>
        </tr>
        </thead>
        <tbody>
        @foreach($documentos as $key=> $documento)
            <tr>
                <td class="text-center">{{$key+1}}</td>
                <td class="text-left">{{$documento->material_ayudaNOMBRE}}</td>
                <td class="text-left">
                    <a href='documento/{{$documento->material_ayudaCODIGO}}'>{{$documento->material_ayudaCODIGO}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <h3 class="text-center">No existen documentos</h3>
@endif
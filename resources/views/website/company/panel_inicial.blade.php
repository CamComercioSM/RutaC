<h2>Bienvenido</h2>
<h3 class="font-w-700 mt-20">{{$company->business_name}}</h3>
<h1 class="mt-10">¿Qué harás hoy para que tu negocio siga creciendo?</h1>
<br />
<h4 class="mt-40">Estás en la etapa:</h4>
<br />
<br />
<br />
<div class="progress mt-20" data-step="7"
     data-intro="En esta opción puedes visualizar la etapa en la cual se encuentra tu empresa en el proceso de Ruta C">
    <ul>
        @foreach($stages as $stage)
        <li class=" etapaAnimacionEntrada {{$stage->id == \App\helpers::getMyCompany()->stage_id ? 'active' : null}}{{ $stage->id < $company->stage_id ? 'completed' : null }}" style="animation-delay: {{$stage->id - 1 }}s;  z-index: {{99 - $stage->id}}  " >
            <button data-fancybox="dialog" data-src="#stage-{{$stage->id}}"
                    @if($stage->id == 1) data-step="8"
                data-intro="Puedes hacer clic sobre las etapas para obtener mayor información" @endif>
                <img src="{{asset('img/content/'.$stage->image)}}" alt="Ruta C">
                <h4 class="mayus">{{$stage->name}}</h4>
            </button>
        </li>
        @endforeach
    </ul>
</div>

<div class="score">
    Clasificación basada en el último diagnóstico <b>[{{$company->diagnostics->last()->created_at}}]</b> con un <b>puntaje
        de {{number_format($company->diagnostics->last()->score, 2, ',', ',')}}</b>.
</div>

@if($activarDIAGVOLUNTARIO)
<div>¿Quieres realizar el diagnostico de madurez nuevamente? <a href="{{route('company.diagnostic', [$company->id])}}">click aquí</a></div>
@endif

<hr style="margin: 25px 0px;"/>


<div class="container text-center">
    <!-- Stack the columns on mobile by making one full-width and the other half-width -->
    <div class="row">
        <div class="col-md-8">
            <h1 class="mt-10">Niveles Alcanzados por Dimensión</h1>
            <div style="max-width: 500px; height: 50vh; margin: auto;">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <h4 class="" >Historial de Diagnosticos</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Puntaje</th>
                        <th scope="col">Etapa</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($company->diagnostics as $Diag)
                    <tr>
                        <th scope="row">{{$Diag->created_at}}</th>
                        <td>{{$Diag->score}}</td>
                        <td>{{$Diag->etapaNOMBRE}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            <hr />            
            @include('website.company.barra_historicos_diagnosticos') 
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const data = {
labels: {!! $dimensions !!},
        datasets: [{
        label: '{{$company->business_name}}',
                data: {{$results}},
                fill: true,
                backgroundColor: 'rgba(252,183,22, 0.2)',
                borderColor: 'rgb(255,180,0)',
                pointBackgroundColor: 'rgb(252,183,22)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(12, 24, 146)'
        }, ]
        };
const config = {
type: 'radar',
        data: data,
        options: {
        elements: {
        line: {
        borderWidth: 3
        }
        },
                scales: {
                r: {
                suggestedMin: 0,
                        suggestedMax: 5
                }
                }
        },
        };
const myChart = new Chart(document.getElementById('myChart'), config);
</script>
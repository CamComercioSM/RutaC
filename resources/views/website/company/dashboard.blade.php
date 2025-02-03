@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<style>
</style>

<div class="c-dashboard">
    @include('website.layouts.header_company')
    <main>
        <div id="dashboard">
            <div class="wrap wrap-large">
                @if(isset($debug))
                {{\App\helpers::getDiagnosticScore(true)}}
                @endif
                <div class="info">
                    
                    @include('website.company.panel_inicial') 

                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
@foreach($stages as $stage)
<div id="stage-{{$stage->id}}" class="hidden c-stage-description">
    <h2 class="bold textl">{{$stage->name}}</h2>
    <p class="mt-20">{!! nl2br($stage->description) !!}</p>
</div>
@endforeach
















<!--una encuesta sobre el producto-->
<hr />
<hr />
@if($company->show_poll == 1)
<div id="dashboard-company-comments" class="hidden">
    <h2 class="size-xl color-2 font-w-700">Bienvenido al Panel para empresas de Ruta C</h2>
    <h3 class="size-l color-2 font-w-700 mt-20">¡Agradecemos tu dedicación en completar el proceso de
        registro!</h3>
    <p class="mt-20">
        Si deseas puedes dejar algún comentario adicional que nos ayude a entender más aspectos sobre tu negocio
    </p>
    <form>
        <div class="row">
            <textarea class="mt-20"></textarea>
        </div>
        <ul>
            <li>
                <button data-fancybox-close class="button button-secundary">OMITIR ESTE PASO</button>
            </li>
            <li>
                <input type="submit" name="send" value="ENVIAR COMENTARIOS" class="button button-primary">
            </li>
        </ul>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/intro.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/introjs.min.css"/>
<script>
Fancybox.show(
        [{src: "#dashboard-company-comments", type: "inline"}]
        ).on("destroy", (fancybox, slide) => {
        introJs().setOptions({
                doneLabel: 'Entendido',
                nextLabel: 'Siguiente',
                prevLabel: 'Anterior',
                exitOnOverlayClick: false
        }).start();
});
</script>
<!-- Una vez cargado el formulario inactivamos para que no vuelva aparecer en otras ocaciones -->
@php( \App\helpers::disablePoll() )
@endif


@include('website.layouts.helper')


@endsection

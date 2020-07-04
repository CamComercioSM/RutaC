<div class="container">
    <div class="row justify-content">
        <div class="col-md-12">
            <div>
                <b-jumbotron header="Bienvenido">
                    <h2>Escoge una de las siguientes opciones:</h2>
                    <b-button variant="primary" href="{{ action('User\EmpresaController@create') }}">
                        Tengo una Empresa
                    </b-button>
                    <b-button variant="primary" href="{{ action('User\EmprendimientoController@create') }}">
                        Tengo un Emprendimiento
                    </b-button>
                    <div class="col-md-12 mt-3">
                        <i class="icon fa fa-info-circle text-info"></i>
                        Para el registro en la plataforma se entiende por Empresa aquella que tiene registro mercantil
                        en Cámara de Comercio, Emprendimiento como aquel que aún no cuenta con este registro mercantil.
                    </div>
                </b-jumbotron>
            </div>
        </div>
    </div>
</div>
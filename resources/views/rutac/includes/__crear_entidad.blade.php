<div class="container">
    <div class="row justify-content">
        <div class="col-md-12">
            <div>
                <b-jumbotron header="Bienvenido">
                    <p>Debe crear una de las siguientes opciones:</p>
                    <b-button variant="primary" href="{{ route('user.emprendimientos.create') }}">
                        Crear una Empresa
                    </b-button>
                    <b-button variant="primary" href="{{ action('User\EmprendimientoController@create') }}">
                        Crear un Emprendimiento
                    </b-button>
                </b-jumbotron>
            </div>
        </div>
    </div>
</div>
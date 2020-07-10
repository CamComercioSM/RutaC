@extends('rutac.app')

@section('title','RutaC | Agregar empresa')

@section('app-content')
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-content-center">
                            <h5>{{ __('Agregar empresa') }}</h5>
                        </div>
                        <div class="btn-toolbar" role="toolbar">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('user.ruta.iniciar-ruta') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Volver') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    
                        <rc-form
                                action="{{ route('user.empresas.store') }}"
                                method="post"
                        >  
                            
                            @include('rutac.empresas.__form')
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">
                                    {{ __('Registrar empresa') }}
                                </button>
                            </div>
                        </rc-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    @include('layouts.modals.__informacion_sector')
@endpush




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" >
    
    window.addEventListener("load", function() {
        $("#registrado #registrado").attr("readonly","readonly");
    
        $("#nit #nit").change(  function() {
            var nit=$(this).val();
            document.getElementById('loading').style.visibility = 'visible'; 
            $.post("https://api.sicam32.net/tienda-apps/certificadoFacil/buscarRegistroMercantil",
                {
                    criterio_busqueda:'NIT',
                    palabra_clave: nit,
                    pagina:0
                },
                function(Respuesta, status){
                    
                    if(Respuesta.RESPUESTA=="EXITO"){
                    let encontrado=false;
                    Respuesta.DATOS.expedientes.forEach( (expediente) =>{                         
                        if(expediente.nit==nit && expediente.nit != "" ){
                            //alert("se encontro nit=" + expediente.nit);
                            $("#razon_social #razon_social").val(expediente.nombre);
                            $("#razon_social #razon_social").focus();
                            $("#registrado #registrado").val("SI");
                            $("#registrado #registrado").focus();
                            encontrado=true;
                        }
                    });
                    if(!encontrado){
                        //alert("no encontrado o no es una empresa registrada");
                        
                        $("#registrado #registrado").val("NO");
                        $("#registrado #registrado").focus();
                        $("#razon_social #razon_social").val("");
                        $("#razon_social #razon_social").focus();
                        
                    }
                }
                document.getElementById('loading').style.visibility = 'hidden';   
            });


        });





    });              
</script>


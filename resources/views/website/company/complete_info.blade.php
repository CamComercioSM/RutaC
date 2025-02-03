@extends('website.layouts.main')
@section('header-class','without-header')
@section('title','Ruta C')
@section('description','')

@section('content')
<div id="register">
    <div class="wrap">
        <section class="step-1 mt-40 mb-40">
            <div>                                        
                <h1>Bienvenid@, <b>{{$company->business_name}}</b> [{{$company->nit}}]!.</h1>                    
            </div>
            <h2 class="size-l color-2 font-w-700">Verifica los datos registrados</h2>
            <p class="mt-5">
                Lo invitamos a completar la siguiente información corporativa. Una vez termine de completar los campos, presione el botón de "Continuar"
            </p>
            <form method="post" action="{{route('company.complete_info.save')}}">
                @csrf
                <div class="group mt-20">
                    <h2>Información de la empresa</h2>
                    <div class="row">
                        <label>Celular *</label>
                        <input type="text" name="mobile" value="{{$company->mobile}}" required/>
                    </div>
                    <div class="row">
                        <label>Teléfono (opcional)</label>
                        <input type="text" name="telephone"/>
                    </div>
                    <div class="row">
                        <label>Seleccione un departamento * [{{$company->department_id}}]</label>
                        <select id="department" name="department" required>
                            <option value="">Seleccione un departamento</option>
                            @foreach($departments as $department)     
                            @php($seleccionado = "")
                            @if ( $company->department_id == $department->id )
                            @php($seleccionado = "selected")
                            @endif                            
                            <option value="{{$department->id}}" {{$seleccionado}} >{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <label>Seleccione un municipio *</label>
                        <select id="municipality" name="municipality" required>
                            <option>Seleccione primero un departamento</option>                            
                            @foreach($municipalities as $municipality)     
                            @php($seleccionado = "")
                            @if ( $company->municipality_id == $municipality->id )
                            @php($seleccionado = "selected")
                            @endif                            
                            <option value="{{$municipality->id}}" {{$seleccionado}} >{{$municipality->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <label>Dirección *</label>
                        <input type="text" name="address" value="{{$company->address}}" required  style="text-transform: uppercase;" />
                    </div>
                </div>
                <div class="group mt-20">
                    <h2>Persona de contacto</h2>
                    <div class="row">
                        <label>Nombre *</label>
                        <input type="text" name="contact_person" value="{{$company->name_legal_representative}}" required  style="text-transform: uppercase;" />
                    </div>
                    <div class="row">
                        <label>Cargo *</label>
                        <select id="list_contacto_position" required onchange="actualizarNombreCargoContacto(this);">
                            <option value="">SELECCIONE UNO</option> 
                            @foreach($listaCargos as $cargo)
                            <option 
                                @if($cargo->vinculoCargoTITULO == $company->contact_position )    
                                selected
                                @endif
                                value="{{$cargo->vinculoCargoTITULO}}">{{$cargo->vinculoCargoTITULO}}</option>
                            @endforeach
                        </select>
                        <input type="text" id="contact_position" name="contact_position" value="{{$company->contact_position}}" required  style="text-transform: uppercase;display:none;"/>
                    </div>
                    <div class="row">
                        <label>Email *</label>
                        <input type="text" name="contact_email" value="{{$company->registration_email}}" required/>
                    </div>
                    <div class="row">
                        <label>Celular *</label>
                        <input type="text" name="contact_phone" value="{{$company->mobile}}" required/>
                    </div>
                </div>
                <div class="group mt-20">
                    <h2>Información adicional</h2>
                    <div class="row">
                        <label>URL del Sitio Web (Opcional)</label>
                        <input type="text" name="website"/>
                    </div>
                    <div class="row">
                        <label>Instagram (Opcional)</label>
                        <input type="text" name="social_instagram"/>
                    </div>
                    <div class="row">
                        <label>Facebook (Opcional)</label>
                        <input type="text" name="social_facebook"/>
                    </div>
                    <div class="row">
                        <label>LinkedIn (Opcional)</label>
                        <input type="text" name="social_linkedin"/>
                    </div>
                </div>


                <style>
                    .cuadro_datos_usuarios {

                        padding: 10px;
                        margin-top: 20px;
                        margin-bottom: 20px;

                        border: 1px inset #000000;
                        border-radius: 11px;

                        background: #FFFFFF;
                        background: -moz-radial-gradient(center, #FFFFFF 0%, #D3D7DA 100%, #EEEEEE 100%);
                        background: -webkit-radial-gradient(center, #FFFFFF 0%, #D3D7DA 100%, #EEEEEE 100%);
                        background: radial-gradient(ellipse at center, #FFFFFF 0%, #D3D7DA 100%, #EEEEEE 100%);

                        -webkit-box-shadow: 0px 0px 6px 2px #000000;
                        box-shadow: 0px 0px 6px 2px #000000;
                    }
                </style>
                <div class="cuadro_datos_usuarios " style=" " >
                    <h2 style="text-align:center">Estos son los datos de tu usuario:</h2>
                    <p style="text-align:center">Nombre de usuario:&nbsp; <strong>{{$company->registration_email}}</strong></p>
                    <p style="text-align:center">Contrase&ntilde;a Temporal: <strong>{{$company->identificacion}}</strong></p>
                    <h3 style="text-align:center">Por seguridad Le recomendamos cambiar la contrase&ntilde;a cuando ingrese .</h3>
                </div>

                <hr />

                <input type="submit" class="button button-primary mt-20 margin-center" value="Continuar"/>
            </form>
        </section>
    </div>
</div>
@endsection

@section('js')
<script>

    function actualizarNombreCargoContacto(seleccionable) {
            var cargo = $(seleccionable).find(":selected").val();
            $("#contact_position").val(cargo);
    }

    $('document').ready(function () {
            $('#department').on('change', function () {
                    var countryid = $(this).val();
                    $.ajax({
                            type: 'GET',
                            url: 'https://rutadecrecimiento.com/municipios/listado',
                            data: 'id=' + countryid,
                            dataType: 'json',
                            cache: false,
                            success: function (result) {
                                    var html = '<option value="">Seleccione un municipio</option>';
                                    for (var i = 0; i < result.length; i++) {
                                            html += '<option value="' + result[i].id + '">' + result[i].name + '</option>';
                                    }
                                    $('#municipality').html(html);
                            },
                    });
            })
    })
</script>
@endsection

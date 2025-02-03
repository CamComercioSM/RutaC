@extends('website.layouts.main_dashboard')
@section('title','Ruta C Dashboard')
@section('description','')

@section('content')
<div class="c-dashboard">
    @include('website.layouts.header_company')
    <main>
        <div id="profile-update">
            <form class="textl" method="post" action="{{route('company.profile.save')}}" enctype="multipart/form-data">
                <h1 class="bold">Actualizar perfil</h1>
                <hr />
                @csrf
                
                <div class="group mt-20">
                    <h2>Descripción corta</h2>
                    <div class="row">
                        <label>Describa brevemente su empresa *</label>
                        <textarea name="description" required>{{$company->description}}</textarea>
                    </div>
                    <h2>Logotipo de su empresa</h2>
                    <div class="row">
                        <label>Se recomienda un formato cuadrado</label>
                        <input type="file" name="logo" />
                    </div>
                    <h2>Información de la empresa</h2>
                    <div class="row">
                        <label>Celular *</label>
                        <input type="text" name="mobile" value="{{$company->mobile}}" required/>
                    </div>
                    <div class="row">
                        <label>Teléfono (opcional)</label>
                        <input type="text" name="telephone" value="{{$company->telephone}}"/>
                    </div>
                    <div class="row">
                        <label>Seleccione un departamento *</label>
                        <select id="department" name="department" required>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}" {{$company->department_id == $department->id ? 'selected' : null}}>{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <label>Seleccione un municipio *</label>
                        <select id="municipality" name="municipality" required>
                            @foreach($municipalities as $municipality)
                            <option value="{{$municipality->id}}" {{$company->municipality_id == $municipality->id ? 'selected' : null}}>{{$municipality->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <label>Dirección *</label>
                        <input type="text" name="address" value="{{$company->address}}" required style="text-transform: uppercase;" />
                    </div>
                </div>
                <div class="group mt-20">
                    <h2>Persona de contacto</h2>
                    <div class="row">
                        <label>Nombre *</label>
                        <input type="text" name="contact_person" value="{{$company->contact_person}}" required  style="text-transform: uppercase;"/>
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
                        <input type="text" name="contact_email" value="{{$company->contact_email}}" required/>
                    </div>
                    <div class="row">
                        <label>Celular *</label>
                        <input type="text" name="contact_phone" value="{{$company->contact_phone}}" required/>
                    </div>
                </div>
                <div class="group mt-20">
                    <h2>Información adicional</h2>
                    <div class="row">
                        <label>URL de Sitio Web (Opcional)</label>
                        <input type="text" name="website" value="{{$company->website}}"/>
                    </div>
                    <div class="row">
                        <label>Instagram (Opcional)</label>
                        <input type="text" name="social_instagram" value="{{$company->social_instagram}}"/>
                    </div>
                    <div class="row">
                        <label>Facebook (Opcional)</label>
                        <input type="text" name="social_facebook" value="{{$company->social_facebook}}"/>
                    </div>
                    <div class="row">
                        <label>LinkedIn (Opcional)</label>
                        <input type="text" name="social_linkedin" value="{{$company->social_linkedin}}"/>
                    </div>
                </div>
                <input type="submit" class="button button-primary mt-20 margin-center" value="ACTUALIZAR INFORMACIÓN"/>
            </form>
        </div>
    </main>
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
              url: '{{route('company.getMunicipalities')}}',
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

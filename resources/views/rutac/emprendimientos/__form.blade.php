@csrf
<div class="col-md-12"><br></div>
<div class="row">
    <div class="form-group col-md-12">
        <h4>Complete el siguiente formulario para registrar el emprendimiento.</h4>
    </div>

    <div class="form-group col-md-12">
        <rc-input
                rules="required|min:5|max:200"
                name="nombre_emprendimiento"
                id="nombre_emprendimiento"
                type="text"
                @error('nombre_emprendimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('nombre_emprendimiento') }}"
                autocomplete="off"
                placeholder="Digite el nombre del emprendimiento"
                label="Nombre del emprendimiento"
        ></rc-input>
    </div>

    <div class="form-group col-md-12">
        <rc-input
                rules="required|min:5|max:200"
                name="descripcion_emprendimiento"
                id="descripcion_emprendimiento"
                type="text"
                @error('descripcion_emprendimiento')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('descripcion_emprendimiento') }}"
                autocomplete="off"
                placeholder="Agregue una descipción de lo que hace el emprendimiento"
                label="Descripción del emprendimiento"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="date_format:dd/MM/yyyy"
                name="inicio_actividades"
                id="inicio_actividades"
                type="text"
                @error('inicio_actividades')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('inicio_actividades') }}"
                autocomplete="off"
                placeholder="Digite la fecha de inicio de actividades"
                label="Fecha de inicio de actividades"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="numeric"
                name="ingresos_ventas"
                id="ingresos_ventas"
                type="text"
                @error('ingresos_ventas')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('ingresos_ventas') }}"
                autocomplete="off"
                placeholder="Digite los ingresos por ventas"
                label="Ingresos por ventas de los últimos meses"
        ></rc-input>
    </div>

    <div class="form-group col-md-6">
        <rc-input
                rules="numeric"
                name="remuneracion_emprendedor"
                id="remuneracion_emprendedor"
                type="text"
                @error('remuneracion_emprendedor')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('remuneracion_emprendedor') }}"
                autocomplete="off"
                placeholder="Digite la remuneración que recibe el emprendedor"
                label="Remuneración del emprendedor"
        ></rc-input>
    </div>
</div>
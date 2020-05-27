@csrf
<p class="text-right pb-0 mb-0"><i class="icon fa fa-info-circle text-warning"></i> Los campos con * son obligatorios</p>
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
                initial-value="{{ old('nombre_emprendimiento', $emprendimiento->emprendimientoNOMBRE) }}"
                autocomplete="off"
                placeholder="Digite el nombre del emprendimiento"
                label="Nombre del emprendimiento *"
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
                initial-value="{{ old('descripcion_emprendimiento', $emprendimiento->emprendimientoDESCRIPCION) }}"
                autocomplete="off"
                placeholder="Agregue una descipción de lo que hace el emprendimiento"
                label="Descripción del emprendimiento *"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input
                rules="required"
                name="inicio_actividades"
                id="inicio_actividades"
                type="date"
                @error('inicio_actividades')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('inicio_actividades', $emprendimiento->emprendimientoINICIOACTIVIDADES) }}"
                autocomplete="off"
                placeholder="{{ __('Digite la fecha de inicio de actividades') }}"
                label="{{ __('Fecha de inicio de actividades') }} *"
        ></rc-input>
    </div>

    <div class="form-group col-md-4">
        <rc-input-money
                name="ingresos_ventas"
                id="ingresos_ventas"
                type="text"
                @error('ingresos_ventas')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('ingresos_ventas', number_format($emprendimiento->emprendimientoINGRESOS, 2)) }}"
                autocomplete="off"
                placeholder="Digite los ingresos por ventas"
                label="Ingresos por ventas de los últimos meses"
        ></rc-input-money>
    </div>

    <div class="form-group col-md-4">
        <rc-input-money
                name="remuneracion_emprendedor"
                id="remuneracion_emprendedor"
                type="text"
                @error('remuneracion_emprendedor')
                error="{{ $message }}"
                @enderror
                initial-value="{{ old('remuneracion_emprendedor', number_format($emprendimiento->emprendimientoREMUNERACION, 2)) }}"
                autocomplete="off"
                placeholder="Digite la remuneración que recibe el emprendedor"
                label="Remuneración del emprendedor"
        ></rc-input-money>
    </div>
</div>
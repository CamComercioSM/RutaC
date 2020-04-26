@csrf
<div class="col-md-12"><br></div>
<div class="row justify-content-center">
    <div class="form-group col-md-6 offset-md-1">
        <rc-input
                rules="required|min:6"
                name="anterior_password"
                id="anterior_password"
                type="password"
                @error('anterior_password')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Contraseña anterior"
        ></rc-input>
    </div>

    <div class="form-group col-md-6 offset-md-1">
        <rc-input
                rules="required|min:6"
                name="nuevo_password"
                id="nuevo_password"
                type="password"
                @error('nuevo_password')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Digite nueva contraseña"
        ></rc-input>
    </div>

    <div class="form-group col-md-6 offset-md-1">
        <rc-input
                rules="required|min:6|confirmed:nuevo_password"
                name="repetir_password"
                id="repetir_password"
                type="password"
                @error('repetir_password')
                error="{{ $message }}"
                @enderror
                autocomplete="off"
                placeholder="Confirme nueva contraseña"
        ></rc-input>
    </div>
</div>
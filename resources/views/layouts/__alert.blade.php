@if(session()->has('success'))
    <rc-alert variant="success" dismiss="0">
        <p>{{ session('success') }}</p>
    </rc-alert>
@endif

@if(session()->has('info'))
    <rc-alert variant="info" dismiss="0">
        <p>{{ session('info') }}</p>
    </rc-alert>
@endif

@if ($errors->any())
    <rc-alert variant="danger" dismiss="0">
        <p>{{ __('Ha ocurrido un error.') }}</p>
    </rc-alert>
@endif
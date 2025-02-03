@extends('website.layouts.main')
@section('title','Ruta C - Ingreso de empresarios')
@section('description','')

@section('content')
    <div id="login">
        <form method="post" action="{{route('company.login.process')}}">
            @csrf
            <h2 class="mayus mb-20">Ingrese su email</h2>
            <div class="row">
                <label class="textl">Email</label>
                <input type="text" name="email" required />
            </div>
            <div class="row">
                <input class="button button-primary" type="submit" name="send" value="Recuperar contraseña">
            </div>
        </form>
    </div>
@endsection

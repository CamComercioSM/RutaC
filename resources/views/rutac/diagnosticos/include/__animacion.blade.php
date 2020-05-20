@push('styles')
    <style>
        #contenedor{
            position:relative;
            margin:5vh auto;
            width:1000px;
            height:500px;
        }

        #lienzo{
            background:url("../../../img/mountains.png");
            margin-right: auto;
            margin-left: auto;
            display: block;
        }

        #contenedor button{
            display:block;
            position: relative;
            margin:5px 0;
            padding:10px;
            cursor:pointer;
        }
    </style>
@endpush
<rc-canvas
    resultado="{{ number_format($diagnostico->diagnosticoRESULTADO,0) }}"
></rc-canvas>

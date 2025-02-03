<div class="c-helper" data-step="9" data-intro="Nuestro ayudante te dara recomendaciones y consejos">
    @if(count($helper_notifications) > 0)
    <ul class="from-admin">
        @foreach($helper_notifications as $notification)
        <li>
            @if($notification->url != null)
            <a class="with-link" href="{{$notification->url}}" target="_blank">
                <h6>{{$notification->title}}</h6>
                <p>{{$notification->description}}</p>
            </a>
            @else
            <a>
                <h6>{{$notification->title}}</h6>
                <p>{{$notification->description}}</p>
            </a>
            @endif
        </li>
        @endforeach
    </ul>
    @else
    <ul>
        <li>
            <a>
                <h6>{{$helper_default['title']}}</h6>
                <p>{{$helper_default['message']}}</p>
            </a>
        </li>
    </ul>
    @endif
    <button><span>C</span></button>
</div>

@section('js')
<script>
    $(document).ready(function () {
            $('header .dashboard').addClass('active');

            var notifications = $('.c-helper .from-admin li');
            var length = notifications.length;
            var fechaInicio = new Date(localStorage.getItem('alertas')).getTime();
            var fechaFin = new Date().getTime();
            var diff = fechaFin - fechaInicio;
            console.log(diff);
            if (diff > 86400000 ) {
                    if (length > 0) {
                            $(notifications).each(function (i) {
                                    var $li = $(this);
                                    setTimeout(function () {
                                            if (i > 0) {
                                                    //Ocultamos el LI anterior
                                                    $(".c-helper ul li:nth-child(" + i + ")").find('a').slideToggle('fast');
                                            }

                                            // Si es la ultima notificacion se ejecuta una funcion diferente
                                            i === (length - 1) ? lastNotification($li) : nextNotification($li);

                                    }, 8000 * (i + 1));

                                    localStorage.setItem('alertas', new Date());
                            });

                            function nextNotification($li) {
                                    $li.find('a').slideToggle('fast');
                            }

                            function lastNotification($li) {
                                    $li.find('a').slideToggle('fast').delay(3000).slideToggle('fast');
                            }
                    } else {
                            // Si no tienen nada agregado desde el panel administrativo, al presionar muestra el consejo por defecto
                            //click c-helper button
                            $('.c-helper button').click(function () {
                                    $('.c-helper a').slideToggle();
                            });
                    }
            }
    });
</script>
@endsection

@if(session()->has('error') || session()->has('success'))
    <button class="c-alert">
        @foreach (['error', 'success'] as $key)
            @if(Session::has($key))
                <div class="message message-{{ $key }}">
                    <div class="icon">
                        @if($key == 'success')
                            <i class="far fa-check-circle"></i>
                        @else
                            <i class="fas fa-exclamation-circle"></i>
                        @endif
                    </div>
                    <p>
                        {{ Session::get($key) }}
                    </p>
                    <div class="close">X</div>
                </div>
            @endif
        @endforeach
    </button>
    <script>
        $('.c-alert').click(function (e) {
            e.preventDefault()
            $(this).fadeOut();
        });
    </script>
@endif

@extends('website.layouts.main')
@section('title',$section->seo_title)
@section('description',$section->seo_description)

@section('content')


<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<style>

    .evento-ho {
        width: 100%;
        max-width: 403px;
        max-height: 267px;
        box-shadow: 0px 2px 5px #0000000a, 0px 9px 28px #d9dadf8c;
        display: block;
        border-radius: 12px;
        margin: 20px;
    }

    .evento-ho > img {
        width: 100%;
        height: 43vw;
        max-height: 185px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }

    .data-evento {
        display: flex;
        width: 100%;
        padding: 7px 13px;
        height: 80px;
    }

    .fecha-evento {
        width: 130px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-right: 1px solid;
        padding-right: 7px;
    }

    .fecha-evento > div:first-child {
        font-weight: bold;
        font-size: 27px;
        color: #173E88;
        line-height: 1em;
    }

    .fecha-evento > div:last-child {
        font-size: 16px;
        color: #A9A9A9;
        text-transform: uppercase;
        letter-spacing: 0.59px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
        text-overflow: ellipsis;
    }

    .txt-evento {
        padding: 0 15px;
        display: flex;
    }

    .txt-evento > h2 {
        font-size: 16px;
        color: #173E88;
        font-weight: 600;
        letter-spacing: 0.25px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        text-overflow: ellipsis;
        margin: auto 0;
    }

    .slick-arrow{
        height: 30px;
        width: 30px;
        border-radius: 50%;
        color: white;
        background-color: #173E88;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .slick-arrow:hover{
        transform: scale(1.2);
    }

</style>

<div id="home">
    <section class="banner swiper" tabindex="4">
        <ul class="swiper-wrapper">
            @foreach($banners as $banner)
            <li class="swiper-slide" style="background-image: url('{{ asset('storage/'.$banner->image) }}')">
                <a href="{{ $banner->url }}" target="_blank">
                    <div class="content textl">
                        <h2>{{ $banner->title }}</h2>
                        <p class="mt-10">{{ $banner->description }}</p>
                        <button class="button button-primary button-small mt-20">{{ $banner->text_button }}</button>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        <div class="swiper-pagination"></div>
    </section>
    
    @if($Eventos)
    <section class="slider_eventos  margin-section">
        
        
        <h2 class="c-title-1 wrap-smaller margin-center" tabindex="5" audio-tag="seo-h1">
            Eventos
        </h2>
        @include('website.layouts.button_audio', ['target' => 'Eventos'])

        <div class="wrap" style="">

            <div class="col-lg-12 d-block" id="slide" data-aos="fade-up" data-aos-delay="200">
                @foreach($Eventos->DATOS as $Evento)

                <a class="evento-ho" href="{{$Evento->url_evento_informacion}}">
                    <img src="{{$Evento->img_evento_appmovil}}" alt="{{$Evento->txt_evento_titulo}}">
                    <div class="data-evento">
                        <div class="fecha-evento">
                            <div>{{$Evento->dia_evento_inicio}}</div>
                            <div>{{$Evento->mes_nombre_evento_inicio}}
                            </div>
                        </div>
                        <div class="txt-evento">
                            <h2>{{$Evento->txt_evento_titulo}}</h2>
                        </div>
                    </div>
                </a>


                @endforeach
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <span class="arrow-left slick-arrow"><i class="fa fa-angle-left"></i></span>
                <span class="arrow-right slick-arrow"><i class="fa fa-angle-right"></i></span>
            </div>

        </div>

    </section>
    @endif

    <section class="video margin-section">
        <h2 class="c-title-1 wrap-smaller margin-center" tabindex="5" audio-tag="seo-h1">
            {{$section->h1}}
        </h2>
        @include('website.layouts.button_audio', ['target' => 'seo-h1'])
        <div class="wrap">
            <div class="play margin-center box pad-20 mt-40" tabindex="6">
                <div class="videoWrapper">
                    <iframe src="https://www.youtube.com/embed/{{ \App\helpers::getYouTubeVideoID($section->video_url) }}" title="Ruta C - Etapas" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            <p class="mt-30 font-s-large" tabindex="7" audio-tag="seo-description">
                {{$section->seo_description}}
            </p>
            @include('website.layouts.button_audio', ['target' => 'seo-description'])
            <a href="{{ route('register') }}" class="mt-30 block">
                <button class="button button-primary margin-center" tabindex="8">Regístrate</button>
            </a>
        </div>
    </section>
    <section class="company margin-section">
        <div class="wrap wrap-small">
            <div audio-tag="histories">
                <h2 class="c-title-1 bold" tabindex="9">{{ $data->histories_title }}</h2>
                <p class="mt-20 margin-center font-s-large" tabindex="10">
                    {{ $data->histories_description }}
                </p>
            </div>
            @include('website.layouts.button_audio', ['target' => 'histories'])
            <ul class="mt-40">
                @foreach($histories as $history)
                <li style="background-image: url('{{ asset('storage/'.$history->image) }}')" tabindex="11">
                    <a data-fancybox data-type="video" href="{{ $history->video_url }}">
                        <div class="image"></div>
                        <div class="name">
                            <p class="font-s-medium" >{{ $history->name }}</p>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    <section class="briefcase margin-section">
        <div class="wrap wrap-medium" style="background-image: url('{{ asset('storage/'.$data->discover_bg_image) }}')">
            <p tabindex="12">{{ $data->discover_title }}</p>
            <ul>
                <li>
                    <a href="{{ $data->discover_button_1_url }}">
                        <button class="button button-primary" tabindex="13"> {{ $data->discover_button_1_label }}</button>
                    </a>
                </li>
                <li>
                    <a href="{{ $data->discover_button_2_url }}">
                        <button class="button button-secundary" tabindex="14">{{ $data->discover_button_2_label }}</button>
                    </a>
                </li>
            </ul>
        </div>
    </section>
</div>

@include('website.mantenimiento.modal_aviso') 

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
var swiper = new Swiper(".swiper", {
        loop: true,
        speed: 1000,
        loop: true,
        autoplay: {
                delay: 6000,
                disableOnInteraction: false,
        },
        pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                clickable: true,
        },
});
</script>


<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>

$(document).ready(function () {

        $('#slide').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                prevArrow: $(".arrow-left"),
                nextArrow: $(".arrow-right"),
                
                responsive: [
                        {
                                breakpoint: 1024,
                                settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        infinite: true
                                }
                        },
                        {
                                breakpoint: 600,
                                settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                        infinite: true
                                }
                        },
                        {
                                breakpoint: 480,
                                settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        infinite: true
                                }
                        }
                        // You can unslick at a given breakpoint now by adding:
                        // settings: "unslick"
                        // instead of a settings object
                ]

        });
        
});

</script>

@endsection

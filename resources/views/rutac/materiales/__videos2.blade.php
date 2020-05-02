<b-container>
    <b-row class="text-center">
        <b-col cols="7">
            <b-embed
                    id="embedVideo"
                    type="iframe"
                    aspect="16by9"
                    src="https://www.youtube.com/embed/{{$videos[0]->material_ayudaCODIGO}}"
                    allowfullscreen
            ></b-embed>
            <br>
            <b-button href="https://www.youtube.com/channel/UC73b1GH6pOaAOQ5UnpjsHtQ" target="_blank" type="button" size="sm" variant="outline-success">
                <i class="fas fa-play-circle"></i> Ver más vídeos
            </b-button>
        </b-col>
        <b-col class="bg-white" cols="5">
            @foreach($videos as $key=> $video)
                <b-row>
                    <rc-video
                        codigo="{{$video->material_ayudaCODIGO}}"
                        nombre-video="{{$video->material_ayudaNOMBRE}}"
                    >
                    </rc-video>
                </b-row>
            @endforeach
        </b-col>
    </b-row>
</b-container>
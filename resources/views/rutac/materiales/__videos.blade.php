<div class="videos endless-pagination" data-next-page="{{$videos->nextPageUrl()}}">
    <div class="container">
        <div class="row justify-content">
            <div class="col-md-12">
                @php $n = 1 @endphp
                <b-container class="mb-3">
                    <b-row cols="3">
                        @foreach($videos as $key=> $video)
                            <div>
                                <b-card
                                    title="{{$video->material_ayudaNOMBRE}}"
                                    style="max-width: 20rem;"
                                    class="mb-2"
                                >
                                    <iframe class="box-center" width="100%" src="https://www.youtube.com/embed/{{$video->material_ayudaCODIGO}}" frameborder="0" allowfullscreen></iframe>
                                </b-card>
                            </div>
                            @if($n % 3 == 0)
                                <div class="col-md-12"><br></div>
                            @endif
                            @php $n++ @endphp
                        @endforeach
                    </b-row>
                </b-container>
            </div>
        </div>
    </div>
</div>
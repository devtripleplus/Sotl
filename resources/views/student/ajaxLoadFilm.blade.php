
@foreach($films as $film)

<div class="col-md-4 col-sm-6">
    <div class="vCard vCard2">
        <a href="/videos/{{$film['vimeo_video_id']}}">
            <img class="vCardImg" src="/uploads/{{$film['video_thumbnail']}}" alt="">
            <div class="vCardGradient"></div>
            <div class="timer">
                <!-- <p>{{$film['duration']}}</p> -->
            </div>
            <div class="vCardInfo">
                <h2 class="txtWWW txt300">{{str_limit($film['title'], 15, '...')}}</h2>
                <p class="txt30 txt300">{{str_limit($film['biography'], 175, '...')}}</p>
            </div>
        </a>
    </div>
</div>
@endforeach  
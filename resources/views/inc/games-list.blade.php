<div class="bg-dark">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="btn-group btn-block d-flex btn-tabs">
                    <button id="tab-all-games" class="btn btn-primary active">All</button>
                    @foreach ($gameType as $type)
                        <button id="tab-{{ $type }}" class="btn btn-primary flex-fill">{{ $type }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container py-3">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-0 games-list-background"></div>
        <div id="paginate" data-currentPage='1' data-lastPage="" data-type=""></div>
    </div>
    <div id="scroll-to"></div>
</div>
@push('styles')
<link rel="stylesheet" href="{{ asset('css/games-list.css') }}">
@endpush
@push('scripts')
<script>
scrollDown();
getGames(1,perPage,'');
var perPage = 50;
$("#tab-all-games").click(function(){
    $(".btn-tabs .btn").removeClass('active');
    $(".btn-tabs .btn").prop('disabled',true);
    $(this).addClass('active');
    var wrapper = $(".games-list-background");
    $("#paginate").attr('data-type','');
    wrapper.empty();
    wrapper.append('<div class="spinner" style="--color:#ffc108;--width:70px;height:70px;--margin:20px "></div>');
    setTimeout(() => {
        $(".btn-tabs .btn").prop('disabled',false);
        wrapper.find('.spinner').remove();
        getGames(1,perPage,'')
    }, 1000);
})
$.map(@json($gameType),function(type){
    $(`#tab-${type}`).click(function(){
        $(".btn-tabs .btn").removeClass('active');
        $(".btn-tabs .btn").prop('disabled',true);
        $(this).addClass('active');
        $("#paginate").attr('data-type',type);
        var wrapper = $(".games-list-background");
        var nextPage = $("#paginate").attr('data-nextpage');
        var lastpage = $("#paginate").attr('data-lastpage');
        var currentPage = $("#paginate").attr('data-currentPage');
        wrapper.empty();
        wrapper.append('<div class="spinner" style="--color:#ffc108;--width:70px;height:70px;--margin:20px "></div>');        
        setTimeout(() => {
            $(".btn-tabs .btn").prop('disabled',false);
            wrapper.find('.spinner').remove();
            getGames(1,perPage,type)
        }, 1000);
    });
})
function scrollDown(){
    $(window).scroll(function() {
    var hT = $('#scroll-to').offset().top,
        hH = $('#scroll-to').outerHeight(),
        wH = $(window).height(),
        wS = $(this).scrollTop();
    if (wS > (hT+hH-wH)){
        if(jQuery.active === 0){
            var nextPage = $("#paginate").attr('data-nextpage');
            var lastpage = $("#paginate").attr('data-lastpage');
            var currentPage = $("#paginate").attr('data-currentPage');
            var type = $("#paginate").attr('data-type');
            getGames(nextPage,perPage,type);
        }   
    }
    });
}
function getGames(currentPage,PerPage,type){
    var wrapper = $(".games-list-background");
    var url = `/get-games?page=${currentPage}&perPage=${PerPage}&type=${type}`;
    request = $.get({
        url: url,
        success:function(data){
            wrapper.find('.spinner').remove();
            var currentPage = data.data.games.current_page;
            var lastPage = data.data.games.last_page;
            $("#paginate").attr("data-currentPage",data.data.games.current_page);
            $("#paginate").attr("data-nextPage",data.data.games.current_page+1);
            $("#paginate").attr("data-lastPage",data.data.games.last_page);
            $.map(data.data.games.data, function(v,i){
                if(v.jackpots !== null){
                    var col = `<div class="col col-sm-2">
                        <div id="GameCode-${v.GameCode}" class="game-thumb">
                            <div class="img-wrapper ">
                                <img class="w-100" src="${v.Image1}" alt="GameName">
                                <div class="link-wrapper">
                                    <a class="btn btn-primary btn-sm" href="http://www.gwc688.net?token=xkb1reka7hym1&game=${v.GameCode}&redirectUrl=http://abc.com&mobile={boolean}&lang=en"><i class="fas fa-play-circle me-2"></i>Play Now</a>
                                </div>
                                <div id="jackport-wrapper">
                                    <div class="jackpot">
                                        <span id="jp-${v.GameCode}" class=""></span>
                                    </div>
                                    <div class="coin"></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="cool-link">${v.GameName}</span>
                            </div>
                        </div>
                    </div>`;
                }else{
                    var col = `<div class="col col-sm-2">
                        <div id="GameCode-${v.GameCode}" class="game-thumb">
                            <div class="img-wrapper ">
                                <img class="w-100" src="${v.Image1}" alt="GameName">
                                <div class="link-wrapper">
                                    <form method="post" action="/play">
                                    @csrf
                                    <input type="hidden" name="GameCode" value="${v.GameCode}" />
                                    <button class="btn btn-primary btn-sm""><i class="fas fa-play-circle me-2"></i>Play Now</button >
                                    </form>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="cool-link">${v.GameName}</span>
                            </div>
                        </div>
                    </div>`;
                }
                wrapper.append(col);
                if(v.jackpots !== null){
                    new CountUp(`jp-${v.GameCode}`, v.jackpots.Amount, 500000, 2, 100000000, '').start();    
                }
            });
        }
    })
 }
</script>
@endpush
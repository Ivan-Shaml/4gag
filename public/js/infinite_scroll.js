$(function (){
    var thatsAllFolks = `
    <div class="mt-5 mb-5 d-flex justify-content-center container">
            <div class="row">
                <div class="col-lg-10 d-flex align-items-stretch">
                    <div class="card">
                        <div class="card-header h2 text-muted text-center">Nothing more to show</div>
                        <img class="card-img-top" src="/pics/end.gif" />
                        <div class="card-footer">
                            You can upload more new memes from <a href="/home">Your profile</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

    var page = 1;
    var end_page = false;

    function loadMoreData(page){
        $.ajax({
            url:"?page=" + page,
            type:'get',
            beforeSend: function () {
                $(".ajax-load").show();
            }
        })
            .done(function (data, textStatus, xhr){
                $(".ajax-load").hide();
                $("#memes_container").append(data.html);
            })
            .fail(function(jqHXR, ajaxOptions, thrownError){
                if(jqHXR.status === 404){
                    $(".ajax-load").html(thatsAllFolks);
                    end_page = true;
                }
            });
    }
    $(window).scroll(function(){
        if( $(window).scrollTop() + $(window).height() >= $(document).height() && !end_page ){
            page++;
            loadMoreData(page);
        }
    });

});

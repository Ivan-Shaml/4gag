function downvote(id){
    $.get(`/downvote/${id}`, function(data, status){
        if (status==="success"){
            data = JSON.parse(data);
            $(`#up_votes_count${data.meme_id}`).text(data.up_votes);
            $(`#down_votes_count${data.meme_id}`).text(data.down_votes);
        }
    }).fail(function (xhr, textStatus, errorThrown){
    xhr.responseText = JSON.parse(xhr.responseText);
    let errorMessage = xhr.status + ' ' + xhr.responseText.message;
    $('#alert_box').text(errorMessage);
    $('#alert_box').removeClass('alert-success');
    $('#alert_box').addClass('alert-danger');
    $('#alert_box').show(500);
});
}

function upvote(id){
    $.get(`/upvote/${id}`, function(data, status){
        if (status==="success"){
            data = JSON.parse(data);
            $(`#up_votes_count${data.meme_id}`).text(data.up_votes);
            $(`#down_votes_count${data.meme_id}`).text(data.down_votes);
        }
    }).fail(function (xhr, textStatus, errorThrown){
        xhr.responseText = JSON.parse(xhr.responseText);
        let errorMessage = xhr.status + ' ' + xhr.responseText.message;
        $('#alert_box').text(errorMessage);
        $('#alert_box').removeClass('alert-success');
        $('#alert_box').addClass('alert-danger');
        $('#alert_box').show(500);
    });
}

function postComment(){
    memeId = $('img[name="meme"]').attr('id');
    csrfToken = $('input[name="_token"]').val();
    commentText = $("#comment_box").val();
    if (commentText.length === 0) return false;
    $.post("/comments",{meme_id: memeId, _token: csrfToken, comment_text: commentText} , function (response, status){
        if (status==="success"){
            response = JSON.parse(response);
            $("#comment_section").prepend(`
            <div class="col-md-8">
                <div class="media g-mb-30 media-comment">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                        <div class="g-mb-15">
                            <h5 class="h5 g-color-gray-dark-v1 mb-3">Posted by ${response.user_name} </h5>
                            <span class="g-color-gray-dark-v4 g-font-size-12">Posted on ${response.posted_at} </span>
                        </div>

                        <p class="mt-5">${response.comment_text}</p>

                        <ul class="list-inline d-sm-flex my-0">
                            <li class="list-inline-item g-mr-20">
                                <span id="comment_up_votes_count${response.comment_id}" class="text-success font-weight-bolder">0</span>
                                <button class="btn btn-sm btn-success" onclick="commentUpvote(${response.comment_id})">
                                    <i class="fa fa-arrow-up g-pos-rel g-top-1 g-mr-3"></i>
                                </button>
                            </li>
                            <li class="list-inline-item g-mr-20">
                                <button class="btn btn-sm btn-danger" onclick="commentDownvote(${response.comment_id})">
                                    <i class="fa fa-arrow-down g-pos-rel g-top-1 g-mr-3"></i>
                                </button>
                                <span id="comment_down_votes_count${response.comment_id}" class="text-danger font-weight-bolder">0</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            `);
            $("#comment_box").val('');

            let commentsTotalCount = $('#comments_total_count').text();
            commentsTotalCount = commentsTotalCount.substr(0, commentsTotalCount.indexOf(' '));
            commentsTotalCount++;
            $('#comments_total_count').text(`${commentsTotalCount} Comments`);

            let alertBox = $('#alert_box');
            alertBox.show().delay(1500).fadeOut(1000, function (){
                $('#alert_box').attr("style", "display: none !important")
            });
        }
    }).fail(function (xhr, textStatus, errorThrown){
        xhr.responseText = JSON.parse(xhr.responseText);
        let errorMessage = xhr.status + ' ' + xhr.responseText.message;
        let alertBox = $('#alert_box');
        alertBox.text(errorMessage);
        alertBox.removeClass('alert-success');
        alertBox.addClass('alert-danger');
        alertBox.show(500);
    });
}

function commentDownvote(id){
    $.get(`/comments/downvote/${id}`, function(data, status){
        if (status==="success"){
            data = JSON.parse(data);
            $(`#comment_up_votes_count${data.comment_id}`).text(data.up_votes);
            $(`#comment_down_votes_count${data.comment_id}`).text(data.down_votes);
        }
    }).fail(function (xhr, textStatus, errorThrown){
        xhr.responseText = JSON.parse(xhr.responseText);
        let errorMessage = xhr.status + ' ' + xhr.responseText.message;
        let alertBox = $('#alert_box');
        alertBox.text(errorMessage);
        alertBox.removeClass('alert-success');
        alertBox.addClass('alert-danger');
        alertBox.show(500);
    });
}

function commentUpvote(id){
    $.get(`/comments/upvote/${id}`, function(data, status){
        if (status==="success"){
            data = JSON.parse(data);
            $(`#comment_up_votes_count${data.comment_id}`).text(data.up_votes);
            $(`#comment_down_votes_count${data.comment_id}`).text(data.down_votes);
        }
    }).fail(function (xhr, textStatus, errorThrown){
        xhr.responseText = JSON.parse(xhr.responseText);
        let errorMessage = xhr.status + ' ' + xhr.responseText.message;
        $('#alert_box').text(errorMessage);
        $('#alert_box').removeClass('alert-success');
        $('#alert_box').addClass('alert-danger');
        $('#alert_box').show(500);
    });
}

function deleteMeme(id){
    let csrfToken = $('input[name="_token"]').val();
    let request = $.ajax({
        url: `/${id}`,
        method: "DELETE",
        data: {_token: csrfToken, _method: 'DELETE'},
        dataType: "html"
    });

    request.done(function(data, textStatus) {
        if (textStatus === "success"){
            data = JSON.parse(data);
            $(`#meme_id_${data.meme_id}`).remove();
            let alertBox = $('#alert_box1');
            alertBox.text(data.message);
            alertBox.show().delay(1500).fadeOut(1000, function (){
                $('#alert_box1').attr("style", "display: none !important")
            });
        }
    });

    request.fail(function (xhr, textStatus, errorThrown){
        let errorMessage = xhr.status + ' ' + xhr.statusText;
        let alertBox = $('#alert_box1');
        alertBox.text(errorMessage);
        alertBox.removeClass('alert-success');
        alertBox.addClass('alert-danger');
        alertBox.show(500);
    });
}

function deleteComment(id){
    let csrfToken = $('input[name="_token"]').val();
    let request = $.ajax({
        url: `/comments/${id}`,
        method: "DELETE",
        data: {_token: csrfToken, _method: 'DELETE'},
        dataType: "html"
    });

    request.done(function(data, textStatus) {
        if (textStatus === "success"){
            data = JSON.parse(data);
            $(`#comment_id_${data.comment_id}`).remove();
            let commentsTotalCount = $('#comments_total_count').text();
            commentsTotalCount = commentsTotalCount.substr(0, commentsTotalCount.indexOf(' '));
            commentsTotalCount--;
            $('#comments_total_count').text(`${commentsTotalCount} Comments`);
            let alertBox = $('#alert_box');
            alertBox.text(data.message);
            alertBox.show().delay(1500).fadeOut(1000, function (){
                $('#alert_box').attr("style", "display: none !important")
            });
        }
    });

    request.fail(function (xhr, textStatus, errorThrown){
        let errorMessage = xhr.status + ' ' + xhr.statusText;
        let alertBox = $('#alert_box');
        alertBox.text(errorMessage);
        alertBox.removeClass('alert-success');
        alertBox.addClass('alert-danger');
        alertBox.show(500);
    });
}

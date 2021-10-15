function downvote(id){
    $.get(`/downvote/${id}`, function(data, status){
        if (status==="success"){
            data = JSON.parse(data)
            $(`#up_votes_count${data.meme_id}`).text(data.up_votes);
            $(`#down_votes_count${data.meme_id}`).text(data.down_votes);
        }
    });
}

function upvote(id){
    $.get(`/upvote/${id}`, function(data, status){
        if (status==="success"){
            data = JSON.parse(data)
            $(`#up_votes_count${data.meme_id}`).text(data.up_votes);
            $(`#down_votes_count${data.meme_id}`).text(data.down_votes);
        }
    });
}

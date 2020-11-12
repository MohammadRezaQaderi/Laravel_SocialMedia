var commentBodyElement = null;
$('.post').find('.interaction').find('.comment').find('.material-icons').on('click', function(event){
    event.preventDefault();
    commentBodyElement =event.target.parentNode.parentNode.parentNode.childNodes[1]; 
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    $('#comment-modal').modal();
});

$('#save-modal-Comment').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlComment,
        data: {comment_body: $('#comment-body').val() , postId: postId ,_token: token}
    })
    .done(function(){
        $('#comment-modal').modal('hide');
    }); 
});


$('.like').on('click' , function(event){
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var isLike = event.target.previousElementSibling == null;
    $.ajax({
        method :'POST',
        url : urlLike,
        data : { isLike: isLike  , postId:postId , _token: token}
    })
        .done(function(){
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'You Like This Post' :'Like' : event.target.innerText == 'DisLike' ? 'You Don\'t Like This Post' :'DisLike';
            if(isLike){
                event.target.nextElementSibling.innerText = 'DisLike';
            }else{
                event.target.previousElementSibling.innerText = 'Like';
            }
        });
});
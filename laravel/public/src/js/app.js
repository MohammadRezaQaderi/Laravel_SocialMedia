var postId = 0;
var postBodyElement = null;
$('.post').find('.interaction').find('.edit').on('click', function(event){
    event.preventDefault();

    postBodyElement =event.target.parentNode.parentNode.childNodes[1]; 
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody); 
    $('#edit-modal').modal();
});

$('#save-modal').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {body: $('#post-body').val() , postId: postId , _token: token}
    })
    .done(function(msg){
        $(postBodyElement).text(msg['new_body']);
        $('#edit-modal').modal('hide');
    }); 
});

$('.post').find('.interaction').find('.comment').on('click', function(event){
    event.preventDefault();
    commentBodyElement =event.target.parentNode.parentNode.childNodes[1]; 
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#comment-modal').modal();
});

$('#save-modal-Comment').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlComment,
        data: {comment_body: $('#comment-body').val() , postId: postId , _token: token}
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
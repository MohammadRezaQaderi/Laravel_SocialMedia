$('.post').find('.interaction').find('.comment').find('.material-icons').on('click', function(event){
    event.preventDefault();
    console.log("you click it")
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    console.log(postId)
    $('#comment-modal').modal();
});

$('#save-modal-Comment').on('click', function(){
    $.ajax({
        method: 'POST',
        url: urlComment,
        data: {comment_body: $('#comment-body').val() , postId: postId ,_token: token}
    })
    .done(function(){
        console.log('finish');
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


// $('.users').find('.user').on('click' , function(event){

//     id = target.dataset['id'];

// });

var receiver_id = '';
var my_id = "{{Auth::id()}}";
$(document).ready(function(){
     $.ajaxSetup({
         headers:{
             'X-CSRF-TOKEN': $('meta[name ="csrf-token"]').attr('content')
         }
     });
     // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('b15c9bed755c332d2223', {
    cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        if(my_id == date.from){
            $('#' + data.to).click();
        }else if(my_id == data.to){
            if(receiver_id == data.from){
                $('#' + data.from).click();
            }else{
                var pending = parseInt($('#' + data.from).find('.pending').html());

                if(pending){
                    $('#' + data.from).find('.pending').html(pending+1);
                }
                else{
                    $('#' + data.from).append('<span class="pending">1</span>');
                }
            }
        }
    });
     $('.user').click(function(){
         $('.user').removeClass('active');
         $(this).addClass('active');
         $(this).find('.pending').remove();

         receiver_id = $(this).attr('id');
        alert(receiver_id);
         $.ajax({
             type:"get",
             //TODO
             url:route('message', ['id' , "receiver_id" ]),
             data:[],
             cache:false,
             success: function(data){
                 $('#messages').html(data);
                 scrollToBottomFunc();
             }
         });
     });
     $(document).on('keyup' , '.input-text input' , function(e){
         var message = $(this).val();

         if(e.keyCode == 13 &&  message!='' &&  receiver_id != ''){
             $(this).val('');
             var datastr = "receiver_id = " + receiver_id + "  message = "+ message;
             $.ajax({
                type: 'POST',
                url:"messages",
                data: { message: message  , receiver_id:receiver_id},
                cache:false,
                success: function(data){

                },
                error: function(jqXHR, status , err){
                    
                },
                complete: function(){
                    scrollToBottomFunc();

                }
             });
         }
    });
});
function scrollToBottomFunc(){
    $('.message-wrapper').animate({
        scrollTop: $('.message-wrapper').get(0).scrollHeight
    }, 50);
}

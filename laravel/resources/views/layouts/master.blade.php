<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
    </head>
    <body>
        @include('includes.header')
        <div class="container">
            @yield('content')
        </div>
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="{{URL::to('src/js/app.js')}}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
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
             $.ajax({
                 type:"get",
                 url:"message/" + receiver_id,
                 data:{},
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
                    type: "post",
                    url:"message",
                    data: { message: message  , receiver_id:receiver_id },
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

</script>
</body>
</html>

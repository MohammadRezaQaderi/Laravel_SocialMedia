
// define lettering classes
$(".ac, .ac-d").lettering();
$(".al, .ac-l").lettering("lines");
$(".aw, .aw-l").lettering("words");

// check for lettering.js whitespaces
$("span[class^='char']").each(function(){
	var str = $(this).text();
	
	if(str === null || str.match(/^ *$/) !== null){
    $(this).empty();
	}
});

$("content").show(0).css({
	'display': 'flex',
	'justify-content': 'center',
	'align-items': 'center'
});

// define elements for blob thingy
const CURSOR = $("#cBlob");
const CLICKER = $("#cClick");
const BLOBBER = $(".blobber");

// set blob position
$(document).mousemove(function(e) {
  CURSOR.css({
    top: e.pageY - CURSOR.height() / 2 + "px",
    left: e.pageX - CURSOR.width() / 2 + "px"
  });
});

// functions for cursor
const initCursor = () => CURSOR.css("transform", "scale(1)");
const setCursorHover = () => CURSOR.css("transform", "scale(2)");
const removeCursorHover = () => CURSOR.css("transform", "scale(1)");
const setCursorClick = e => {
  CLICKER.css({
    top: e.pageY - CLICKER.height() / 2 + "px",
    left: e.pageX - CLICKER.width() / 2 + "px"
  });
  CLICKER.addClass("clicked");
};

setTimeout(function(){
	initCursor();
}, 1000)

// non clickable elements
BLOBBER.each(function() {
  $(this).on({
    mouseover: setCursorHover,
    mouseleave: removeCursorHover
  });
  
  if($(this).hasClass("link")){
    $(this)
      .click(setCursorClick)
      .click(function(){
      var href = $(this).data('href');
      
      setTimeout(function(){
        toggleNav();
        
        //window.location.href = href;
        var result = confirm("the " + href + " page will appear here");
        
        if (result) {
          window.location.reload(false);
        }
      }, 800);
    });
  }
});

$(".nav__icon").click(function() {
  toggleNav();
});





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
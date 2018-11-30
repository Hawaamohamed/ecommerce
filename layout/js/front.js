$(document).ready(function(){


//Use Select Box Plugin
$('select').selectBoxIt({
  autoWidth: false
});


  /*Login Page*/
  $('input').each(function(){
   if($(this).attr('required') === 'required'){
     $(this).after("<span class='asterisk'>*</span>");
   }
  });

$(".login-page h1 span").click(function(){
  $(this).addClass('selected').siblings().removeClass('selected');
  $('.login-page form').hide();
  $('.'+ $(this).data('class')).fadeIn(100);

});

/* Confirmation message On Delete button */
$(".confirm").click(function(){
 return confirm("Are You Sure?");
});



/* Catecory Page */
$(".cat h3").click(function(){
  $(this).next('.full-view').fadeToggle(200);
})

$(".option span").click(function(){
  $(this).addClass('active').sibilings('span').removeClass('active');
})

if($(this).data('view') === 'full')
{
  $('.cat .full-view').fadeIn(200);
}
else{
    $('.cat .full-view').fadeOut(200);
}


//newad Page
$('.live-name').keyup(function(){
  $('.live-preview .caption h3').text($(this).val());
});
$('.live-desc').keyup(function(){
  $('.live-preview .caption p').text($(this).val());
});
$('.live-price').keyup(function(){
  $('.live-preview .price-tag').text('$'+ $(this).val());
});




});

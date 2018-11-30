$(document).ready(function(){

//Dashboard
$('.toggle-info').click(function(){

  $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
  if($(this).hasClass('selected')){
    $(this).html("<i class='fa fa-minus fa-lg'></i>");
  }else{
    $(this).html("<i class='fa fa-plus fa-lg'></i>'");
  }
})
//Use Select Box Plugin
$('select').selectBoxIt({
  autoWidth: false
});

  //Form Add

  var passField=$(".password");
$(".show-pass").hover(function(){
  passField.attr("type","text");
},function(){
  passField.attr("type","password");
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








});

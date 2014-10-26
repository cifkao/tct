$(function(){
  $('.submit-translation textarea').focus(function(){
    $(this).autosize();
  }).blur(function(){
    if($(this).val()==""){
      $(this).trigger('autosize.destroy');
    }
  });
});

$(function(){
  $('.submit-translation textarea').focus(function(){
    if(!$(this).data('expanded')){
      $(this).data('expanded', true);
      $(this).siblings('.below-textarea').slideDown();
      $(this).autosize();
    }

    $('.submit-translation textarea').not(this).each(function(i){
      if($(this).val()=="" && $(this).data('expanded')){
        $(this).data('expanded', false);
        $(this).siblings('.below-textarea').slideUp(150);
        $(this).trigger('autosize.destroy');
      }
    });
  });

  $('.submit-translation .submit-button').click(function(){
    return false;
  });
});

$(function(){
  $('.submit-translation textarea').focus(function(){
    if(!$(this).data('expanded')){
      $(this).data('expanded', true);
      $(this).siblings('.below-textarea').slideDown();
      $(this).autosize();
    }

    $('.submit-translation textarea').not(this).each(function(i){
      closeTranslationSubmission($(this));
    });
  });

  $('.submit-translation .submit-button').click(function(){
    $text = $(this).closest('.submit-translation').children('textarea');
    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: {
        'requestId': $text.parent().attr('data-request-id'),
        'text': $text.val()
      }
    });
    $text.val("");
    closeTranslationSubmission($text);
    return false;
  });
});

function closeTranslationSubmission($e){
  if($e.data('expanded')){
    $e.data('expanded', false);
    $e.siblings('.below-textarea').slideUp(150);
    $e.trigger('autosize.destroy');
  }
}

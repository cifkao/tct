$(function(){
  $('.submit-translation textarea').focus(function(){
    if(!$(this).data('expanded')){
      $(this).data('expanded', true);
      $(this).siblings('.below-textarea').slideDown();
      $(this).autosize();
      $('.submit-translation .alerts:visible').slideUp();
    }

    $('.submit-translation textarea').not(this).each(function(i){
      closeTranslationSubmission($(this));
    });
  });

  $('.submit-translation .submit-button').click(function(){
    var $text = $(this).closest('.submit-translation').children('textarea');
    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: {
        'requestId': $text.parent().attr('data-request-id'),
        'text': $text.val()
      }
    }).fail(function(jqXHR, textStatus, errorThrown){
      translationSubmissionFailed($text);
    }).done(function(data, textStatus, jqXHR){
      if(data['status']!=0){
        translationSubmissionFailed($text);
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

function translationSubmissionFailed($e){
  var $alert = $e.parent().find('.alerts');
  $alert.find('.alert-box').text(__translationSubmissionFailed);
  $alert.slideDown();
}

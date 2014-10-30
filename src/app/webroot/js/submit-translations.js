var author = null;

$(function(){
  $('.submit-translation textarea').focus(function(){
    if(!$(this).data('expanded')){
      $(this).data('expanded', true);

      $(this).parent().find('.translating-as').show();
      $(this).parent().find('.enter-email').hide();
      $(this).parent().find('.enter-email input:first').val("");

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
    var $email = $text.parent().find('.enter-email input:first:visible');
    console.log($email);
    if($email.length>0){
      if($.trim($email.val()).length>0){
        author = $.trim($email.val());
        $('.submit-translation .author').text(author);
      }else{
        author = null;
        $('.submit-translation .author').text('Anonymous');
      }
    }

    var data = {
      'requestId': $text.parent().attr('data-request-id'),
      'text': $text.val(),
    };
    if(author) data['author'] = author;

    $.ajax({
      url: ajaxUrl,
      type: 'POST',
      data: data
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

  $('.submit-translation .change-author').click(function(){
    var $parent = $(this).closest('.translating-as');
    $parent.hide();
    $parent.siblings('.enter-email').show();
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

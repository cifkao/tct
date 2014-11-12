$(function(){
  if($.cookie('translator_email')){
    $('.submit-translation .author').text($.cookie('translator_email'));
  }else{
    $('.submit-translation .rm-author').hide();
  }

  $('.submit-translation textarea').focus(function(){
    if(!$(this).data('expanded')){
      $(this).data('expanded', true);

      $(this).parent().find('.translating-as').show();
      $(this).parent().find('.enter-email').hide();
      $(this).parent().find('.enter-email input:first').val($.cookie('translator_email') || "");

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
    var email = $.cookie('translator_email');
    if($email.length>0){
      email = $.trim($email.val());
      if(isEmail(email)){
        $.cookie('translator_email', email, { path: cookiePath });
        $('.submit-translation .author').text(email);
        $('.submit-translation .rm-author').show();
      }else{
        $.removeCookie('translator_email', { path: cookiePath });
        $('.submit-translation .author').text('Anonymous');
      }
    }

    var data = {
      'requestId': $text.parent().attr('data-request-id'),
      'text': $text.val(),
    };
    if(email) data['author'] = email;

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

  $('.submit-translation .rm-author').click(function(){
    $.removeCookie('translator_email', { path: cookiePath });
    $('.submit-translation .author').text('Anonymous');
    $('.submit-translation .rm-author').hide();
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

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

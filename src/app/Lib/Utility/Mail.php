<?php
App::import('Vendor', 'PHPMailer',
  array('file' => 'phpmailer'.DS.'class.phpmailer.php'));

Configure::load("mail", "default");

class Mail {

  public static function send($to, $subject, $message){
    $mail = new PHPMailer();

    $mail->ContentType = 'text/plain'; 
    $mail->IsHTML(false);
    $mail->CharSet = 'UTF-8';
    $mail->IsSMTP();

    $mail->SMTPAuth = true;
    $mail->SMTPSecure = Configure::read('Mail.smtp_auth');

    $mail->Host = Configure::read('Mail.smtp_server');
    $mail->Port = Configure::read('Mail.smtp_port');

    $mail->Username = Configure::read('Mail.username');
    $mail->Password = Configure::read('Mail.password');;

    $mail->SetFrom(Configure::read('Mail.address'),
      Configure::read('Mail.name'));
    $mail->Subject = $subject;

    $mail->Body = $message;
    $mail->AddAddress($to, '');

    if($mail->Send()) return null;
    else return $mail->ErrorInfo;
  }

}

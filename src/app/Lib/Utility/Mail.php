<?php
App::import('Vendor', 'PHPMailer',
  array('file' => 'phpmailer'.DS.'class.phpmailer.php'));

App::import('Vendor', 'EmailReplyParser\EmailReplyParser',
  array('file' => 'EmailReplyParser'.DS.'src'.DS.'EmailReplyParser'.DS.'EmailReplyParser.php'));
App::import('Vendor', 'EmailReplyParser\Email',
  array('file' => 'EmailReplyParser'.DS.'src'.DS.'EmailReplyParser'.DS.'Email.php'));
App::import('Vendor', 'EmailReplyParser\Fragment',
  array('file' => 'EmailReplyParser'.DS.'src'.DS.'EmailReplyParser'.DS.'Fragment.php'));
App::import('Vendor', 'EmailReplyParser\Parser\EmailParser',
  array('file' => 'EmailReplyParser'.DS.'src'.DS.'EmailReplyParser'.DS.'Parser'.DS.'EmailParser.php'));
App::import('Vendor', 'EmailReplyParser\Parser\FragmentDTO',
  array('file' => 'EmailReplyParser'.DS.'src'.DS.'EmailReplyParser'.DS.'Parser'.DS.'FragmentDTO.php'));

Configure::load("mail", "default");

class Mail {

  public function send($to, $subject, $message){
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

    if(!is_array($to))
      $recipients = array($to);
    else
      $recipients = $to;

    if(is_array($to)){
      foreach($to as $a){
        $mail->ClearAllRecipients();
        $mail->AddAddress($a, '');
        $mail->Send();
      }
    }else{
      $mail->AddAddress($to, '');
      if(!$mail->Send())
        return $mail->ErrorInfo;
    }

    return null;
  }


  private $imap;

  private function openImap(){
    if(!$this->imap)
      $this->imap = imap_open(Configure::read('Mail.imap_mailbox'), Configure::read('Mail.username'), Configure::read('Mail.password'));
  }

  public function listUnseen(){
    $this->openImap();
    if(!$this->imap)
      return array();

    $result = imap_search($this->imap, 'UNSEEN');
    return $result ? $result : array(); // ensure array is returned
  }

  public function pullTranslation($id){
    $this->openImap();
    if(!$this->imap)
      return null;

    $overview = imap_fetch_overview($this->imap, $id);
    $struct = imap_fetchstructure($this->imap, $id);

    if($struct->type == 1){ // multipart
      $text = imap_fetchbody($this->imap, $id, "1"); 
      $bodyStruct = imap_bodystruct($this->imap, $id, "1");
      $enc = $bodyStruct->encoding;
    }else{
      $text = imap_body($this->imap, $id);
      $enc = $struct->encoding;
    }
    if(!$text) return null;

    if($enc == 4) // QUOTED_PRINTABLE
      $text = quoted_printable_decode($text);
    else if($enc == 3) // BASE64
      $text = imap_base64($text);

    // find the hash
    preg_match("/ID:([0-9a-f]+)/", $text, $matches);
    $hash = $matches[1];

    // get the actual translation text
    $text = trim(EmailReplyParser\EmailReplyParser::parseReply($text));

    $email = imap_rfc822_parse_adrlist( $overview[0]->from, "gmail.com" );
    $email = $email[0]->mailbox."@".$email[0]->host;

    return array("hash" => $hash, "text" => $text, "email" => $email);
  }

  public function finish(){
    if($imap)
      imap_close($imap);
  }

}

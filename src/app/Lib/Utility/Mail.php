<?php
App::import('Vendor', 'PHPMailer',
  array('file' => 'phpmailer'.DS.'class.phpmailer.php'));

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
    $mail->AddAddress($to, '');

    if($mail->Send()) return null;
    else return $mail->ErrorInfo;
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
    $text = imap_fetchbody($this->imap, $id, 2);
    
    $match = explode("ID:", $text );			
    preg_match("/[0-9a-f]*/", $match[count($match)-1], $hash);
    $hash = $hash[0];

    $lines = array_map( "strip_tags", explode( "<br>", nl2br( quoted_printable_decode( $text ), FALSE ) ) );
    $o = 0;
    while (strlen( $lines[$o] ) == 0){
      ++$o;
    }
    $email = imap_rfc822_parse_adrlist( $overview[0]->from, "gmail.com" );
    $email = $email[0]->mailbox."@".$email[0]->host;

    return array("hash" => $hash, "text" => $lines[$o], "email" => $email);
  }

  public function finish(){
    if($imap)
      imap_close($imap);
  }

}

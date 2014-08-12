<?php

echo $this->Form->create('Translator', array('action' => 'request_settings'));
echo $this->Form->input('email');
echo $this->Form->end('Submit');

?>

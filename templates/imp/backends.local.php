<?php
$servers['imap']['disabled'] = false;
$servers['imap']['hostspec'] = $_ENV['IMP_HOSTSPEC'];
$servers['imap']['maildomain'] = $_ENV['IMP_MAILDOMAIN'];
$servers['imap']['hordeauth'] = true;
$servers['imap']['protocol'] = isset($_ENV['IMP_PROTOCOL'])? $_ENV['IMP_PROTOCOL']:'imap/notls';
$servers['imap']['port'] = isset($_ENV['IMP_PORT'])? $_ENV['IMP_PORT']:143;
$servers['imap']['secure'] = $_ENV['IMP_SECURE'];
?>

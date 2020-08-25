<?php
  require dirname(__FILE__).'/../vendor/autoload.php';

  include_once dirname(__FILE__)."/lib.mail.php";

  session_start();

  $mail = new Mailer(dirname(__FILE__)."/mail.config.php");
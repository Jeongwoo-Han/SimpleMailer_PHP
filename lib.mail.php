<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  class Mailer {
    var $host, $user, $pass, $port, $sender;

    public function __construct($config = false) {
      if(!$config) {
        throw new Exception("NO MAIL CONFIG");
      } else {
        include $config;

        $this->host = $mail_config['HOST'];
        $this->user = $mail_config['USER'];
        $this->pass = $mail_config['PASS'];
        $this->port = $mail_config['PORT'];
        $this->sender = $mail_config['SENDER'];
        $this->admin = $mail_config['ADMIN'];
      }
    }

    public function toAdmin($title = false, $message = false) {
      if(!$title || !$message) {
        throw new Exception("NO TITLE OR MESSAGE");
      } else {
        $this->sendMail($this->admin, $title, $message);
      }
    }

    public function toUser($mail = false, $title = false, $message = false) {
      if(!$title || !$message || !$mail) {
        throw new Exception("NO TITLE OR MESSAGE OR MAIL");
      } else {
        $this->sendMail($mail, $title, $message);
      }
    }

    private function sendMail($to, $title, $message) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = $this->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->user;
        $mail->Password   = $this->pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $this->port;

        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($this->sender, 'WebAdmin');

      try {
        if(is_array($to)) {
          foreach($to as $m) {
            $mail->addAddress($m);
          }
        } else {
          $mail->addAddress($to);
        }
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $message;

        $mail->send();

      } catch (Exception $e) {
        echo ($mail->ErrorInfo);
      }
    }
  }

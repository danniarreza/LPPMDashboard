<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(APPPATH.'libraries/PHPMailer/src/Exception.php');
require_once(APPPATH.'libraries/PHPMailer/src/PHPMailer.php');
require_once(APPPATH.'libraries/PHPMailer/src/SMTP.php');

if (!class_exists('Mailer')) {

    class Mailer
    {
        public $mail;

        public function __construct($exceptions = false)
        {
            // New PHPMailer instance
            $this->mail = new PHPMailer($exceptions);

            // Set up required parameters
            $smtp = array(
                'debug'     => 2,
                'host'      => 'smtp.gmail.com',
                'auth'      => true,
                'username'  => SMTP_USER,
                'password'  => SMTP_PASS,
                'secure'    => 'ssl',
                'port'      => 465
            );

            // SMTP setup, if necessary
            if (!empty($smtp)) {
                $this->mail->SMTPDebug = $smtp['debug'];
                $this->mail->isSMTP();
                $this->mail->Host = $smtp['host'];
                $this->mail->SMTPAuth = $smtp['auth'];
                $this->mail->Username = $smtp['username'];
                $this->mail->Password = $smtp['password'];
                $this->mail->SMTPSecure = $smtp['secure'];
                $this->mail->Port = $smtp['port'];

            }
        }

        public function mail($to = array(), $subject, $html, $from = array(), $plaintext = false, $cc = array(), $bcc = array(), $attachment = array())
        {
            // Required parameters are $to, $from, $subject and $html
            if (empty($to) || empty($from) || empty($subject) || empty($html)) {
                die('Missing a parameter');
            }

            // Sender
            $this->mail->setFrom($from['email'], $from['name']);
            $this->mail->addReplyTo($from['email'], $from['name']);

            // Recipients
            if (!empty($to)) {
                foreach ($to as $recipient) {
                    $this->mail->addAddress($recipient['email'], $recipient['name']);
                }
            }

            // CC
            if (!empty($cc)) {
                foreach ($cc as $recipient) {
                    $this->mail->addCC($recipient);
                }
            }

            // BCC
            if (!empty($bcc)) {
                foreach ($bcc as $recipient) {
                    $this->mail->addBCC($recipient);
                }
            }

            // Attachments
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $this->mail->addAttachment($attachment);
                }
            }

            // HTML email
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $html;

            // Plain text version
            if (false !== $plaintext) {
                $this->mail->AltBody = $plaintext;
            }


            // Send the mail
            try {
                $this->mail->send();
                echo 'Message sent successfully';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error : ', $this->mail->ErrorInfo;
            }

        }
    }
}

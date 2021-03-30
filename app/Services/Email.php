<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
  private $mail;

  public function __construct()
  {
    $this->m = new PHPMailer(true);                          // Passing `true` enables exceptions
    //$this->m->SMTPDebug = 2;                                 // Enable verbose debug output
    $this->m->isSMTP();                                      // Set mailer to use SMTP
    $this->m->Host = 'smtp.yourwebhosting.com';              // Specify main and backup SMTP servers
    $this->m->SMTPAuth = true;                               // Enable SMTP authentication
    $this->m->Username = 'hola@galeriaindigo.com.pe';        // SMTP username
    $this->m->Password = 'indM_2018';                        // SMTP password
    $this->m->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $this->m->Port = 587;                                    // TCP port to connect to
    $this->m->CharSet = 'UTF-8';
    $this->m->setFrom('hola@galeriaindigo.com.pe', 'Galeria Indigo');
    $this->m->isHTML(true);
  }

  public function send($html, $to = "soporte@ilustraconsultores.com", $subject = "Su orden ha sido enviada")
  {
    try {

        $this->m->addAddress($to);
        //$mail->addBCC('bcc@example.com');
        $this->m->isHTML(true);

        $this->m->Subject = $subject;
        $this->m->Body    = $html;

        return $this->m->send();

        /*echo $html;*/

    } catch (Exception $e) {      
        // dd($e);
    }

  }

}

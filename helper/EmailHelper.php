<?php

require_once '../core/opt/PHPMailer-master/class.smtp.php';
require_once '../core/opt/PHPMailer-master/class.pop3.php';
require_once '../core/opt/PHPMailer-master/class.phpmailer.php';

/**
 * Description of EmailHelper.
 *
 * @author edily
 */
class Email
{
    public $subject;
    public $message;
    public $from;
    public $fronName;
    public $confirmReadingTo;
    public $errorInfo;
    protected $mail;

    public function __construct()
    {
        $this->header();
    }

    private function header()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = MAIL_SMTPSECURE;
        $mail->Host = MAIL_HOST;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->Port = MAIL_PORT;
        $mail->SMTPDebug = 0;
        $mail->Timeout = 20;
        $mail->CharSet = 'UTF-8';
        $this->mail = $mail;
    }

    public function addAttachment($arquivos)
    {
        if (is_array($arquivos)) {
            foreach ($arquivos as $key => $arquivo) {
                $this->addAttachment($arquivo);
            }
        } else {
            //echo "<br/>Anexando: " . $arquivos;
            if (!file_exists($arquivos)) {
                die('Arquivo não existe: '.$arquivos);
            }
            $this->mail->addAttachment($arquivos);
        }

        return $this->mail;
    }

    public function addAddress($email)
    {
        $this->mail->addAddress($email);
    }

    public function addReplyTo($email)
    {
        $this->mail->addReplyTo($email);
    }

    public function addCC($email)
    {
        $this->mail->addCC($email);
    }

    public function send()
    {
        $this->mail->From = $this->from;
        $this->mail->FromName = $this->fronName;
        $this->mail->ConfirmReadingTo = $this->confirmReadingTo;
        $this->mail->Subject = $this->subject;
        $this->mail->msgHTML($this->getMessage());
        //Log::gravar("Mensagem: " . $this->getMessage()); 
        $send = $this->mail->send();
        $this->errorInfo = $this->mail->ErrorInfo;

        return $send;
    }

    private function getMessage()
    {
        return $this->message;
    }
}

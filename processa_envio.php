<?php 
    require "./bibliotecas/PHPMailer/Exception.php";
    // require "./bibliotecas/PHPMailer/OAuth.php";
    require "./bibliotecas/PHPMailer/PHPMailer.php";
    // require "./bibliotecas/PHPMailer/POP3.php";
    require "./bibliotecas/PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem {
      private $destinatario = null;
      private $assunto = null;
      private $mensagem = null;

      public function __get($attr) {
        return $this->$attr;
      }

      public function __set($attr, $value) {
        $this->$attr = $value;
      }

      public function mensagemValida() {
        if(empty($this->destinatario) || empty($this->assunto) || empty($this->mensagem)) {
          return false;
        } else {
          return true;
        }
      }
    }

    $mensagem = new Mensagem();

    $mensagem->__set('destinatario', $_POST['destinatario']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    if(!$mensagem->mensagemValida()) {
      echo '<span style="color:red">Mensagem Inválida</span>';      
    }     

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'userwzteste@gmail.com';                     //SMTP username
        $mail->Password   = 'wrohqurjcvkwfnen';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('userwzteste@gmail.com', 'Fulano Teste Remetente');
        $mail->addAddress($mensagem->__get('destinatario'), 'Usuário Destinatário');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem->__get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        $mail->AltBody = 'Para visualizar esse conteúdo será necessário um client com suporte a HTML';

        $mail->send();
        echo 'Email enviado com sucesso!';
    } catch (Exception $e) {
        echo "Não foi possível enviar sua mensagem por email. Mailer Error: {$mail->ErrorInfo}";
    }

?>
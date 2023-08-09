<?php 
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

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

    if($mensagem->mensagemValida()) {
      echo '<span style="color:green">Mensagem Válida</span>';
    } else {
      echo '<span style="color:red">Mensagem Inválida</span>';
    }

?>
<?php

class Painel {
  // Verifica se está logado
  public static function isLogin() {
    return isset($_SESSION['login']) ? true : false;
  }

   // Mensagem indicativa de sucesso ou erro
   public static function alert($type, $message) {
    if ($type === 'sucesso') {
      echo '<p class="sucesso">'.$message.'</p>';
    } else if ($type === 'erro') {
      echo '<p class="erro">'.$message.'</p>';
    }
  }
}

?>
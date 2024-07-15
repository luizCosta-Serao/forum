<h2>Bem-vindo ao nosso fórum</h2>

<form action="" method="post">
  <?php
    // Cadastro de novo forum
    if (isset($_POST['cadastrar_forum'])) {
      $nomeForum = $_POST['titulo_forum'];
      $cadastroForum = MySql::connect()->prepare("INSERT INTO `forums` VALUES (null, ?)");
      $cadastroForum->execute(array($nomeForum));
      header('Location: '.INCLUDE_PATH);
    }
  ?>
  <input type="text" name="titulo_forum">
  <input type="submit" name="cadastrar_forum" value="Cadastrar">
</form>

<ul>
  <?php
    // Listar forums
    $listarForums = MySql::connect()->prepare("SELECT * FROM `forums`");
    $listarForums->execute();
    $listarForums = $listarForums->fetchAll();
    foreach ($listarForums as $key => $value) {
  ?>
    <li>
      <a href="<?php echo INCLUDE_PATH ?>topico?id=<?php echo $value['id'] ?>">
        <?php echo $value['nome']; ?>
      </a>
    </li>
  <?php } ?>
</ul>
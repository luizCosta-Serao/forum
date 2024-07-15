<?php
  // Obtendo id do forum
  $idForum = $_GET['id'];
  // Recuperando o fórum
  $singleForum = MySql::connect()->prepare("SELECT * FROM `forums` WHERE id = ?");
  $singleForum->execute(array($idForum));
  // Se fórum existir
  if ($singleForum->rowCount() === 1) {
    $singleForum = $singleForum->fetch();

    // Listar tópicos do fórum
    $listarTopicos = MySql::connect()->prepare("SELECT * FROM `topicos` WHERE forum_id = ?");
    $listarTopicos->execute(array($idForum));
    $listarTopicos = $listarTopicos->fetchAll();
?>
  <h1><?php echo $singleForum['nome'] ?></h1>
  <!-- BREADCRUMB -->
  <div class="breadcrumb">
    <a href="<?php echo INCLUDE_PATH ?>">Fórum</a>
    <span> > </span>
    <a href="<?php echo INCLUDE_PATH ?>topico?id=<?php echo $idForum ?>"><?php echo $singleForum['nome'] ?></a>
  </div>

  <form action="" method="post">
    <?php
      // Cadastro de novo tópico
      if (isset($_POST['cadastrar_topico'])) {
        $nomeTopico = $_POST['titulo_topico'];
        $cadastroTopico = MySql::connect()->prepare("INSERT INTO `topicos` VALUES (null, ?, ?)");
        $cadastroTopico->execute(array($idForum, $nomeTopico));
        header('Location: '.INCLUDE_PATH.'topico?id='.$idForum);
      }
    ?>
    <input type="text" name="titulo_topico">
    <input type="submit" name="cadastrar_topico" value="Cadastrar">
  </form>

  <ul>
    <?php
      foreach ($listarTopicos as $key => $value) {
    ?>
      <li>
        <a href="<?php echo INCLUDE_PATH ?>topico/post?id=<?php echo $idForum?>&topic=<?php echo $value['id'] ?>">
          <?php echo $value['nome']; ?>
        </a>
      </li>
    <?php } ?>
  </ul>
<?php } else { ?>
  <p>Fórum não existe.</p>
<?php } ?>
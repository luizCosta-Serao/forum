<?php
  // Obtendo id do tópico e do forum
  $idForum = $_GET['id'];
  $idTopico = $_GET['topic'];

  // Recuperando o fórum
  $singleForum = MySql::connect()->prepare("SELECT * FROM `forums` WHERE id = ?");
  $singleForum->execute(array($idForum));
  $singleForum = $singleForum->fetch();

  // Recuperando o tópico
  $singleTopico = MySql::connect()->prepare("SELECT * FROM `topicos` WHERE id = ?");
  $singleTopico->execute(array($idTopico));
  // Se tópico existir
  if ($singleTopico->rowCount() === 1) {
    $singleTopico = $singleTopico->fetch();

    // Listar posts do tópico
    $listarPosts = MySql::connect()->prepare("SELECT * FROM `posts` WHERE topico_id = ?");
    $listarPosts->execute(array($idTopico));
    $listarPosts = $listarPosts->fetchAll();
?>
  <h1><?php echo $singleTopico['nome'] ?></h1>
  <!-- BREADCRUMB -->
  <div class="breadcrumb">
    <a href="<?php echo INCLUDE_PATH ?>">Fórum</a>
    <span> > </span>
    <a href="<?php echo INCLUDE_PATH ?>topico?id=<?php echo $idForum ?>"><?php echo $singleForum['nome'] ?></a>
    <span> > </span>
    <a href="<?php echo INCLUDE_PATH ?>topico/post?id=<?php echo $idForum?>&topic=<?php echo $idTopico ?>"><?php echo $singleTopico['nome']; ?>
    </a>
  </div>

  <section>
    <?php
      foreach ($listarPosts as $key => $value) {
    ?>
      <div>
        <h3><?php echo $value['nome'] ?></h3>
        <p><?php echo $value['mensagem'] ?></p>
        <hr>
      </div>
    <?php } ?>
  </section>

  <form action="" method="post">
    <?php
      // Enviar mensagem no post
      if (isset($_POST['enviar_mensagem'])) {
        $nomeUsuario = $_POST['nome'];
        $mensagem = $_POST['mensagem'];
        $enviarMensagem = MySql::connect()->prepare("INSERT INTO `posts` VALUES (null, ?, ?, ?)");
        $enviarMensagem->execute(array($idTopico, $nomeUsuario, $mensagem));
        header('Location: '.INCLUDE_PATH.'topico/post?id='.$idForum.'&topic='.$idTopico);
      }
    ?>
    <input type="text" name="nome">
    <textarea name="mensagem" id=""></textarea>
    <input type="submit" name="enviar_mensagem" value="Enviar">
  </form>
<?php } else { ?>
  <p>Fórum não existe.</p>
<?php } ?>
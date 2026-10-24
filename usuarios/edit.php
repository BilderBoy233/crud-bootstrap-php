<?php
require_once('functions.php');
edit();
?>
<?php include(HEADER_TEMPLATE); ?>

<h2 class="mt-2">Atualizar Moto</h2>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); unset($_SESSION['type']); ?>
<?php endif; ?>

<form action="edit.php?id=<?php echo $user['id']; ?>" method="post" enctype="multipart/form-data">
    <hr>
    <div class="row">
        <div class="form-group col-md-8">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="user[nome]" maxlength="50" required value="<?php echo $user['nome']; ?>">
        </div>

        <div class="form-group col-md-4">
            <label for="user">Usuário(Login)</label>
            <input type="text" class="form-control" id="user" name="user[user]" maxlength="30" required value="<?php echo $user['user']; ?>">
        </div>

        <div class="form-group col-md-4">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="user[password]" maxlength="20" required value="<?php echo $user['password']; ?>">
        </div>

    </div>

    <div class="row mt-2">
        <div class="form-group col-md-5">
            <label for="foto">Nova Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png">
            <small class="form-text text-muted">Deixe vazio para manter a foto atual.</small>
        </div>
    </div>

    <div class="mt-3">
      <p>Foto atual:</p>

      <?php if (!empty($user['foto']) && file_exists("uploads/" . $user['foto'])): ?>
          <img id="previewFoto"
              src="uploads/<?php echo $user['foto']; ?>"
              alt="Foto do usuário"
              style="width: 400px; height: 300px; object-fit: cover;">
      <?php else: ?>
          <img id="previewFoto"
              src="fotos/sem-foto.jpg"
              alt="Sem foto"
              style="width: 400px; height: 300px; object-fit: cover;">
      <?php endif; ?>
  </div>

    <div id="actions" class="row mt-3">
        <div class="col-md-12">
            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            <a href="index.php" class="btn btn-light"><i class="fa-regular fa-circle-xmark"></i> Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>

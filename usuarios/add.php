<?php
require_once('functions.php');
add();
?>
<?php include(HEADER_TEMPLATE); ?>

<h2 class="mt-2">Nova Moto</h2>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); unset($_SESSION['type']); ?>
<?php endif; ?>

<form action="add.php" method="post" enctype="multipart/form-data">
    <hr>
    <div class="row">
        <div class="form-group col-md-5">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="user[nome]" maxlength="50" required>
        </div>

        <div class="form-group col-md-3">
            <label for="marca">Usuario(Login)</label>
            <input type="text" class="form-control" id="marca" name="user[user]" maxlength="30" required>
        </div>

        <div class="form-group col-md-2">
            <label for="motor">Senha</label>
            <input type="password" class="form-control" id="motor" name="user[password]" maxlength="20" required>
        </div>
    </div>

    <div class="row mt-2">
        <div class="form-group col-md-5">
            <label for="foto">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg,.jpeg,.png">
            <small class="form-text text-muted">Formatos permitidos: JPG, JPEG e PNG.</small>

            <div class="mt-3">
                <p>Pré-visualização:</p>
                <img id="previewFoto"
                    src="fotos/sem-foto.jpg"
                    alt="Pré-visualização da foto"
                    style="width: 400px; height: 300px; object-fit: cover;">
            </div>
        </div>
    </div>

    <div id="actions" class="row mt-3">
        <div class="col-md-12">
            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
            <a href="index.php" class="btn btn-light"><i class="fa-regular fa-circle-xmark"></i> Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>

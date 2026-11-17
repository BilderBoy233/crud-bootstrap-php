<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "Você precisa estar logado para acessar esta página.";
    $_SESSION['type'] = "danger";
    header("Location: ../inc/login.php");
    exit;
}

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
            <label for="modelo">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="moto[modelo]" maxlength="50" required>
        </div>

        <div class="form-group col-md-3">
            <label for="marca">Marca</label>
            <input type="text" class="form-control" id="marca" name="moto[marca]" maxlength="30" required>
        </div>

        <div class="form-group col-md-2">
            <label for="motor">Motor</label>
            <input type="text" class="form-control" id="motor" name="moto[motor]" maxlength="20" required>
        </div>

        <div class="form-group col-md-2">
            <label for="placa">Placa</label>
            <input type="text" class="form-control" id="placa" name="moto[placa]" minlength="7" maxlength="7"
                pattern="[A-Za-z]{3}[A-Za-z0-9]{4}" title="Digite os 7 caracteres da placa, sem espaço ou hífen." required>
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
                    src="img/sem-foto.jpg"
                    alt="Pré-visualização da foto"
                    class="img-thumbnail"
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputFoto = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');

    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function (event) {
            const arquivo = event.target.files[0];

            if (arquivo) {
                const objectUrl = URL.createObjectURL(arquivo);
                previewFoto.src = objectUrl;

                previewFoto.onload = function () {
                    URL.revokeObjectURL(objectUrl);
                };
            } else {
                previewFoto.src = 'img/sem-foto.jpg';
            }
        });
    }
});
</script>

<?php include(FOOTER_TEMPLATE); ?>
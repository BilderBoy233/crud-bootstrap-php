<?php
include "functions.php";
view($_GET['id']);
include HEADER_TEMPLATE;
?>

<div class="card-header mt-4">
    <h2 class="mt-2">Moto <?php echo $moto['id']; ?></h2>
</div>
<div class="card">
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?= $_SESSION['message']; ?></div>
    <?php endif; ?>

    <div class="card-body">
        <dl class="row mb-3">
            <dt class="col-sm-4">Modelo:</dt>
            <dd class="col-sm-8"><?php echo $moto['modelo']; ?></dd>

            <dt class="col-sm-4">Marca:</dt>
            <dd class="col-sm-8"><?php echo $moto['marca']; ?></dd>

            <dt class="col-sm-4">Motor:</dt>
            <dd class="col-sm-8"><?php echo $moto['motor']; ?></dd>

            <dt class="col-sm-4">Placa:</dt>
            <dd class="col-sm-8"><?php echo FormatPlaca($moto['placa']); ?></dd>

            <dt class="col-sm-4">Data de Cadastro:</dt>
            <dd class="col-sm-8"><?php echo FormatData($moto['datacad'], "d/m/y - H:i:s"); ?></dd>

            <dt class="col-sm-4">Foto:</dt>
            <dd class="col-sm-8">
                <?php if (!empty($moto['foto'])): ?>
                    <img src="uploads/<?php echo $moto['foto']; ?>" 
                         alt="Foto da moto" 
                         style="width:400px; height: 400px;;">
                <?php else: ?>
                    <span>Sem foto cadastrada</span>
                <?php endif; ?>
            </dd>
        </dl>
    </div>
</div>

<div id="actions" class="row mt-4">
    <div class="col-md-12">
        <a href="edit.php?id=<?php echo $moto['id']; ?>" class="btn btn-secondary">
            <i class="fa-solid fa-pen-to-square"></i> Editar
        </a>
        <a href="index.php" class="btn btn-light">
            <i class="fa-solid fa-arrow-rotate-left"></i> Voltar
        </a>
    </div>
</div>

<?php include FOOTER_TEMPLATE; ?>

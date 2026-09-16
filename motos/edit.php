<?php 
  include "functions.php"; 
  edit();
  include HEADER_TEMPLATE;
?>
<br>
<h2>Atualizar Moto</h2>

<form class="needs-validation" novalidate action="edit.php?id=<?php echo (int) $moto['id']; ?>" method="post" enctype="multipart/form-data">
  <hr>

  <div class="row g-3 mb-3">
    <div class="col-md-7">
      <label for="modelo" class="form-label">Modelo da Motocicleta</label>
      <input type="text" class="form-control" id="modelo" name="moto[modelo]" value="<?php echo ($moto['modelo']); ?>" required>
      <div class="invalid-feedback">Informe o modelo.</div>
    </div>

    <div class="col-md-3">
      <label for="marca" class="form-label">Marca</label>
      <input type="text" class="form-control" id="marca" name="moto[marca]" value="<?php echo ($moto['marca']); ?>" required>
      <div class="invalid-feedback">Informe a marca.</div>
    </div>

    <div class="col-md-3">
      <label for="motor" class="form-label">Motor</label>
      <input type="text" class="form-control" id="motor" name="moto[motor]" value="<?php echo ($moto['motor']); ?>" required>
      <div class="invalid-feedback">Informe o motor.</div>
    </div>

    <div class="col-md-2">
      <label for="datacad" class="form-label">Data de Cadastro</label>
      <input type="date" class="form-control" id="datacad" name="moto[datacad]" value="<?php echo (FormatData($moto['datacad'], "d/m/y - H:i:s")); ?>" required>
      <div class="invalid-feedback">Informe a data de cadastro.</div>
    </div>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-md-5">
      <label for="foto" class="form-label">Foto (Apenas formato .jpg, .jpeg e .png)</label>
      <!-- campo de upload -->
      <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
      <?php if (!empty($moto['foto'])): ?>
        <p>Foto atual:</p>
        <img src="uploads/<?php echo $moto['foto']; ?>" alt="Foto da moto" style="max-width:150px;">
      <?php endif; ?>
      <div class="invalid-feedback">Envie a foto da moto.</div>
    </div>

    <div class="col-md-2">
      <label for="placa" class="form-label">Placa</label>
      <input type="text" class="form-control" id="placa" name="moto[placa]" value="<?php echo ($moto['placa']); ?>" required>
      <div class="invalid-feedback">Informe a placa.</div>
    </div>
  </div>

  <div id="actions" class="row">
    <div class="col-md-12">
      <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-floppy-disk"></i>Salvar</button>
      <a href="index.php" class="btn btn-light"><i class="fa-regular fa-circle-xmark"></i>Cancelar</a>
    </div>
  </div>
</form>

<?php include FOOTER_TEMPLATE; ?>

<?php

include "../config.php";
include DBAPI;

$motos = null;
$moto = null;

/**
 *  Listagem de Motos
 */
function index()
{
    global $motos;
    $motos = find_all("motos");
}

/**
 *  Visualização de uma Moto
 */
function view($id = null) {
  global $moto;
  $moto = find("motos", $id);
}

/**
 *  Funções de formatação
 */
function FormatData($data, $format) {
    $dt = new DateTime($data, new DateTimeZone("-0300"));
    return $dt->format($format);
}
function FormatPlaca($placa) {
    return substr($placa,0,3) . " " . substr($placa,3);
}

/**
 *  Cadastro de Motocicletas
 */
function add() {
  if (!empty($_POST['moto'])) {
    $today = new DateTime('now', new DateTimeZone("-0300"));
    $moto = $_POST['moto'];
    $moto['datacad'] = $today->format("Y-m-d H:i:s");

    // Upload da foto
    if (!empty($_FILES['foto']['name'])) {
      $targetDir = __DIR__ . "/uploads/";
      if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
      }
      // gera nome único
      $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '_', $_FILES['foto']['name']);
      $targetFile = $targetDir . $fileName;

      if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        $moto['foto'] = $fileName; // salva o mesmo nome no banco
      }
    }

    save("motos", $moto);
    header("location: index.php");
  }
}

/**
 *  Insere um registro no BD
 */
function save($table = null, $data = null) {
  $database = open_database();
  $columns = null;
  $values = null;

  foreach ($data as $key => $value) {
    $columns .= trim($key, "'") . ",";
    $values .= "'$value',";
  }

  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');
  
  $sql = "INSERT INTO $table ($columns) VALUES ($values);";

  try {
    $database->query($sql);
    $_SESSION['message'] = "Registro cadastrado com sucesso!";
    $_SESSION['type'] = 'success';
  } catch (Exception $e) { 
    $_SESSION['message'] = "Não foi possível realizar a operação.";
    $_SESSION['type'] = 'danger';
  } 

  close_database($database);
}

/**
 *  Atualização/Edição de Moto
 */
function edit() {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['moto'])) {
      $moto = $_POST['moto'];

      // Upload da foto
      if (!empty($_FILES['foto']['name'])) {
        $targetDir = __DIR__ . "/uploads/";
        if (!is_dir($targetDir)) {
          mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '_', $_FILES['foto']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
          $moto['foto'] = $fileName; // salva o mesmo nome no banco
        }
      }

      update("motos", $id, $moto);
      header("location: index.php");
    } else {
      global $moto;
      $moto = find("motos", $id);
    }
  } else {
    header("location: index.php");
  }
}

function update($table = null, $id = 0, $data = null) {
  $database = open_database();
  $items = null;

  foreach ($data as $key => $value) {
    $items .= trim($key, "'") . "='$value',";
  }

  $items = rtrim($items, ',');
  $sql  = "UPDATE $table SET $items WHERE id=$id";

  try {
    $database->query($sql);
    $_SESSION['message'] = "Registro atualizado com sucesso.";
    $_SESSION['type'] = "success";
  } catch (Exception $e) { 
    $_SESSION['message'] = "Não foi possível realizar a operação.";
    $_SESSION['type'] = "danger";
  } 

  close_database($database);
}

/**
 *  Exclusão de uma Moto
 */
function delete($id = null) {
  global $moto;
  $moto = find("motos", $id);

  // Remove a foto do servidor
  if ($moto && !empty($moto['foto'])) {
    $filePath = __DIR__ . "/uploads/" . $moto['foto'];
    if (file_exists($filePath)) {
      unlink($filePath);
    }
  }

  $moto = remove("motos", $id);
  header("location: index.php");
}

/**
 *  Remove uma linha de uma tabela pelo ID
 */
function remove($table = null, $id = null) {
  $database = open_database();
    
  try {
    if ($id) {
      $sql = "DELETE FROM $table WHERE id=$id";
      $result = $database->query($sql);

      if ($result) {    
        $_SESSION['message'] = "Registro removido com sucesso.";
        $_SESSION['type'] = "success";
      }
    }
  } catch (Exception $e) { 
    $_SESSION['message'] = "Não foi possível realizar a operação. " . $e->getMessage();
    $_SESSION['type'] = "danger";
  }

  close_database($database);
}

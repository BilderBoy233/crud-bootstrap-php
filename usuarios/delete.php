<?php

include "functions.php";

if (empty($_SESSION['user']) || $_SESSION['user'] !== 'admin')
{
    $_SESSION['message'] = "Acesso restrito a administradores.";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "index.php");
    exit;
}
if  (isset($_GET["id"])) {
    delete($_GET["id"]);
} else {
    die("ERRO: ID não definido.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Bootstrap CRUD</title>
</head>
<body>
<?php require_once 'config.php'; ?>
<?php require_once DBAPI; ?>

<?php 
	include "config.php";

	include DBAPI;

	try {
		$db = open_database();
		echo "<h1>Banco de Dados Conectado!</h1>";
	} catch (Exception $e) {
		echo "<h2>{$e->getMessage()}</h2>";
	}
?>  
</body>
</html>
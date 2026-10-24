<?php 
    // Subir um nível (../) para encontrar o config.php na raiz
    include ("../config.php");

    try {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Limpa e destrói os dados da sessão atual
        session_unset();
        session_destroy();

        // Redireciona de volta para a tela inicial ou login
        header("Location: " . BASEURL . "index.php");
        exit;
    } catch(Exception $e) {
        $_SESSION['message'] = "Ocorreu um erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
?>
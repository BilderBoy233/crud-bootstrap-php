<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title>CRUD com Bootstrap</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">

    <script>
        var temaSalvo = localStorage.getItem('tema');

        if (temaSalvo) {
            document.documentElement.setAttribute('data-bs-theme', temaSalvo);
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top container site-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo BASEURL; ?>index.php">
            <i class="fa-solid fa-house-chimney"></i> CRUD
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Esquerda: Menus principais -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Clientes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-users"></i> Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?php echo BASEURL; ?>customers/add.php">
                                <i class="fa-solid fa-user-plus"></i> Novo Cliente
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASEURL; ?>customers">
                                <i class="fa-solid fa-users"></i> Gerenciar Clientes
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Motos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-motorcycle"></i> Motos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo BASEURL; ?>motos/add.php"><i class="fa-solid fa-plus"></i> Nova Moto</a></li>
                        <li><a class="dropdown-item" href="<?php echo BASEURL; ?>motos"><i class="fa-solid fa-motorcycle"></i> Gerenciar Motos</a></li>
                    </ul>
                </li>

                <!-- Usuários (Apenas Admin) conforme a imagem -->
                <?php if (isset($_SESSION['user'])) : ?>
                    <?php if ($_SESSION['user'] == "admin") : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-lock"></i> Usuários
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios/add.php">
                                        <i class="fa-solid fa-user-tie"></i> Adicionar Usuário
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios">
                                        <i class="fa-solid fa-user-lock"></i> Gerenciar Usuários
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <!-- Direita: Tema + Login / Logout -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
                <!-- Seu botão de Tema -->
                <li class="nav-item">
                    <button class="btn btn-theme btn-sm" id="toggleTema" type="button">
                        <i class="fa-solid fa-moon" id="iconeTema"></i>
                        <span id="textoTema">Modo escuro</span>
                    </button>
                </li>

                <!-- Login / Logout conforme a imagem -->
                <?php if (isset($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASEURL; ?>inc/logout.php">
                            Bem vindo <?php echo $_SESSION['user']; ?>! <i class="fa-solid fa-person-walking-arrow-right"></i> Desconectar
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASEURL; ?>inc/login.php">
                            <i class="fa-solid fa-users"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <main class="container">
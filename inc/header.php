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
                            <?php if (isset($_SESSION['user'])) : ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>customers/add.php">
                                    <i class="fa-solid fa-user-plus"></i> Novo Cliente
                                </a>
                            </li>
                            <?php endif; ?>
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
                            <?php if (isset($_SESSION['user'])) : ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>motos/add.php">
                                    <i class="fa-solid fa-plus"></i> Nova Moto
                                </a>
                            </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo BASEURL; ?>motos">
                                    <i class="fa-solid fa-motorcycle"></i> Gerenciar Motos
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Usuários (Apenas Admin) -->
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] == "admin") : ?>
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
                </ul>

                <!-- Direita: Tema + Login / Usuário Logado -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
                    <!-- Botão de Tema -->
                    <li class="nav-item">
                        <button class="btn btn-theme btn-sm" id="toggleTema" type="button">
                            <i class="fa-solid fa-moon" id="iconeTema"></i>
                            <span id="textoTema">Modo escuro</span>
                        </button>
                    </li>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php
                            // Ajuste os nomes das chaves de sessão abaixo conforme o seu valida.php
                            $nomeUsuario = !empty($_SESSION['nome']) ? $_SESSION['nome'] : $_SESSION['user'];
                            $fotoUsuario = !empty($_SESSION['foto']) ? $_SESSION['foto'] : 'semimagem.jpg';
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo BASEURL; ?>usuarios/uploads/<?php echo htmlspecialchars($fotoUsuario); ?>"
                                     alt="Foto de <?php echo htmlspecialchars($nomeUsuario); ?>"
                                     class="rounded-circle object-fit-cover"
                                     style="width: 30px; height: 30px;">
                                <span><?php echo htmlspecialchars($nomeUsuario); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="px-3 py-1 text-muted small">
                                    Logado como <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a href="<?php echo BASEURL; ?>inc/perfil.php" class="btn btn-outline-secondary btn-sm">
                                            Meu Perfil
                                        </a>
                                    <a class="dropdown-item text-danger" href="<?php echo BASEURL; ?>inc/logout.php">
                                        <i class="fa-solid fa-person-walking-arrow-right"></i> Desconectar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <i class="fa-solid fa-users"></i> Login
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 260px;">
                                <form action="<?php echo BASEURL; ?>inc/valida.php" method="post">
                                    <div class="mb-2">
                                        <label for="navLogin" class="form-label mb-1">Usuário</label>
                                        <input type="text" class="form-control form-control-sm" id="navLogin" name="login" placeholder="Digite seu usuário" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="navSenha" class="form-label mb-1">Senha</label>
                                        <input type="password" class="form-control form-control-sm" id="navSenha" name="senha" placeholder="Digite sua senha" required>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-secondary btn-sm">
                                            <i class="fa-solid fa-user-check"></i> Conectar
                                        </button>
                                        <a href="<?php echo BASEURL; ?>inc/login.php" class="btn btn-outline-secondary btn-sm">
                                            Tela completa de login
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
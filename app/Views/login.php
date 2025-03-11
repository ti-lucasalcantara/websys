<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/websys/assets/imagens/logo/logo.png">
   
    <!-- Bootstrap  v5.3.3 -->
    <link href="/websys/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    
    <!-- sweetalert2 -->
    <link href="/websys/assets/plugins/sweetalert/css/sweetalert2.min.css" rel="stylesheet"> 

    <!-- select2 -->
    <link href="/websys/assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- fontawesome -->
    <link href="/websys/assets/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- toast -->
    <link href="/websys/assets/plugins/toast/css/jquery.growl.css" rel="stylesheet" type="text/css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .login-box {
            height: 70vh;
            display: flex;
            justify-content: center;
        }
        .login-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
    
    <!-- CSS -->
    <?= $this->renderSection('css') ?>

    <title>WebSys - Login</title>
</head>

<?php
$background_env = env('CI_ENVIRONMENT') == 'testing' ? 'background: url(/websys/assets/imagens/env/hom.png);' : (env('CI_ENVIRONMENT') == 'development' ? 'background: url(/websys/assets/imagens/env/dev.png);' : '');
?>

<body style="background-color: var(--backgroud); display: flex; flex-direction: column; min-height: 100vh; <?=$background_env?>">

    <header class="container-fluid py-3 border-bottom bg-white">
        <div class="container">
            <div class="d-flex" style="justify-content: center;">
                <div>
                    <a href="<?=url_to('home')?>">
                        <img src="/websys/assets/imagens/logo/logoPrincipal.png" class="img-fluid" alt="CRFMG" width="200">
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <main style="flex: 1;">
        <div class="container login-box mt-3">
            <div class="row justify-content-center w-100">
                <div class="col-12 col-md-4 col-lg-4 login-content">
                    <h4 class="text-center">- WebSys -</h4>
                    <h5 class="text-center">Acesso Restrito</h5>
                    <form id="form" method="POST" action="<?=url_to('login')?>" class="mt-4" autocomplete="off" >
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <div class="form-floating">
                                <input type="text" name="usuario" class="form-control <?=empty(validation_show_error('usuario')) ? '' : 'is-invalid'?>" id="usuario" placeholder="Usuário de rede" value="<?=set_value('usuario')?>">
                                <label for="usuario">Usuário</label>
                            </div>
                            <small class="text-danger pull-right w-100" style="text-align:right"><?=validation_show_error('usuario')?></small>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="togglePassword"  style="cursor: pointer;" >
                                <i id="iconToggle" class="fa-solid fa-eye"></i>
                            </span>
                            <div class="form-floating">
                                <input type="password" name="senha" class="form-control <?= empty(validation_show_error('senha')) ? '' : 'is-invalid' ?>" id="senha" placeholder="Senha de rede" value="<?= set_value('senha') ?>">
                                <label for="senha">Senha</label>
                            </div>
                            <small class="text-danger pull-right w-100" style="text-align:right"><?= validation_show_error('senha') ?></small>
                        </div>


                        <div class="d-grid gap-2">
                            <button id="btn-send" type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Entrar</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                    <small>Utilize seu Login e senha de rede.</small>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- jquery-3.7.1 -->
    <script src="/websys/assets/plugins/jquery/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap  v5.3.3 -->
    <script src="/websys/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- fontawesome -->
    <script src="/websys/assets/fontawesome/js/all.min.js"></script>

    <!-- toast -->
    <script src="/websys/assets/plugins/toast/js/jquery.growl.js" type="text/javascript"></script>

    <!-- sweetalert2 -->
    <script src="/websys/assets/plugins/sweetalert/js/sweetalert2.all.min.js"></script>

    <?= $this->include('_componentes/toast') ?>
    <?= $this->include('_componentes/sweet-alert') ?>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('senha');
            const toggleIcon = document.getElementById('iconToggle');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });

        $(function(){
            $("#form").submit(function(){
                $("#btn-send").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
            });
        });
    </script>

</body>
</html>
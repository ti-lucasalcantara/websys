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

    <!-- apexcharts -->
    <link href="/websys/assets/plugins/apexcharts/dist/apexcharts.css" rel="stylesheet" type="text/css" />

   
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --backgroud: #f8f8fc;
            --sys_dash: #006070;
            --sys_atendimento: #0095CC;
            --sys_verde: #389c64; 
            --sys_vermelho: #cf1318;
            --sys_azul: #000080;
            --sys_roxo: #800040;
            --sys_marrom: #844240;
            --sys_laranja: #ff8040;
        }

        .item-menu-superior{
            min-width: 160px !important;
        }

        .item-submenu-superior{
            min-width: 160px !important;
        }
    </style>
    
    <!-- CSS -->
    <?= $this->renderSection('css') ?>

    <title>WebSys - <?=$titulo_pagina ?? 'CRF/MG'?> </title>
</head>

<?php
$background_env = env('CI_ENVIRONMENT') == 'testing' ? 'background: url(/websys/assets/imagens/env/hom.png);' : (env('CI_ENVIRONMENT') == 'development' ? 'background: url(/websys/assets/imagens/env/dev.png);' : '');
?>

<body style="background-color: var(--backgroud); display: flex; flex-direction: column; min-height: 100vh; <?=$background_env?>">

    <header class="container-fluid py-3 border-bottom bg-white">
        <div class="container">
            <div class="d-flex" style="justify-content: space-between;">
                <div>
                    <a href="<?=url_to('home')?>">
                        <img src="/websys/assets/imagens/logo/logoPrincipal.png" class="img-fluid" alt="CRFMG" width="200">
                    </a>
                </div>
                <div style="display: flex; flex-direction: column; align-self: center; align-items: center;">
                    <div class="dropdown" style="width: 45px; height: 45px; border-radius: 50%; border:1px solid rgba(0,0,0,0.3);">
                        <div  data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                            <img src="<?=session('usuario_logado')['avatar']?>" alt="<?=session('usuario_logado')['login']?>" class="rounded-circle me-4" 
                            style="width: 45px; height: 45px; object-fit: cover; object-position: center top;">

                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item disabled" href="javascript:void();"></a></li>
                            <li><a class="dropdown-item" href="<?=url_to('configuracoes.meuperfil')?>"><i class="fa-solid fa-user"></i> Meu Perfil</a></li>
                            <li><hr></li>
                            <li><a class="dropdown-item" href="<?=url_to('sair')?>"><i class="fa-solid fa-right-from-bracket"></i> Sair</a></li>
                        </ul>
                    </div>
                    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                        <?=session('usuario_logado')['login'] ?? ''?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <main style="flex: 1;">
        <?= $this->include('template/fixos/menu_superior') ?>

        <?= $this->renderSection('submenu') ?>

        <?= $this->include('template/fixos/breadcrumb') ?>

        <?= $this->renderSection('conteudo') ?>
    </main>

    <footer class="bg-light text-center pt-2 border-top" style="font-size: 12px;">
        <p>Conselho Regional de Farmácia do Estado de Minas Gerais<br>&copy; Gerência de Tecnologia da Informação - <?=date('Y')?></p>
    </footer>

    <!-- jquery-3.7.1 -->
    <script src="/websys/assets/plugins/jquery/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap  v5.3.3 -->
    <script src="/websys/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- sweetalert2 -->
    <script src="/websys/assets/plugins/sweetalert/js/sweetalert2.all.min.js"></script>

    <!-- select2 -->
    <script src="/websys/assets/plugins/select2/js/select2.full.min.js"></script>

    <!-- fontawesome -->
    <script src="/websys/assets/fontawesome/js/all.min.js"></script>
    
    <!-- toast -->
    <script src="/websys/assets/plugins/toast/js/jquery.growl.js" type="text/javascript"></script>

    <!-- inputmask -->
    <script src="/websys/assets/plugins/inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
    
    <!-- apexcharts -->
    <script src="/websys/assets/plugins/apexcharts/dist/apexcharts.min.js" type="text/javascript"></script>

    <!-- datatables -->
    <script src="/websys/assets/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <link href="/websys/assets/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />

    <script>
        $.fn.loading = function(disabled=true, text='') {
            return this.each(function() {
                const displayText = text || '<i class="fa fa-spinner fa-spin"></i> Aguarde...';
                $(this).html(displayText).prop('disabled', disabled);
            });
        };

        $.fn.resetLoading = function(text='Ok') {
            return this.each(function() {
                $(this).html(`${text}`).prop('disabled', false);
            });
        };

        $.fn.retorno = function(type='',title='',text='') {
            return this.each(function() {
                $(this).empty().html(`<div class='alert alert-${type}'><b>${title}</b><br>${text}</div>`);
            });
        };

        function showToast(title = 'Atenção!', text = '-', type = 'default') {
            if (type === 'danger') type = 'error';
            if (type === 'success') type = 'notice';

            $.growl({
                title: title,
                message: text,
                style: type,
            });
        }

        async function executarAjax(url, data, method='POST', debug=false) {
            try {
				
                if ( url === null || data === null ){
                    throw 'Parameter is not found!';
                }

                const result = await $.ajax({
                    type: method,
                    method: method,
                    url: url,
                    data: data,
                    dataType: 'json',
                    enctype:"multipart/form-data",
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        // console.log('beforeSend');
                    },
                    success: function(res){
                        // console.log('success', res);
                    }
                }).done(function( res ) {
                    // console.log('done',res);

                }).fail(function(jqXHR, textStatus, errorThrown) {

                    console.error('Erro HTTP:', jqXHR.status); 
                    console.error('Retorno:', jqXHR);

                    if(jqXHR.status != 200){
                        if (jqXHR.responseJSON && jqXHR.responseJSON.show_toast === true) {
                            showToast(jqXHR.responseJSON.title, jqXHR.responseJSON.text, jqXHR.responseJSON.type);
                        }
                    }

                }).always(function( res, textStatus, jqXHR ) {
                    if(debug){
                        console.log('always',res);
                    }
                    return res;
                }); 
                
                return result;

            } catch (error) {
                console.error('Catch error:', error);
                if (error.responseJSON && error.responseJSON.show_toast === true) {
                    showToast(error.responseJSON.title, error.responseJSON.text, error.responseJSON.type);
                }
                throw error;
                return false;
            }
        }

        function tratarErrosValidacao(erros, boxRetorno = '.retornoAjax') {
            if (erros && erros.formValidation) {
                // Limpa erros anteriores
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Exibe os novos erros
                Object.entries(erros.formValidation).forEach(([campo, mensagem]) => {
                    const input = $(`#${campo}`);
                    input.addClass('is-invalid');
                    input.next('.invalid-feedback').remove();
                    input.after(`<div class="invalid-feedback">${mensagem}</div>`);
                });
            } else {
                // Exibe mensagem genérica caso não seja erro de validação
                $(boxRetorno).retorno('danger', 'Erro', erros.message || 'Erro inesperado ao processar a requisição.');
            }
        }


        // Função para mover o foco para o próximo elemento
        function moveToNextElement(element, idForm) {
            // Obtém o índice do elemento que foi passado para a função
            var ordemAtual = parseInt(element.attr('data-focus-index'));
            var proximaOrdem = ordemAtual + 1;

            // Seleciona o próximo elemento com base no data-focus-index
            var proximoElemento = $(`#${idForm} [data-focus-index="${proximaOrdem}"]`);

            // Se o próximo elemento for um select2, abre o select2
            if (proximoElemento.is('select') && proximoElemento.hasClass('select2-hidden-accessible')) {
                proximoElemento.select2('open');
            } else if (proximoElemento.length) {
                // Se o próximo elemento for outro tipo de controle, dá foco nele
                proximoElemento.focus();
            } else if (element.is('button')) {
                // Se o próximo elemento for o botão de envio, dá submit no formulário
                $(`#${idForm}`).submit();
            }
        }

        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        
        $(".mask_date").inputmask({
            alias: "datetime",
            inputFormat: "dd/mm/yyyy",
            placeholder: "dd/mm/aaaa"
        });
      
        // Inicio validar permissões no sistema.
        async function validarPermissao(chave) {
            return await executarAjax(`<?=url_to('adm.acl.validarPermissao')?>`, `key_permissao=${chave}`, method='GET');
        }
        const elementos = document.querySelectorAll('[data-permissao-key]');
        const elementosArray = Array.from(elementos);
        elementosArray.forEach(async elemento => {
            const chavePermissao = elemento.getAttribute('data-permissao-key');
            const resposta = await validarPermissao(chavePermissao);
            if (!resposta.acesso) {
                elemento.innerHTML = `<span class="text-danger">${resposta.messagem}</span>`;
            }
        });
        // Fim validar permissões no sistema.


        // Make a sessions
        async function criarSessionInscricaoPFId(InscricaoPFId){
            return await executarAjax(`<?=url_to('sessions.inscricaopfid')?>`, `InscricaoPFId=${InscricaoPFId}`, method='GET');
        }
    </script>

    <?= $this->include('_componentes/toast') ?>
    <?= $this->include('_componentes/sweet-alert') ?>
    <?= $this->include('_componentes/modal-excluir') ?>

    <!-- JS -->
    <?= $this->renderSection('js') ?>
  
</body>
</html>
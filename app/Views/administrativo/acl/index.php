<?= $this->extend('template/principal') ?>

<?= $this->section('submenu') ?>
    <?= $this->include('administrativo/_submenu') ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <div class="vh-100 bg-white p-2">
                <div class="text-center mt-2">
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm col-12"  data-bs-toggle="modal" data-bs-target="#modalCriarPerfil">
                        <i class="fa fa-plus"></i> Criar Perfil
                    </a>
                </div>    
              
                <hr>
                <!-- Perfís cadastrados -->
                <?php
                    if(isset($perfis)){
                ?>
                <ul class="list-group">
                    <?php
                    foreach ($perfis as $perfil) {
                    ?>
                    <a href="<?=url_to('adm.acl.perfil', base64_encode($perfil['id_perfil']))?>" style="text-decoration: none;">
                        <li class="list-group-item d-flex justify-content-between align-items-center <?=isset($perfil_selecionado) && $perfil_selecionado['id_perfil'] == $perfil['id_perfil'] ? 'bg-info' : ''?>">
                            <?=$perfil['nome']?>
                            <span class="badge text-bg-secondary rounded-pill"><?=$perfil['qtd_usuarios'] ?? 0?></span>
                        </li>
                    </a>
                    <?php
                    }
                    ?>
                </ul>
                <?php
                    }
                ?>
            </div>
        </div>  

        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-user-shield"></i> Controle de Acesso <?=is_null($perfil_selecionado) ? '' : '<b>'.$perfil_selecionado['nome'].'</b>';?>
                </div>
                <div class="card-body">
                    <?php
                    if(is_null($perfil_selecionado)){
                    ?>
                    <p>
                        Selecione um perfil para gerenciar.
                    </p>
                    <?php
                    }else{
                    ?>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link <?=$tab == 'perfil' ? 'active' : ''?>" aria-current="page" href="<?=url_to('adm.acl.tab', base64_encode($perfil_selecionado['id_perfil']), 'perfil')?>">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$tab == 'permissoes' ? 'active' : ''?>" aria-current="page" href="<?=url_to('adm.acl.tab', base64_encode($perfil_selecionado['id_perfil']), 'permissoes')?>">Permissões</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=$tab == 'usuarios' ? 'active' : ''?>" aria-current="page" href="<?=url_to('adm.acl.tab', base64_encode($perfil_selecionado['id_perfil']), 'usuarios')?>">Usuários</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <?php   
                            try {
                                echo $this->include('administrativo/acl/tab_'.$tab);
                            } catch (\Throwable $th) {
                                echo "Falha ao carregar view: [$tab]";
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>
        </div>

    </div>
</div>


<!-- modal -->
<div class="modal fade" id="modalCriarPerfil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCriarPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalCriarPerfilLabel">Novo Perfil</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="#" id="form_criarPerfil">
                <div class="mb-3">
                    <label for="nome" class="col-form-label">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Dê um nome para este perfil">
                </div>
                <div class="mb-3">
                    <label for="descricao" class="col-form-label">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição deste perfil" rows="4" style="resize: none;"></textarea>
                </div>
                <div class="retornoAjax"></div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-success" id="submit_criarPerfil"><i class="fa fa-check"></i> Salvar</button>
        </div>
        </div>
    </div>
</div>
<!-- \modal -->
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$("#submit_criarPerfil").click(function(e){
    e.preventDefault();
    $("#form_criarPerfil").submit();
});

$("#form_criarPerfil").submit(async function(e){
    e.preventDefault();
    $("#submit_criarPerfil").loading();

    // Limpa o formulário: remove classes is-invalid e mensagens de feedback
    $(".retornoAjax").empty();
    $(this).find('.is-invalid').removeClass('is-invalid');
    $(this).find('.invalid-feedback').remove();

    try {
        var dados = new FormData();
        dados.append('nome', $("#nome").val() );
        dados.append('descricao', $("#descricao").val() );

        var retorno = await executarAjax(url=`<?=url_to('adm.acl.criarPerfil')?>`, dados, method='POST', debug=true);
        if (retorno.type === 'success') {
            $(this).trigger('reset');
            $('#modalCriarPerfil').modal('hide');
            showToast(retorno.title, retorno.text, retorno.type);

            setTimeout(function() {
                location.reload(); 
            }, 1000); // valor em ms

        }else{
            $(".retornoAjax").retorno(retorno.type, retorno.title, retorno.text);
        }
    } catch (error) {
        tratarErrosValidacao(error.responseJSON, '.retornoAjax');
    }

    $("#submit_criarPerfil").loading(false, `<i class="fa fa-check"></i> Salvar`);        
});
</script>
<?= $this->endSection() ?>




<div class="card mt-2">
    <div class="card-header">Usuários</div>
    <div class="card-body" data-permissao-key="ACL_GERENCIAR_USUARIOS">
        <div class="">
            <label for="">Vincular funcionário ao perfil:</label>
            <br>
            <?= $this->include('_componentes/select-buscar-funcionarios') ?>
        </div>
        <hr>
        <div class="dadosUsuario" style="width: 35%; margin: 0 auto; display: none;" >
            <div class="my-4" style="display: flex; align-items: center; text-align: center; justify-content: center;">
                <div class="mx-2">
                    <img src="#" id="usuario_avatar" class="rounded-circle me-4" style="width: 105px; height: 105px; object-fit: cover; object-position: center top;">
                </div>
                <div class="mx-2">
                    <div style="font-weight: bold;">
                        <span id="usuario_nome"></span>
                        <br>
                        <span id="usuario_login"></span>
                    </div>    
                    <div class="">
                        <span id="usuario_cargo"></span>
                        <br>
                        <span id="usuario_gerencia"></span>
                    </div>
                </div>
            </div>
            <div class="mt-4" style="display: flex; align-items: center; text-align: center; justify-content: center;">
                <form action="<?=url_to('adm.acl.vincularUsuarioPerfil')?>" method="POST" id="form_vincularUsuarioPerfil" class="col-12">
                    <input type="hidden" name="id_usuario" id="id_usuario" value="">
                    <input type="hidden" name="id_perfil" id="id_perfil" value="<?=$perfil_selecionado['id_perfil']?>">
                    <button type="submit" id="submit_vincularUsuarioPerfil" class="btn btn-success col-12"><i class="fa fa-check"></i> vincular</button>
                </form>
            </div>
        </div>
        <hr>
        <?php
        if(!isset($usuarios_perfil) || is_null($usuarios_perfil) || empty($usuarios_perfil)){
        ?>
        <p>Nenhum usuário vínculado a este perfil.</p>
        <?php   
        }else{
        ?>

       
        <table class="table table-striped">
            <?php
            if(!empty($usuarios_perfil)){
                foreach ($usuarios_perfil as $usuario) {
                    if($usuario['id_usuario'] == 1){
                        continue;
                    }
            ?>
            <tr>
                <td style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <img src="<?=$usuario['avatar']?>" alt="<?=$usuario['login']?>" class="rounded-circle me-4" style="width: 80px; height: 80px; object-fit: cover; object-position: center top;">
                        <label>
                            <b><?=$usuario['nome']?></b> | <?=$usuario['cargo']?>
                            <br>
                            <?=$usuario['login']?>
                            <br>
                            <?=$usuario['gerencia']?>
                        </label>
                    </div>    
                    <div>
                        <button type="button" class="btn btn-danger btn-sm mx-3 modalExcluir" data-id-excluir="<?=$usuario['id_usuario_perfil']?>" data-url-excluir="<?=url_to('adm.acl.desvincularUsuarioPerfil')?>" data-mensagem-excluir="Confirma desvincular o usuário: <?=$usuario['login']?> ?">
                            <i class="fa fa-remove"></i> excluir
                        </button>
                    </div>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
        <?php
        }
        ?>

    </div>
</div>

<?= $this->section('js') ?>
<script>
    $("#form_vincularUsuarioPerfil").submit(async function(e){
        $("#submit_vincularUsuarioPerfil").loading();
    });

    function exibirDadosUsuario(usuario){
        $("#usuario_avatar").attr('src', usuario.avatar);
        $("#usuario_nome").html(usuario.nome);
        $("#usuario_login").html(usuario.login);
        $("#usuario_cargo").html(usuario.cargo);
        $("#usuario_gerencia").html(usuario.gerencia);
        $("#id_usuario").val(usuario.id);
        $(".dadosUsuario").show()
    }
</script>
<?= $this->endSection() ?>

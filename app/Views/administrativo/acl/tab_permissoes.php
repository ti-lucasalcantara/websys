<div class="card mt-2">
    <div class="card-header">Permissões deste perfil</div>
    <div class="card-body" data-permissao-key="ACL_GERENCIAR_PERMISSOES">
        
        <?php
        if(!isset($permissoes) || is_null($permissoes) || empty($permissoes)){
        ?>
        <p>Nenhuma permissão encontrada</p>
        <?php   
        }else{
        ?>
        <table class="table table-striped">
            <?php
            if(!empty($permissoes)){
                $id_permissoes_perfil = [];
                if(isset($permissoes_perfil) && !empty($permissoes_perfil)){
                    $id_permissoes_perfil = array_column($permissoes_perfil, 'id_permissao');
                }

                foreach ($permissoes as $permissao) {
                    $disabled = '';
                    if($perfil_selecionado['id_perfil'] == 1){
                        // perfil 1 = Administrador
                        $disabled = 'disabled';
                    }

                    $checked  = '';
                    if (in_array($permissao['id_permissao'], $id_permissoes_perfil)) {
                        $checked = 'checked';
                    }
            ?>
            <tr>
                <td style="display: flex; justify-content: space-between;">
                    <div class="form-check form-switch">
                        <input class="form-check-input item_permissao" type="checkbox" role="switch" id="id_permissao_<?=$permissao['id_permissao']?>" <?=$checked?> <?=$disabled?> value="<?=$permissao['id_permissao']?>">
                        <label class="form-check-label" for="id_permissao_<?=$permissao['id_permissao']?>">
                        <b><?=$permissao['nome']?></b>
                        </label>
                        <br>
                        <?=$permissao['descricao']?>
                    </div>    
                    <div>
                        <?=$permissao['key']?>
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
$(".item_permissao").click(async function(){

    var dados = new FormData();
    dados.append('id_perfil', `<?=$perfil_selecionado['id_perfil']?>` );
    dados.append('id_permissao',  $(this).val() );

    var retorno = await executarAjax(url=`<?=url_to('adm.acl.togglePermissaoAoPerfil')?>`, dados, method='POST', debug=false);
    showToast(retorno.title, retorno.text, retorno.type);
});
</script>
<?= $this->endSection() ?>

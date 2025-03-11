<form class="">
    <div class="row">
        <div class="col-md-2">
            <fieldset disabled>
                <label for="InscricaoPFId" class="form-label">Número de Inscrição</label>
                <input type="text" class="form-control" id="InscricaoPFId" value="<?=$dados_tab['InscricaoPFId']?>" readonly>
            </fieldset>
        </div>
        <div class="col-md-3">
            <fieldset disabled>
                <label for="NomePF" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="NomePF" value="<?=$dados_tab['NomePF']?>">
            </fieldset>
        </div>
        <div class="col-md-2">
            <fieldset disabled>
                <label for="DataInscricao" class="form-label">Data de Inscrição</label>
                <input type="date" class="form-control" id="DataInscricao" value="<?=($dados_tab['DataInscricao'])?>">
            </fieldset>
        </div>
        <div class="col-md-2">
            <fieldset disabled>
                <label for="StatusCadastral" class="form-label">Status Cadastral</label>
                <?=$this->include('_componentes/select-RefStatusCadastral');?>
            </fieldset>
        </div>
    </div>


    <div class="row my-4">
        <div class="col">
            <div class="accordion" id="accordionPanels">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion_head_protocolos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_protocolos" aria-expanded="false" aria-controls="accordion_protocolos">
                        Protocolos <?=(isset($dados_tab['protocolos']) && !empty($dados_tab['protocolos'])) ? '('.sizeof($dados_tab['protocolos']).')' : ''?>
                    </button>
                    </h2>
                    <div id="accordion_protocolos" class="accordion-collapse collapse" aria-labelledby="accordion_head_protocolos">
                        <div class="accordion-body">
                            <?php
                            if(isset($dados_tab['protocolos']) && !empty($dados_tab['protocolos'])){
                            ?>
                            <div>
                                <table class="table table-striped" id="tableProtocolos">
                                    <thead>
                                        <tr>
                                            <td>Data</td>
                                            <td>Protocolo</td>
                                            <td>Setor</td>
                                            <td>Assunto</td>
                                            <td>Anotações</td>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($dados_tab['protocolos'] as $protocolo) {
                                    ?>
                                    <tr>
                                        <td><?=dataPTBR($protocolo['Data'])?></td>
                                        <td><?=$protocolo['Contador']?></td>
                                        <td><?=$protocolo['SetorDestino']?></td>
                                        <td><?=$protocolo['Assunto']?></td>
                                        <td><?=$protocolo['Anotacao1']?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <?php
                            }else{
                            ?>
                            -Nenhum protocolo encontrado-
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordion_head_anotacoes">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_anotacoes" aria-expanded="false" aria-controls="accordion_anotacoes">
                        Anotações
                    </button>
                    </h2>
                    <div id="accordion_anotacoes" class="accordion-collapse collapse" aria-labelledby="accordion_head_anotacoes">
                        <div class="accordion-body">
                            <?php
                            if(isset($dados_tab['anotacoes']) && !empty($dados_tab['anotacoes'])){
                            ?>
                            <div>
                                <table class="table table-striped" id="tableAnotacoes">
                                    <thead>
                                        <tr>
                                            <td>Data</td>
                                            <td>Protocolo</td>
                                            <td>Setor</td>
                                            <td>Assunto</td>
                                            <td>Anotações</td>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($dados_tab['anotacoes'] as $anotacao) {
                                    ?>
                                    <tr>
                                        <td><?=dataPTBR($anotacao['Data'])?></td>
                                        <td><?=$anotacao['Contador']?></td>
                                        <td><?=$anotacao['SetorDestino']?></td>
                                        <td><?=$anotacao['Assunto']?></td>
                                        <td><?=$anotacao['Anotacao1']?></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <?php
                            }else{
                            ?>
                            -Nenhuma anotação encontrada-
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<?= $this->section('js') ?>
<script>
    $('#tableProtocolos').DataTable({
        "scrollY": "300px", // Define a altura máxima com scroll
        "scrollCollapse": true, // Mantém a tabela ajustada ao conteúdo
        "paging": false, // Desativa a paginação
        "ordering": false, // Ativa a ordenação
        "info": false, // Oculta informações de registros (opcional)
        "language": {
            "search": "Buscar:", // Traduz o campo de busca
            "zeroRecords": "Nenhum registro encontrado"
        }
    }); 

    $('#tableAnotacoes').DataTable({
        "scrollY": "300px", // Define a altura máxima com scroll
        "scrollCollapse": true, // Mantém a tabela ajustada ao conteúdo
        "paging": false, // Desativa a paginação
        "ordering": true, // Ativa a ordenação
        "info": false, // Oculta informações de registros (opcional)
        "language": {
            "search": "Buscar:", // Traduz o campo de busca
            "zeroRecords": "Nenhum registro encontrado"
        }
    }); 
    
</script>
<?= $this->endSection() ?>

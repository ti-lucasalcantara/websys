<?= $this->extend('template/principal') ?>

<?= $this->section('submenu') ?>
    <?= $this->include('registro/_submenu') ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                <?= $this->include('_componentes/select-buscar-pf') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 id="tituloTab"><?=$pf['InscricaoPFId'] ?? '' ?> - <?=$pf['NomePF'] ?? '' ?></h4>
                </div>
                <div class="card-body">
                    <?php
                    if(!$pf){
                    ?>
                    <div class="message-box ">
                        <h5 class="text-secondary">- Nenhum profissional selecionado -</h5>
                        <p class="text-muted" style="font-size: 0.85em;">Por favor, escolha um profissional para exibição dos dados.</p>
                    </div>
                    <?php
                    }else{
                    ?>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='inscricao' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'inscricao')?>">Inscrição</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='dados_pessoais' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'dados_pessoais')?>">Dados Pessoais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='contatos' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'contatos')?>">Endereço/Contatos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='titulos' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'titulos')?>">Títulos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='habilitacoes' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'habilitacoes')?>">Habilitações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='resp_tecnica' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'resp_tecnica')?>">Responsabilidade Técnica</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=$tab=='pasta_virtual' ? 'active' : '' ?>" aria-current="page" href="<?=url_to('registro.pf.tab',($pf['InscricaoPFId'] ?? 0),'pasta_virtual')?>">Pasta Virtual</a>
                        </li>
                    </ul>
                    <div class="tab-content border p-4">
                        <?php   
                            try {
                                echo $this->include('registro/pf/tab_'.$tab);
                            } catch (\Throwable $th) {
                                echo "Falha ao carregar view: [$tab]";
                                echo "<hr>".$th->getMessage();
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
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .message-box {
        padding: 40px;
        border-radius: 12px;
        text-align: center;
    }
    .icon {
        font-size: 50px;
        color: #007bff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function exibirDadosPf(dados){
    //criarSessionInscricaoPFId(dados.InscricaoPFId);
    if (dados && dados.InscricaoPFId) {
        window.location.href = "<?= url_to('registro.pf.tab', ':InscricaoPFId', 'inscricao') ?>".replace(':InscricaoPFId', dados.InscricaoPFId);
    } else {
        console.error("Dados inválidos para redirecionamento.");
    }
}

</script>
<?= $this->endSection() ?>
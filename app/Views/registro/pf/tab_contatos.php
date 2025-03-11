<?php
d($dados_tab);
?>
<form class="">
    <div class="row">
        <div class="col-md-5">
            <fieldset disabled>
                <label for="Endereco" class="form-label">Logradouro</label>
                <input type="text" class="form-control" id="Endereco" value="<?=$dados_tab['endereco']['Endereco']?>">
            </fieldset>
        </div>
        <div class="col-md-3">
            <fieldset disabled>
                <label for="Bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="Bairro" value="<?=$dados_tab['endereco']['Bairro']?>">
            </fieldset>
        </div>
        <div class="col-md-3">
            <fieldset disabled>
                <label for="Cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="Cidade" value="<?=$dados_tab['endereco']['Cidade']?>">
            </fieldset>
        </div>
        <div class="col-md-1">
            <fieldset disabled>
                <label for="Uf" class="form-label">UF</label>
                <input type="text" class="form-control" id="Uf" value="<?=$dados_tab['endereco']['Uf']?>" readonly>
            </fieldset>
        </div>
    </div>
    <hr>

    <div class="row my-2">
        <div class="col-md-2">
            <fieldset disabled>
                <label for="StatusCadastral" class="form-label">Tipo Contato</label>
            </fieldset>
        </div>

        <div class="col-md-2">
            <fieldset disabled>
                <label for="StatusCadastral" class="form-label">Contato</label>
            </fieldset>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md-2">
            <fieldset disabled>
                <input type="text" class="form-control" id="InscricaoPFId" value="Telefone">
            </fieldset>
        </div>

        <div class="col-md-2">
            <fieldset disabled>
                <input type="text" class="form-control" id="InscricaoPFId" value="(31)98672-8035">
            </fieldset>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md-2">
            <fieldset disabled>
                <input type="text" class="form-control" id="InscricaoPFId" value="Telefone">
            </fieldset>
        </div>

        <div class="col-md-2">
            <fieldset disabled>
                <input type="text" class="form-control" id="InscricaoPFId" value="(31)98672-8035">
            </fieldset>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-md-2">
            <fieldset disabled>
                <input type="text" class="form-control" id="InscricaoPFId" value="Telefone">
            </fieldset>
        </div>

        <div class="col-md-2">
            <fieldset disabled>
                <input type="text" class="form-control" id="InscricaoPFId" value="(31)98672-8035">
            </fieldset>
        </div>
    </div>
</form>
<?= $this->section('js') ?>
<?= $this->endSection() ?>

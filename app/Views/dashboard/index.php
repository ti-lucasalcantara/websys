<?= $this->extend('template/principal') ?>

<?= $this->section('submenu') ?>
    <?= $this->include('dashboard/_submenu') ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?= $this->endSection() ?>
<script>
// Exibe o toast se houver dados na sessão
<?php if (session()->has('show_toast')): ?>
    showToast(
        `<?= session()->getFlashdata('title') ?? 'Atenção!' ?>`,
        `<?= session()->getFlashdata('text') ?? '-' ?>`,
        `<?= session()->getFlashdata('type') ?? 'default' ?>`
    );
<?php endif; ?>

</script>
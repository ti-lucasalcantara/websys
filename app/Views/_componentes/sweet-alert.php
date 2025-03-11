<script>
$(function(){
   'use strict'

    <?php
    if (session()->has('show_sweetalert')){
        $type = session()->getFlashdata('type') ?? 'info';
        if($type == 'danger'){
            $type = 'error';
        }
    ?>
    Swal.fire({
        title: `<?=session()->getFlashdata('title') ?? 'Atenção!'?>`,
        icon: `<?=$type?>`,
        html: `<?=session()->getFlashdata('text') ?? ''?>`,
        showCloseButton: true,
        showCancelButton: `<?=session()->getFlashdata('showCancelButton') ?? false?>`,
        focusConfirm: false,
        confirmButtonText: `<?=session()->getFlashdata('confirmButtonText') ?? 'Ok'?>`,
        confirmButtonAriaLabel: "OK",
        cancelButtonText:  `<?=session()->getFlashdata('cancelButtonText') ?? 'Cancelar'?>`,
        cancelButtonAriaLabel: "Cancelar"
    });
    <?php
    }
    ?>

});
</script>
<form action="#" >
    <div class="d-flex align-items-center">
        <div>
            <label for="nome" class="btn-termo-buscar btn btn-sm btn-outline-info" style="width: 80px;">
                <input type="radio" name="filtro" style="display: none;" value="NomePF" id="nome">
                Nome 
            </label>
            <label for="cpf" class="btn-termo-buscar btn btn-sm btn-outline-info" style="width: 80px;">
                <input type="radio" name="filtro" style="display: none;" value="Cpf" id="cpf"> 
                CPF 
            </label>
            <label for="inscricao" class="btn-termo-buscar btn btn-sm btn-outline-info" style="width: 80px;">
                <input type="radio" name="filtro" style="display: none;" value="InscricaoPFId" id="inscricao" checked>
                Inscrição 
            </label>
        </div>
        <div class="ms-2 flex-grow-1">
            <select id="selectBuscarPF" style="width: 100%;">
            <?php
            if(isset($pf) && isset($pf['InscricaoPFId']) && isset($pf['NomePF'])){
            ?>
            <option value="<?=$pf['InscricaoPFId']?>" selected><?=$pf['NomePF']?></option>
            <?php
            }
            ?>
            </select>
        </div>
    </div>
</form>

<!-- <img src="/cache/pf/Foto_493881.JPG" width="150px"> -->

<?= $this->section('css') ?>
<style>
    .input-group-text{
        cursor: pointer;
        font-size: 1em; 
        width: 100px;
        height: 32px;
    }
    .input-group-text:hover{
        background: #000;
        color: #fff;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>

function formatState (state) {
  if (!state.id) {
    return state.text;
  }
  var $state = $(
    `<td width='50px'>${state.id}</td><td width='450px'>${state.text}</td><td width='120px'>${state.Cpf}</td><td>${state.StatusCadastral}</td>`
  ); 
  return $state;
};

function formatStateSelected (state) {
  if (!state.id) {
    return state.text;
  }
  var $state = $(
    `<td width='50px'>${state.id}</td><td>${state.text}</td>`
  );
  return $state;
};

/* 
    $('#selectBuscarPF').on('select2:select', function(e) {
        var data = e.params.data;
        console.log(data);
        $('.select2-selection__rendered').html(`Aqui ${data.text}`);
        // $('#result').html('Text: ' + data.text + '<br>ID: ' + data.id); 
    });
*/

$('#selectBuscarPF').on('select2:select', async function (e) {
    /* console.log('Item selecionado:', e.params.data); */
    // Ao selecionar o PF irá chamar uma funciton que deve exibir o dados do PF selecionado.
    // Essa function deve ser escrita na View que será exibida os dados.
    return await exibirDadosPf(e.params.data);
});

$('#selectBuscarPF').on('change', function (e) {
   /* console.log('Valor alterado:', $(this).val()); */
});

$('#selectBuscarPF').on('select2:selecting', function (e) {
  /* console.log('Item está prestes a ser selecionado:', e.params.args.data); */
});

$('#selectBuscarPF').on('select2:unselect', function (e) {
  /* console.log('Item desselecionado:', e.params.data); */
});

$('#selectBuscarPF').on('select2:close', function (e) {
  /* console.log('Dropdown fechado'); */
});

$('#selectBuscarPF').on('select2:open', function (e) {
  /* console.log('Dropdown aberto'); */
  document.querySelector('.select2-search__field').focus();
});

$("input[name='filtro']").change(function(){
    abrirBuscador();
});

function abrirBuscador(){
    $("label.btn-termo-buscar").removeClass("btn-info").css('color', '#000');
    $("input[name='filtro']:checked").parent().addClass("btn-info").css('color', '#000');;
    
    $("#selectBuscarPF").select2({
        //  theme: "classic", 
        width: 'resolve',
        placeholder: getPlaceholder(),
        ajax: {
            url:  function (params) {
                //return 'buscar-pf/' + params.term;
                return `<?=url_to('pharmakon.pf.buscar')?>`;
            },
            dataType: 'json',
            data: function (params) {
                var p = {
                    termo: $("input[name='filtro']:checked").val(),
                    valor: params.term,
                }
                return p;
            },
            processResults: function (data) {
                //console.log('processResults', data);
                return {
                    results: data
                };
            },
        },
        templateResult: formatState,
        templateSelection: formatStateSelected,
    });

    // Abrir buscador automático
    //$("#selectBuscarPF").select2('open');
}

function getPlaceholder(){
    if ( $("input[name='filtro']:checked").val() == 'InscricaoPFId' ){
        return 'Informe o número de inscrição do profissional';
    }else if ( $("input[name='filtro']:checked").val() == 'Cpf' ){
        return 'Informe o CPF do profissional';
    }else if ( $("input[name='filtro']:checked").val() == 'NomePF' ){
        return 'Informe o nome do profissional';
    }else{
        return '-Selecione-';
    }
}



$(document).ready(function() {
    abrirBuscador();
});
</script>

<?= $this->endSection() ?>



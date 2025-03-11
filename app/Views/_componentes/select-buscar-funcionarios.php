<form action="#" >
    <div class="d-flex align-items-center">
        <div>
            <label for="nomeUsuario" class="btn-termo-buscar btn btn-sm btn-outline-info" style="width: 160px;">
                <input type="radio" name="filtro" style="display: none;" value="nome" id="nomeUsuario" checked>
                Nome do Funcionário
            </label>
        </div>
        <div class="ms-2 flex-grow-1">
            <select id="selectBuscarUsuario" style="width: 100%;"></select>
        </div>
    </div>
</form>
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
    `<td width='70px'>
        <img src='${state.avatar}' class="rounded-circle me-4" style="width: 65px; height: 65px; object-fit: cover; object-position: center top;">
    </td>
    <td>${state.text}<br>${state.login}</td>`
  );
  return $state;
};

function formatStateSelect (state) {
  if (!state.id) {
    return state.text;
  }
  var $state = $(
    `<td>${state.text}</td>`
  );
  return $state;
};

/* 
    $('#selectBuscarUsuario').on('select2:select', function(e) {
        var data = e.params.data;
        console.log(data);
        $('.select2-selection__rendered').html(`Aqui ${data.text}`);
        // $('#result').html('Text: ' + data.text + '<br>ID: ' + data.id); 
    });
*/

$('#selectBuscarUsuario').on('select2:select', async function (e) {
    /* console.log('Item selecionado:', e.params.data); */
    // Ao selecionar o Funcionario irá chamar uma funciton que deve exibir o dados do Funcionario selecionado.
    // Essa function deve ser escrita na View que será exibida os dados.
    return await exibirDadosUsuario(e.params.data);
});

$('#selectBuscarUsuario').on('change', function (e) {
   /* console.log('Valor alterado:', $(this).val()); */
});

$('#selectBuscarUsuario').on('select2:selecting', function (e) {
  /* console.log('Item está prestes a ser selecionado:', e.params.args.data); */
});

$('#selectBuscarUsuario').on('select2:unselect', function (e) {
  /* console.log('Item desselecionado:', e.params.data); */
});

$('#selectBuscarUsuario').on('select2:close', function (e) {
  /* console.log('Dropdown fechado'); */
});

$('#selectBuscarUsuario').on('select2:open', function (e) {
  /* console.log('Dropdown aberto'); */
  document.querySelector('.select2-search__field').focus();
});

$("input[name='filtro']").change(function(){
    abrirBuscador();
});

function abrirBuscador(){
    $("label.btn-termo-buscar").removeClass("btn-info").css('color', '#000');
    $("input[name='filtro']:checked").parent().addClass("btn-info").css('color', '#000');;
    
    $("#selectBuscarUsuario").select2({
        //  theme: "classic", 
        width: 'resolve',
        placeholder: 'Informe o nome do funcionário',
        ajax: {
            url:  function (params) {
                //return 'buscar-pf/' + params.term;
                return `<?=url_to('adm.acl.buscarUsuarios')?>`;
            },
            dataType: 'json',
            data: function (params) {
                var p = {
                    termo: $("input[name='filtro']:checked").val(),
                    valor: params.term,
                }
                //console.log('p',p);
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
        templateSelection: formatStateSelect,
    });

    // Abrir buscador automático
    //$("#selectBuscarUsuario").select2('open');
}

$(document).ready(function() {
    abrirBuscador();
});
</script>

<?= $this->endSection() ?>



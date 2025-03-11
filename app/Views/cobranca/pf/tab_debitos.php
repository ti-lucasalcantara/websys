<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i=2025; $i > 2009; $i--) { 
            $color = $i%3==0 ? 'success' : 'danger';
        ?>
        <tr class="<?=$i==2023 ? 'active_tr' : ''?> text-<?=$color?>">
            <td><?=$i?></td>
            <td><a href="#" style="color:inherit">Anuidade Pessoa Física</a></td>
            <td>R$ 543,08</td>
            <td>6/6</td>
            <td>Quitado <i class="fa fa-check"></i> </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Salary</th>
        </tr>
    </tfoot>
</table>

<!-- 
<div class="row">
    <div class="table-responsive col-6">
        <table class="table table-striped border" id="tableDebitos">
            <thead>
                <tr>
                    <td>Ano</td>
                    <td>Taxa</td>
                    <td>Valor</td>
                    <td>Parecela</td>
                    <td>Status</td>
                </tr>
            </thead>

            <tbody>
                <?php
                for ($i=2025; $i > 2009; $i--) { 
                    $color = $i%3==0 ? 'success' : 'danger';
                ?>
                <tr class="<?=$i==2023 ? 'active_tr' : ''?> text-<?=$color?>">
                    <td><?=$i?></td>
                    <td><a href="#" style="color:inherit">Anuidade Pessoa Física</a></td>
                    <td>R$ 543,08</td>
                    <td>6/6</td>
                    <td>Quitado <i class="fa fa-check"></i> </td>
                </tr>
                <?php
                }
                ?>
            
            </tbody>
        </table>
    </div>
    <div class="col-6 border">
        <div class="text-center my-3">
        <span class="fs-5">Anuidade Pessoa Física (2025)</span>
        </div>
        <hr>
        <table class="table table-striped" id="tableBoletos">
            <thead>
                <tr>
                    <td>Título</td>
                    <td>Parecela</td>
                    <td>Valor</td>
                    <td>Status</td>
                    <td>Info</td>
                    <td>Info</td>
                </tr>
            </thead>

            <tbody>
                <?php
                for ($i=2025; $i > 2009; $i--) { 
                    $color = $i%3==0 ? 'success' : 'danger';
                ?>
                <tr>
                    <td class="text-<?=$color?>">2025001214587001</td>
                    <td>1ª</td>
                    <td>R$ 90,53</td>
                    <td>Quitado <i class="fa fa-check"></i> </td>
                    <td><i class="fa fa-search"></i></td>
                    <td><i class="fa fa-file"></i></td>
                </tr>
                <?php
                }
                ?>
            
            </tbody>
        </table>
    </div>
</div>
 -->

<?= $this->section('css') ?>
<style>
.active_tr{
    background-color: #069 !important;
    color: #FFF !important;
}

#tableDebitos tr:hover{
    background-color: #069 !important;
    color: #FFF !important;
}

#tableDebitos td {
    color: inherit;
    background-color: inherit;
}

#tableBoletos td {
    color: inherit;
}
</style>
<?= $this->endSection() ?>



<?= $this->section('js') ?>
<script>

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        
        return (
            '<dl>' +
            '<dt>Full name:</dt>' +
            '<dd>' +
            d.name +
            '</dd>' +
            '<dt>Extension number:</dt>' +
            '<dd>' +
            d.position +
            '</dd>' +
            '<dt>Extra info:</dt>' +
            '<dd>And any further details here (images etc)...</dd>' +
            '</dl>'
        );
    }

    let table = new DataTable('#example', {
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: ''
            },
            { data: 'name' },
            { data: 'position' },
            { data: 'office' },
            { data: 'salary' }
        ],
        order: [[1, 'asc']],
        rowId: 'id',
        stateSave: true
    });

    // Add event listener for opening and closing details
    table.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = table.row(tr);
    
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
        }
    });
    
    $('#tableDebitos').DataTable({
        "scrollY": "600px", // Define a altura máxima com scroll
        "scrollCollapse": false, // Mantém a tabela ajustada ao conteúdo
        "paging": false, // Desativa a paginação
        "ordering": false, // Ativa a ordenação
        "info": false, // Oculta informações de registros (opcional)
        "autoWidth": true, // Desativa o ajuste automático de largura
        "language": {
            "search": "Buscar:", // Traduz o campo de busca
            "zeroRecords": "Nenhum registro encontrado"
        },
     
    }); 

    $('#tableBoletos').DataTable({
        "scrollY": "600px", // Define a altura máxima com scroll
        "scrollCollapse": false, // Mantém a tabela ajustada ao conteúdo
        "paging": false, // Desativa a paginação
        "ordering": false, // Ativa a ordenação
        "info": false, // Oculta informações de registros (opcional)
        "autoWidth": true, // Desativa o ajuste automático de largura
        "language": {
            "search": "Buscar:", // Traduz o campo de busca
            "zeroRecords": "Nenhum registro encontrado"
        },
    }); 
</script>
<?= $this->endSection() ?>

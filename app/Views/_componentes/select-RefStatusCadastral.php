<?php
use App\Models\Pharmakon\RefStatusCadastralPF AS RefStatusCadastralPFModel;
 
$RefStatusCadastralPF = (new RefStatusCadastralPFModel())->findAll();

if(!isset($StatusCadastralIdSelected)){
    if( isset($dados_tab['StatusCadastralId']) ){
        $StatusCadastralIdSelected = $dados_tab['StatusCadastralId'];
    }
}
?>

<select class="form-control">
<?php	
if(isset($RefStatusCadastralPF) && !empty($RefStatusCadastralPF)){
    foreach ($RefStatusCadastralPF as $row) {
?>
<option value="<?=$row['StatusCadastralId']?>" <?=isset($StatusCadastralIdSelected) && $StatusCadastralIdSelected == $row['StatusCadastralId'] ? 'selected' : ''?>><?=$row['StatusCadastral']?></option>
<?php	
    }
}
?>
</select>

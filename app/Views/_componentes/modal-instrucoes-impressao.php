<style>
.instruction {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}
.instruction img {
    margin-left: 20px;
    border: 1px solid #ccc;
    padding: 5px;
    width: 300px; 
}
</style>

<button type="button" class="btn btn-info btn-sm "
    data-bs-placement="top"
    data-bs-custom-class="custom-tooltip"
    data-bs-title="Instruções de impressão"
    data-bs-toggle="modal"
    data-bs-target="#modalInstrucoesImpressao">
    como imprimir ?
</button>
                                    
<!-- Modal -->
<div class="modal fade" id="modalInstrucoesImpressao" tabindex="-1" aria-labelledby="modalInstrucoesImpressaoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalInstrucoesImpressaoLabel">Instruções de Impressão</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="instruction">
            <p><strong>1. Para imprimir o AR (Aviso de Recebimento):</strong><br>
            Selecione o tamanho do papel <strong>ENVELOPE DL</strong>.</p>
            <br>
            <img src="/coffin/assets/imagens/instrucoes/dl.jpg"  alt="Exemplo de seleção de papel ENVELOPE DL">
        </div>

        <div class="instruction">
            <p><strong>2. Para imprimir envelopes (PARDO):</strong><br>
            Selecione o tamanho do papel <strong>ENVELOPE C5</strong>.</p>
            <img src="/coffin/assets/imagens/instrucoes/c5.png" style="width:350px" alt="Exemplo de seleção de papel ENVELOPE C5">
        </div>

        <div class="instruction">
            <p><strong>3. Para imprimir envelopes (BRANCO):</strong><br>
            Selecione o tamanho do papel <strong>ENVELOPE DL</strong>.</p>
            <img src="/coffin/assets/imagens/instrucoes/dl.jpg" style="width:350px" alt="Exemplo de seleção de papel ENVELOPE DL">
        </div>

        <div class="instruction">
            <p><strong>4. Para imprimir notificações e ofícios de cobrança:</strong><br>
            Selecione o tamanho do papel <strong>A4</strong>.</p>
            <img src="/coffin/assets/imagens/instrucoes/a4.png" style="width:350px" alt="Exemplo de seleção de papel A4">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- \Modal -->
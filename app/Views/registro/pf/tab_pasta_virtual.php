    <!-- Botões de Manipulação -->
    <div class="row border py-2">
        <div class="col">
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary" onclick="addPage()">
                        <i class="fa fa-file-medical"></i> Incluir Página
                    </button>
                    <button class="btn btn-outline-danger" onclick="deletePage()">
                        <i class="fa fa-trash"></i> Excluir Página
                    </button>
                    <button class="btn btn-outline-warning" onclick="reorderPages()">
                        <i class="fa fa-random"></i> Reordenar Página
                    </button>
                    <button class="btn btn-outline-success" onclick="downloadPage()">
                        <i class="fa fa-file-download"></i> Download Página
                    </button>
                    <button class="btn btn-outline-dark" onclick="downloadFolder()">
                        <i class="fa fa-folder-open"></i> Download Pasta Completa
                    </button>
                </div>
            </div>
        </div>
    </div>
   
    <div class="row">
        <!-- PDF Viewer -->
        <div class="col-md-2 border">
            <h5>Páginas</h5>
            <div id="pdfThumbnails" class="d-flex flex-wrap gap-2"></div>
        </div>

        <div class="col-md-10 border">
            
        <div id="controls">
            <button onclick="prevPage()">Anterior</button>
            <span>Página <span id="page_num"></span> de <span id="page_count"></span></span>
            <button onclick="nextPage()">Próxima</button>
        </div>
        <div id="pdf-container">
            <canvas id="pdf-canvas"></canvas>
        </div>
        
        </div>

        <!-- Miniaturas das Páginas -->
       
    </div>


<?= $this->section('css') ?>
<style>
    #pdf-container {
        text-align: center;
        margin: 20px auto;
    }
    canvas {
        border: 1px solid #ccc;
        width: 100%;
        max-width: 800px;
    }
    #controls {
        margin-bottom: 10px;
    }
</style>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script src="/websys/assets/plugins/pdfjs/build/pdf.mjs" type="module"></script>

<script>
    import('/websys/assets/plugins/pdfjs/build/pdf.mjs').then(pdfjsLib => {
        console.log("PDF.js carregado!", pdfjsLib);

        // Definir o caminho para o worker
        pdfjsLib.GlobalWorkerOptions.workerSrc = '/websys/assets/plugins/pdfjs/build/pdf.worker.mjs';

        const url = "/websys/ged/um.pdf";
        let pdfDoc = null,
            pageNum = 1,
            canvas = document.getElementById("pdf-canvas"),
            ctx = canvas.getContext("2d");

        // Carregar o documento PDF
        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc = pdf;
            document.getElementById("page_count").textContent = pdf.numPages;
            renderPage(pageNum);
        });

        // Função para renderizar a página
        function renderPage(num) {
            pdfDoc.getPage(num).then(page => {
                let viewport = page.getViewport({ scale: 1.5 });
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                let renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                page.render(renderContext);
            });

            document.getElementById("page_num").textContent = num;
        }

        // Função para ir para a página anterior
        window.prevPage = function() {
            if (pageNum <= 1) return;
            pageNum--;
            renderPage(pageNum);
        };

        // Função para ir para a próxima página
        window.nextPage = function() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            renderPage(pageNum);
        };
    });
</script>

<?= $this->endSection() ?>

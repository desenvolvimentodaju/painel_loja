<!-- Modal subir arquivos -->
<div class="modal fade" id="exampleModalUpPlanilhas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="exampleModalLabel">Upload Arquivos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="upload_arquivo.php" method="post" enctype="multipart/form-data" name="bases">
                <div  class="d-flex flex-row align-items-center">
                    <!-- Selecionar qual base está subindo -->
                    <select class="custom-select w-20 ml-3" name="base" required>
                        <option disabled selected>Base</option>
                        <option value="1">Base Margem</option>
                        <option value="2">Metas Diárias</option>
                        <option value="3">Metas Semana</option>
                        <option value="4">Metas Tkm</option>
                        <option value="5">Metas margem</option>
                        <option value="6">Fluxo de entrada</option>
                        <option value="7">Sob medida</option>
                    </select>
                    <!-- Fim select -->
                    <!-- Upload de arquivo -->
                    <div class="modal-body">
                        <input type="file" name="arquivo" accept=".csv">
                    </div>
                    <!-- Fim Upload de arquivo -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" value="enviar">Salvar mudanças</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fim modal subir arquivos -->
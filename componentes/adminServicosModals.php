
  <!-- Nova Categoria Modal -->
  <div class="modal fade" id="NovaCategoriaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="NovaCategoriaModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
              <div class="mb-3">
                  <label for="nova_categoria" class="form-label">Criar Nova Categoria:</label>
                  <input type="text" class="form-control" id="nova_categoria" name="nova_categoria" placeholder="Insira o nome da nova categoria">
              </div>
              <button type="submit" class="btn btn-primary mb-3">Adicionar Categoria</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
          <?php if (isset($_GET['categoria_criada']) && $_GET['categoria_criada'] === 'true'): ?>
          <div class="alert alert-success mt-4" role="alert">
              Categoria criada com sucesso!
          </div>
          <?php endif; ?>
      </div>
    </div>
  </div>


  <!-- Modal NOVO Serviço -->
  <div class="modal fade" id="NovoServico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header text-center">
              <h1 class="modal-title w-100 fs-5" id="NovoServicoLabel">Novo Serviço</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
              <div class="modal-body">
                  <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                      <input type="hidden" name="action" value="add">
                      <div class="col-md-12">
                          <label for="titulo" class="form-label ">Título:</label>
                          <input type="text" class="form-control" name="titulo" placeholder="Título" required>
                      </div>
                      <div class="col-md-4">
                          <label for="duracao" class="form-label">Duração (minutos):</label>
                          <input type="number" class="form-control" name="duracao" placeholder="0" required>
                      </div>
                      <div class="col-md-4">
                          <label for="valor" class="form-label">Valor (R$):</label>
                          <input type="number" step="0.01" class="form-control" name="valor" placeholder="0.00" required>
                      </div>
                      <div class="col-md-4">
                          <label for="codigo" class="form-label">Código do Serviço:</label>
                          <input type="text" class="form-control" name="codigo" placeholder="Ex: SRV123" required>
                      </div>
                      <div class="col-md-12">
                          <label for="imagem" class="form-label">Imagem:</label>
                          <input type="file" class="form-control" name="imagem" required>
                      </div>
                      <div class="col-md-12">
                          <label for="descricao" class="form-label">Descrição:</label>
                          <textarea class="form-control" name="descricao" rows="2" placeholder="Insira a Descrição" required></textarea>
                      </div>
                      <div class="col-md-12">
                          <label for="observacao" class="form-label">Observação:</label>
                          <textarea class="form-control" name="observacao" rows="2" placeholder="Insira sua Observação"></textarea>
                      </div>
                      <div class="col-md-12 text-center">
                          <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal">Fechar</button>
                          <button type="submit" class="btn btn-success">Adicionar</button>  
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal de Atualização -->
  <div class="modal fade" id="AtualizarServico<?= $servico['id'] ?>" tabindex="-1" aria-labelledby="AtualizarServicoLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header text-center">
                  <h5 class="modal-title w-100" id="AtualizarServicoLabel">Atualizar Serviço</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
                      <input type="hidden" name="action" value="update">
                      <input type="hidden" name="id" value="<?= $servico['id'] ?>">
                      <input type="hidden" name="existing_imagem" value="<?= $servico['imagem'] ?>">

                      <div class="col-md-12">
                          <label for="titulo" class="form-label">Título:</label>
                          <input type="text" class="form-control" name="titulo" value="<?= $servico['titulo'] ?>" required>
                      </div>
                      <div class="col-md-4">
                          <label for="duracao" class="form-label">Duração (m):</label>
                          <input type="number" class="form-control" name="duracao" value="<?= $servico['duracao'] ?>" required>
                      </div>
                      <div class="col-md-4">
                          <label for="valor" class="form-label">Valor (R$):</label>
                          <input type="number" step="0.01" class="form-control" name="valor" value="<?= $servico['valor'] ?>" required>
                      </div>
                      <div class="col-md-4">
                          <label for="codigo" class="form-label">Código do Serviço:</label>
                          <input type="text" class="form-control" name="codigo" value="<?= $servico['codigo'] ?>" required>
                      </div>
                      <div class="col-md-12">
                          <label for="imagem" class="form-label">Nova Imagem:</label>
                          <input type="file" class="form-control" name="imagem">
                      </div>
                      <div class="col-md-12">
                          <label for="descricao" class="form-label">Descrição:</label>
                          <textarea class="form-control" name="descricao" rows="2" required><?= $servico['descricao'] ?></textarea>
                      </div>
                      <div class="col-md-12">
                          <label for="observacao" class="form-label">Observação:</label>
                          <textarea class="form-control" name="observacao" rows="2"> <?= $servico['observacao'] ?></textarea>
                      </div>
                      <div class="col-md-12 text-center mt-3 mb-3">
                          <button type="submit" class="btn btn-outline-success me-3"><i class="bi bi-floppy2-fill"></i> Salvar</button>
                          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-x-octagon-fill"></i> Cancelar</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <!-- Modal de Confirmação de Deleção -->
  <div class="modal fade" id="DeletarServico<?= $servico['id'] ?>" tabindex="-1" aria-labelledby="DeletarServicoLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body rosa rounded text-center">
                  <p class="text-center fs-5">Deseja excluir o serviço <strong><?= $servico['titulo'] ?></strong>?</p>
                  *Ao excluir este serviço ele será removido permanentemente.
                  <button type="button" class="btn btn-outline-success mt-4 me-3" data-bs-dismiss="modal"><i class="bi bi-backspace"></i>Voltar</button>
                  <form action="" method="POST" style="display:inline;">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= $servico['id'] ?>">
                      <button type="submit" class="btn btn-outline-danger mt-4"><i class="bi bi-trash"></i> Sim</button>
                  </form>
                  
              </div>
          </div>
      </div>
  </div>

  <script>
    // Remover parâmetros da URL após carregar a página
    document.addEventListener('DOMContentLoaded', function () {
        const url = new URL(window.location.href);
        if (url.searchParams.has('categoria_criada')) {
            url.searchParams.delete('categoria_criada');
            window.history.replaceState({}, document.title, url.toString());
        }
    });
</script>

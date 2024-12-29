<?php if (isset($_SESSION['mensagem_erro'])): ?>
        <div id="mensagem-erro" class="alert alert-danger mt-5" role="alert">
            <?= $_SESSION['mensagem_erro'] ?>
        </div>
        <?php unset($_SESSION['mensagem_erro']); ?>
    <?php endif; ?>
    <!-- Mensagem de sucesso -->
    <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
        <div id="mensagem-sucesso" class="alert alert-success mt-5" role="alert">
            <?= $_SESSION['mensagem_sucesso'] ?>
        </div>
        <?php unset($_SESSION['mensagem_sucesso']); ?>
<?php endif; ?>
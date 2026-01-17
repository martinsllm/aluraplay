<?php
use Alura\Mvc\Service\CsrfTokenService;
$this->layout('layout');
$token = CsrfTokenService::generateToken();
?>

<main class="container">
        
    <form class="container__formulario" method="post">
        <h2 class="formulario__titulo">Efetue login</h2>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" />
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="email">Email</label>
                <input name="email" type="email" class="campo__escrita" required
                    placeholder="Digite seu email" id='email' />
            </div>


            <div class="formulario__campo">
                <label class="campo__etiqueta" for="password">Senha</label>
                <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha"
                    id='password' />
            </div>

            <input class="formulario__botao" type="submit" value="Entrar" />

            <div class="alerta-container">
                <?php if($_SESSION['erro']): ?>
                    <div class="alerta">
                        <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
    </form>

</main>

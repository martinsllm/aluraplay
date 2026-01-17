<?php
use Alura\Mvc\Service\CsrfTokenService;
$this->layout('layout');
$token = CsrfTokenService::generateToken();
?>

<main class="container">

    <form class="container__formulario" enctype="multipart/form-data" method="post">
        <h2 class="formulario__titulo">Envie um vídeo!</h2>
        
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>" />
        
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="url">Link embed</label>
                <input name="url"
                        value="<?= $video->url; ?>"
                        class="campo__escrita"
                        required
                        placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g"
                        id='url' />
            </div>

            <div class="formulario__campo">
                <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                <input name="titulo"
                        value="<?= $video->title; ?>"
                        class="campo__escrita"
                        required
                        placeholder="Neste campo, dê o nome do vídeo"
                        id='titulo' />
            </div>

            <div class="formulario__campo">
                <label class="campo__etiqueta" for="image">Imagem do vídeo</label>
                <input name="image"
                        accept="image/*"
                        type="file"
                        class="campo__escrita"
                        id='image' />
            </div>

            <input class="formulario__botao" type="submit" value="Enviar" />

            <div class="alerta-container">
                <?php if($_SESSION['erro']): ?>
                    <div class="alerta">
                        <?= $_SESSION['erro'] ?? 'Ocorreu um erro ao processar sua solicitação.'; unset($_SESSION['erro']); ?>
                    </div>
                <?php endif; ?>
            </div>
    </form>

</main>

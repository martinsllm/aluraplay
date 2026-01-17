<?php 
    $this->layout('layout');
?>

<ul class="videos__container">
    <?php foreach ($videoList as $video): ?>
    <li class="videos__item">
        <?php if($video->getFilePath() !== null): ?>
            <a href="<?= $video->url; ?>">
                <img src="/img/uploads/<?= $video->getFilePath(); ?>" alt="<?= $video->title; ?>">
            </a>
        <?php else: ?>
        <iframe width="100%" height="72%" src="<?= $video->url; ?>"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        <?php endif; ?>
        <div class="descricao-video">
            <h3><?= $video->title; ?></h3>
            <div class="acoes-video">
                <a href="/editar-video?id=<?= $video->id; ?>">Editar</a>
                <a href="/remover-imagem?id=<?= $video->id; ?>">Remover capa</a>
                <a href="/remover-video?id=<?= $video->id; ?>">Excluir</a>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>

<div class="alerta-container">
    <?php if($_SESSION['erro']): ?>
        <div class="alerta">
            <?= $_SESSION['erro'] ?? 'Ocorreu um erro ao processar sua solicitação.'; unset($_SESSION['erro']); ?>
        </div>
    <?php endif; ?>
</div>
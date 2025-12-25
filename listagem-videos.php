<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoList = $pdo->query('SELECT * FROM videos;')->fetchAll(\PDO::FETCH_ASSOC);

$sucesso = filter_input(INPUT_GET, 'sucesso', FILTER_VALIDATE_INT);

?>

<?php include_once 'header.php'; ?>

    <?php if ($sucesso === 1): ?>
        <div style="background-color: green; color: white; padding: 10px; text-align: center;">
            Operação realizada com sucesso!
        </div>
    <?php elseif ($sucesso === 0): ?>
        <div style="background-color: red; color: white; padding: 10px; text-align: center;">
            Erro na operação.
        </div>
    <?php endif; ?>

    <ul class="videos__container">
        <?php foreach ($videoList as $video): ?>
        <li class="videos__item">
            <iframe width="100%" height="72%" src="<?= $video['url']; ?>"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
            <div class="descricao-video">
                <h3><?= $video['title']; ?></h3>
                <div class="acoes-video">
                    <a href="/editar-video?id=<?= $video['id']; ?>">Editar</a>
                    <a href="/remover-video?id=<?= $video['id']; ?>">Excluir</a>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
<?php include_once 'footer.php'; ?>
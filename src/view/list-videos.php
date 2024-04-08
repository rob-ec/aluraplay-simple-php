<?php require_once __DIR__ . "/header.php"; ?>
<?php $systemImagePath = $_ENV['THUMBNAIL_PATH'] ?? "assets/img/thumbs/"; ?>
<ul class="videos__container" alt="videos alura">
    <?php if (isset($videos)): ?>
        <?php foreach ($videos as $video): ?>
            <li class="videos__item">
                <iframe width="100%" height="72%" src="<?= $video->url(); ?>" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                <div class="descricao-video">
                    <img src="<?= $video->imagePath($systemImagePath) ?? "assets/img/logo.png" ;?>" alt="logo canal alura">
                    <h3>
                        <?= $video->title(); ?>
                    </h3>
                    <div class="acoes-video">
                        <a href="<?= "/editar-video?id={$video->id()}"; ?>">Editar</a>
                        <a href="<?= "/remover-imagem-video?id={$video->id()}"; ?>">Remover Imagem</a>
                        <a href="<?= "/excluir-video?id={$video->id()}"; ?>">Excluir</a>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<?php require_once __DIR__ . "/footer.php"; ?>